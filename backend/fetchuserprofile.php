<?php

$content = trim(file_get_contents("php://input"));

$contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';


//Receive the RAW post data.

$decoded = json_decode($content, true);

function validateEmail($email)
{
  return filter_var($email, FILTER_VALIDATE_EMAIL);
}


//If json_decode failed, the JSON is invalid.
if (is_array($decoded)) {

  $email = $decoded['email'];

  if (is_null($email) || empty($email) || !validateEmail($email)) {
    $log = ['error' => 'email_not_valid', 'email' => $email];
    $pdo = null;
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    echo json_encode($log);
    return;
  }

  session_start();
  $hostname = '3yndg5.stackhero-network.com';
  $user = 'root';
  $password = 'bi1MqEy6wwdk5TwQOvlleCRGLsPmzecJ';
  $database = 'ecfdatabase'; // Vous ne devez pas utiliser la base de données "root". Ceci est juste pour l'exemple. La méthode recommandée est de créer une base de données dédiée (et un utilisateur) dans PhpMyAdmin et de l'utiliser ensuite ici.

  $dsn = "mysql:host=$hostname;dbname=$database";

  $options = array(
      // See below if you have an error like "Uncaught PDOException: PDO::__construct(): SSL operation failed with code 1. OpenSSL Error messages: error:0A000086:SSL routines::certificate verify failed".
    PDO::MYSQL_ATTR_SSL_CAPATH => '/etc/ssl/certs/',
      // PDO::MYSQL_ATTR_SSL_CA => 'isrgrootx1.pem',
    PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT => true,
  );

  try {
    $pdo = new PDO($dsn, $user, $password, $options);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT avatar,pseudo,firstname,lastname,role_id FROM users WHERE email ='" . $email . "';";

    // user exists ?
    try {
      $result = $pdo->query($sql)->fetch();

      if (!is_array($result)) {
        $log = ['error' => 'user_not_found'];
        $pdo = null;
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');
        echo json_encode($log);
        return;
      }
      // role?
      $role_id = $result['role_id'];
      $sql = "SELECT name FROM roles WHERE id = '$role_id' ";
      $roleName = $pdo->query($sql)->fetch();
      if (!is_array($roleName)) {
        $log = ['error' => 'role_not_found'];
        $pdo = null;
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');
        echo json_encode($log);
        return;
      }
      $role = $roleName['name'];
      $user = [];
      if (is_null($result['avatar'])) {
        $user = [
          'role' => $role,
          'email' => $email,
          'firstname' => $result['firstname'],
          'pseudo' => $result['pseudo'],
          'lastname' => $result['lastname'],
        ];
      } else {
        $user = [
          'role' => $role,
          'email' => $email,
          'firstname' => $result['firstname'],
          'pseudo' => $result['pseudo'],
          'lastname' => $result['lastname'],
          'avatar' => $result['avatar']
        ];
      }
      $log = ['response' => $user];
      $pdo = null;
      header('Access-Control-Allow-Origin: *');
      header('Content-Type: application/json');
      echo json_encode($log);
      return;

    } catch (PDOException $e) {
      $pdo = null;
      $log = ["exception" => $e->getMessage(), 'sql' => $sql];
      header('Access-Control-Allow-Origin: *');
      header('Content-Type: application/json');
      echo json_encode($log);
      return;
    }
  } catch (PDOException $e) {
    $pdo = null;
    $log = ["exception" => "exception occured"];
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    echo json_encode($log);
    return;
  }
}
$log = ["error" => "fetch_failed"];
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
echo json_encode($log);



?>