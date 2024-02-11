<?php
$content = trim(file_get_contents("php://input"));

$contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';

//Receive the RAW post data.

$decoded = json_decode($content, true);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
$hostname = 'toto';
$user = 'toto';
$password = 'toto';
$database = 'toto'; // Vous ne devez pas utiliser la base de données "root". Ceci est juste pour l'exemple. La méthode recommandée est de créer une base de données dédiée (et un utilisateur) dans PhpMyAdmin et de l'utiliser ensuite ici.

$dsn = "mysql:host=$hostname;dbname=$database";

$options = array(
    // See below if you have an error like "Uncaught PDOException: PDO::__construct(): SSL operation failed with code 1. OpenSSL Error messages: error:0A000086:SSL routines::certificate verify failed".
  PDO::MYSQL_ATTR_SSL_CAPATH => '/etc/ssl/certs/',
    // PDO::MYSQL_ATTR_SSL_CA => 'isrgrootx1.pem',
  PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT => true,
);

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
    $pdo = new PDO($dsn, $user, $password, $options);
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