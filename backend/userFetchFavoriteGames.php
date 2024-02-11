<?php
$content = trim(file_get_contents("php://input"));

$contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';

//Receive the RAW post data.

$decoded = json_decode($content, true);

$email = $decoded['email'];

session_start();
$hostname = 'toto';
$user = 'toto';
$password = 'toto';
$database = 'toto';

$dsn = "mysql:host=$hostname;dbname=$database";

$options = array(
  // See below if you have an error like "Uncaught PDOException: PDO::__construct(): SSL operation failed with code 1. OpenSSL Error messages: error:0A000086:SSL routines::certificate verify failed".
  PDO::MYSQL_ATTR_SSL_CAPATH => '/etc/ssl/certs/',
  // PDO::MYSQL_ATTR_SSL_CA => 'isrgrootx1.pem',
  PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT => true,
);
$pdo = new PDO($dsn, $user, $password, $options);
$pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql = "SELECT id FROM users WHERE email = :email ";
$prepared = $pdo->prepare($sql);
$prepared->bindParam('email', $email, PDO::PARAM_STR);
$prepared->execute();
$ids = [];
foreach ($prepared as $id) {
  array_push($ids, $id);
}
$user_id = $ids[0]['id'];
if (!$prepared || is_null($user_id) || !isset($user_id)) {
  $log = ['response' => "L'utilisateur n'existe pas"];
  $pdo = null;
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  echo json_encode($log);
  return;
}

$sql = "SELECT EXISTS (SELECT 1 FROM games) AS Output";
$res = $pdo->query($sql);
$result = $res->fetch();
if ($result['Output'] == 0) {
  $log = ['response' => "La base de jeux est vide."];
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  echo json_encode($log);
  return;
}

$sql = "SELECT games.id, title, description, weight, engine_id, media_id, status_id, category_id, players, creation_date, delivery_date FROM games LEFT JOIN users_games ON games.id = users_games.game_id WHERE users_games.user_id = '" . $user_id . "';";

$rows = $pdo->query($sql)->fetchAll();
$games = [];

foreach ($rows as $row) {
  $game_id = $row['0'];
  $category_id = $row['category_id'];
  $engine_id = $row['engine_id'];
  $status_id = $row['status_id'];
  $media_id = $row['media_id'];
  $sql_blob_id = "SELECT image_id FROM games_images WHERE game_id = '" . $game_id . "'";
  $blob_result = $pdo->query($sql_blob_id)->fetch();
  $sql_blob = "SELECT image, name FROM images WHERE id = '" . $blob_result[0] . "'";
  $blob = $pdo->query($sql_blob)->fetch();


  $sql = "SELECT name FROM games_categories WHERE id ='$category_id'";
  $res = $pdo->query($sql);
  $result = $res->fetch();
  $category = $result[0];


  $sql = "SELECT name FROM medias WHERE id ='$media_id'";

  $res = $pdo->query($sql);
  $result = $res->fetch();
  $media = $result[0];

  // get status category

  $sql = "SELECT value FROM status WHERE id ='$status_id'";
  $res = $pdo->query($sql);
  $result = $res->fetch();
  $status = $result[0];


  // get engine category

  $sql = "SELECT name FROM engines WHERE id ='$engine_id' ";
  $res = $pdo->query($sql);
  $result = $res->fetch();
  $engine = $result[0];


  $game = [
    "title" => $row['title'],
    "description" => $row['description'],
    "category" => $category,
    "engine" => $engine,
    "status" => $status,
    "media" => $media,
    "weight" => $row['weight'],
    "players" => $row['players'],
    "creation_date" => $row['creation_date'],
    "delivery_date" => $row['delivery_date'],
    'blob' => $blob[0],
    "blob_name" => $blob[1]
  ];
  array_push($games, $game); // On met $game dans $games
}

$log = ['games' => $games];
$pdo = null;
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
echo json_encode($log);
return;
?>