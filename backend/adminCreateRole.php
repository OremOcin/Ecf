<?php

$content = trim(file_get_contents("php://input"));

$contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';

//Receive the RAW post data.

$decoded = json_decode($content, true);


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
$host = '127.0.0.1';
$root = 'root';
$password = 'toto';
$db = 'toto';
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
  $role = $decoded['role'];



  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) { // invalid emailaddress 
    $pdo = null;
    $log = ['response' => "Email is not valid."];
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    echo json_encode($log);
    return;
  }
  $pwd = $decoded['pwd'];

  $err = "";

  /* if (strlen($pwd) <= '8') {
     $err .= "Your Password Must Contain At Least 8 Digits !";
   } elseif (!preg_match("#[0-9]+#", $pwd)) {
     $err .= "Your Password Must Contain At Least 1 Number !";
   } elseif (!preg_match("#[A-Z]+#", $pwd)) {
     $err .= "Your Password Must Contain At Least 1 Capital Letter !";
   } elseif (!preg_match("#[a-z]+#", $pwd)) {
     $err .= "Your Password Must Contain At Least 1 Lowercase Letter !";
   } elseif (!preg_match("/['^£$%&*()}{@!#~?><>,|=+¬-]/", $pwd)) {
     $err .= "Your Password Must Contain At Least 1 Special Character !";
   }*/

  if (!empty($err)) {
    $pdo = null;
    $log = ['response' => $err];
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    echo json_encode($log);
    return;
  }

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
    $role_id = "";
    try {
      $sql = "SELECT id FROM roles WHERE name ='$role'";
      $res = $pdo->query($sql);
      $result = $res->fetch();
      $role_id = $result['id'];
    } catch (PDOException $e) {
      $log = ['response' => 'role not found'];
      $pdo = null;
      header('Access-Control-Allow-Origin: ');
      header('Content-Type: application/json');
      echo json_encode($log);
      return;
    }
    if (empty($role_id)) {
      $log = ['response' => 'role not found'];
      $pdo = null;
      header('Access-Control-Allow-Origin:');
      header('Content-Type: application/json');
      echo json_encode($log);
      return;
    }
    $hash_password = password_hash($pwd, CRYPT_BLOWFISH);
    $sql = "INSERT INTO users (id, role_id, lastname, firstname, email, hash_password, creation_date) VALUES (UUID(),'$role_id', '$name', '$firstname', '$email', '$hash_password', NOW()) ";
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