<?php
$content = trim(file_get_contents("php://input"));

$contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';

//Receive the RAW post data.

$decoded = json_decode($content, true);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
$host = "127.0.0.1";
$root = "root";
$password = "";
$db = "ecfdatabase";
$dsn = "mysql:host=$host;dbname=$db";
try {
  $email = $decoded['email'];
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $log = ['response' => false];
    $pdo = null;
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    echo json_encode($log);
    return;
  }
  $pwd = $decoded['pwd'];
  try {
    $pdo = new PDO($dsn, $root, $password);
    $sql = "SELECT role_id, firstname, lastname, email, hash_password FROM users WHERE email = '" . $email . "';";
    $result = $pdo->query($sql)->fetch();
    if (is_array($result) && count($result)) {
      $hash_password = $result["hash_password"];
      $isSame = password_verify($pwd, $hash_password);
      if (!$isSame) {
        $log = ['response' => false];
        $pdo = null;
        //header("Location:" . "index.php");
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');
        echo json_encode($log);
        return;
      }
      $sql = "SELECT name FROM roles WHERE id = '" . $result["role_id"] . "';";
      $role = $pdo->query($sql)->fetch();
      $user_name = $result["firstname"] . " " . $result["lastname"];
      $user_email = $result["email"];
      if (session_status() !== PHP_SESSION_ACTIVE)
        session_start();
      $_SESSION["username"] = $user_name;
      $_SESSION["email"] = $user_email;
      $_SESSION["role"] = $role["name"];
      $log = ['response' => true, "username" => $user_name, "email" => $user_email, 'isSame' => $isSame, "role" => $role["name"]];
      $pdo = null;
      // header("Location:" . "index.php");
      header('Access-Control-Allow-Origin: *');
      header('Content-Type: application/json');
      echo json_encode($log);
      return;
    } else {
      $log = ['response' => false];
      $pdo = null;
      //header("Location:" . "index.php");
      header('Access-Control-Allow-Origin: *');
      header('Content-Type: application/json');
      echo json_encode($log);
      return;
    }
  } catch (PDOException $e) {
    $log = ['response' => $e->getMessage()];
    $pdo = null;
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    echo json_encode($log);
    return;
  }
} catch (PDOException $e) {
  $log = ['response' => $e->getMessage()];
  $pdo = null;
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  echo json_encode($log);
  return;
}

?>