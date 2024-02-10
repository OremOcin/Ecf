<?php
$content = trim(file_get_contents("php://input"));

$contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';

//Receive the RAW post data.

$decoded = json_decode($content, true);

$email = $decoded['email'];
$title = $decoded['title'];
$fav = $decoded['fav'];


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
  $sql = "SELECT id FROM games WHERE title = '$title'";
  $result = $pdo->query($sql)->fetch();
  $game_id = $result[0];

  $sql = "SELECT id FROM users WHERE email = '$email'";
  $result = $pdo->query($sql)->fetch();
  $user_id = $result[0];

  if ($fav) {
    $sql = "INSERT INTO users_games(id,user_id,game_id) VALUES(UUID(), '" . $user_id . "', '" . $game_id . "' )";
    $result = $pdo->exec($sql);
  } else {
    $sql = "DELETE FROM users_games WHERE game_id ='$game_id' AND user_id = '$user_id'";
    $result = $pdo->exec($sql);
  }


  $log = ['response' => "Game Favorite Status Updated."];
  $pdo = null;
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
?>