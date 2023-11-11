<?php
$content = trim(file_get_contents("php://input"));

$contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';

//Receive the RAW post data.

$decoded = json_decode($content, true);

$email = $decoded['email'];

session_start();
$host = "127.0.0.1";
$root = "root";
$password = "";
$db = "ecfdatabase";
$dsn = "mysql:host=$host;dbname=$db";

$pdo = new PDO($dsn, $root, $password);

$sql = "SELECT id FROM users WHERE email ='$email' ";
$res = $pdo->query($sql);
$result = $res->fetch();
if (!is_array($result)) {

  $log = ['response' => "L'utilisateur n'existe pas"];
  $pdo = null;
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  echo json_encode($log);
  return;
}
$user_id = $result[0];

// check table not empty
//
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