<?php
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

$pdo = new PDO($dsn, $user, $password, $options);
$pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// check table not empty
$sql = "SELECT EXISTS (SELECT 1 FROM games) AS Output";
$res = $pdo->query($sql);
$result = $res->fetch();
if ($result['Output'] == 0) {
  $_SESSION['message'] = "La base de jeux est vide.";
  $log = ['no_data' => 'no_data_found'];
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  echo json_encode($log);
  return;
}

$sql = "SELECT * FROM games";

$rows = $pdo->query($sql)->fetchAll();


$games = [];
foreach ($rows as $row) {

  $game_id = $row['id'];
  $category_id = $row['category_id'];
  $engine_id = $row['engine_id'];
  $status_id = $row['status_id'];
  $media_id = $row['media_id'];

  //get score of this game : 
  $sql_score = "SELECT COUNT(*) FROM users_games WHERE game_id = '" . $game_id . "'";
  $score_result = $pdo->query($sql_score)->fetch();
  $score = $score_result[0];

  $sql_budget_id = "SELECT budget_id FROM games_budgets WHERE game_id = '" . $game_id . "'";
  $budget_result = $pdo->query($sql_budget_id)->fetch();
  $budget_id = $budget_result[0];

  $sql_budget = "SELECT value FROM budgets WHERE id = '" . $budget_id . "'";
  $budget_result = $pdo->query($sql_budget)->fetch();
  $budget = $budget_result[0];

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
    "last_modified" => $row['last_modified'],
    "delivery_date" => $row['delivery_date'],
    'score' => $score,
    'blob' => $blob[0],
    'budget' => $budget,
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