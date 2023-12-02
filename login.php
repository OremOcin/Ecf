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
    $hash_password = password_hash($pwd, CRYPT_BLOWFISH);
    $sql = "SELECT firstname, lastname, email, hash_password FROM users WHERE email = '" . $email . "';";
    echo $sql;
    $result = $pdo->query($sql)->fetch($sql);
    if (is_array($result) && count($result)) {
      session_start();
      $_SESSION["username"] = $result["firstname"] . " " . $result["lastname"];
      $_SESSION["email"] = $result["email"];
      $log = ['response' => $e->getMessage()];
      $pdo = null;
      header("Location:" . "index.php");
      header('Access-Control-Allow-Origin: *');
      header('Content-Type: application/json');
      echo json_encode($log);
      return;
    }
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