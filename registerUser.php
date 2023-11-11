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
  function GetUUID()
  {
    global $pdo;
    $sql = "SELECT UUID()";
    $res = $pdo->query($sql);
    $result = $res->fetch();
    return $result['UUID()'];
  }

  $firstname = str_replace('"', '\"', $decoded['firstname']); // Récupérer l'email avec get depuis un autre script
  $name = str_replace('"', '\"', $decoded['name']);
  $email = $decoded['email'];
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) { // invalid emailaddress 
    $pdo = null;
    $log = ['error' => "Email is not valid."];
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    echo json_encode($log);
    return;
  }
  $pwd = $decoded['pwd'];

  /*if (strlen($_POST["password"]) <= '8') {
    $err .= "Your Password Must Contain At Least 8 Digits !"."<br>";
}
elseif(!preg_match("#[0-9]+#",$_POST["password"])) {
    $err .= "Your Password Must Contain At Least 1 Number !"."<br>";
}
elseif(!preg_match("#[A-Z]+#",$_POST["password"])) {
    $err .= "Your Password Must Contain At Least 1 Capital Letter !"."<br>";
}
elseif(!preg_match("#[a-z]+#",$_POST["password"])) {
    $err .= "Your Password Must Contain At Least 1 Lowercase Letter !"."<br>";
}
elseif(!pregmatch('/['^£$%&*()}{@#~?><>,|=+¬-]/', $_POST["password"])) {
    $err .= "Your Password Must Contain At Least 1 Special Character !"."<br>";
}*/

  try {
    $pdo = new PDO($dsn, $root, $password);

    // check table not empty
    //
    $sql = "SELECT email FROM users WHERE email = '$email'";
    $res = $pdo->query($sql);
    $result = $res->fetch();
    if (is_array($result) && count($result) != 0) {
      $pdo = null;
      $log = ['response' => "User already exists."];
      header('Access-Control-Allow-Origin: *');
      header('Content-Type: application/json');
      echo json_encode($log);
      return;
    }
    $hash_password = password_hash($pwd, CRYPT_BLOWFISH);
    $sql = "SELECT id FROM roles WHERE name = 'user'";
    $result = $pdo->query($sql)->fetch();
    $role_id = $result['id'];
    $sql = "INSERT INTO users (id, lastname, firstname, email, role_id, hash_password, creation_date) VALUES (UUID(), '" . $name . "', '" . $firstname . "', '" . $email . "','" . $role_id . "', '" . $hash_password . "', NOW()) ";
    $result = $pdo->exec($sql);

    $pdo = null;
    $log = ['response' => "User successfully inserted."];
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    echo json_encode($log);
    return;
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