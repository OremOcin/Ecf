<?php

$content = trim(file_get_contents("php://input"));

$contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';

//Receive the RAW post data.

$decoded = json_decode($content, true);

function validateEmail($email)
{
  return filter_var($email, FILTER_VALIDATE_EMAIL);
}

//Receive the RAW post data.

//If json_decode failed, the JSON is invalid.
if (is_array($decoded)) {

  $email = $decoded['email'];
  $pseudo = $decoded['pseudo'];
  $passwd = $decoded['password'];
  $blob = $decoded['blob'];
  $firstname = $decoded['firstname'];
  $lastname = $decoded['lastname'];
  $currentEmail = $decoded['currentemail'];

  if (is_null($email) || empty($email) || !validateEmail($email)) {
    $log = ['error' => 'email_not_valid'];
    $pdo = null;
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    echo json_encode($log);
    return;
  }
  if (is_null($currentEmail) || empty($currentEmail) || !validateEmail($currentEmail)) {
    $log = ['error' => 'current_email_not_valid'];
    $pdo = null;
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    echo json_encode($log);
    return;
  }
  try {
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
    $pdo = new PDO($dsn, $user, $password, $options);


    $sql = "SELECT id,email FROM users WHERE email ='" . $currentEmail . "'";

    try {
      $res = $pdo->query($sql);
      $result = $res->fetch();
      if (!is_array($result)) {
        $log = ['error' => 'Aucun utilisateur ne correspond à votre demande.'];
        $pdo = null;
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');
        echo json_encode($log);
        return;
      }
      $user_id = $result['id'];
      $hash_password = password_hash($passwd, CRYPT_BLOWFISH);

      $sql = "UPDATE users SET pseudo ='" . $pseudo . "', firstname = '" . $firstname . "', lastname = '" . $lastname . "', email = '" . $email . "', hash_password = '" . $hash_password . "' WHERE id = '" . $user_id . "';";
      if (!empty($blob)) {
        $sql = "UPDATE users SET pseudo ='" . $pseudo . "', avatar = '" . $blob . "', firstname = '" . $firstname . "', lastname = '" . $lastname . "', email = '" . $email . "', hash_password = '" . $hash_password . "' WHERE id = '" . $user_id . "';";
      }
      try {
        $result = $pdo->query($sql)->fetch();

      } catch (PDOException $e) {
        $log = ['exception' => $e->getMessage()];
        $pdo = null;
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');
        echo json_encode($log);
        return;
      }
      if (session_status() !== PHP_SESSION_ACTIVE)
        session_start();
      $_SESSION["username"] = $firstname . " " . $lastname;
      $_SESSION["email"] = $email;
      $log = ['response' => "vos données ont été mises à jour.", "username" => $_SESSION["username"]];
      $pdo = null;
      header('Access-Control-Allow-Origin: *');
      header('Content-Type: application/json');
      echo json_encode($log);
      return;
    } catch (PDOException $e) {
      $pdo = null;
      $log = ["exception" => $e->getMessage()];
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