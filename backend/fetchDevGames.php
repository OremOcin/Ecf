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

$sql = "SELECT title, description, category_id, delivery_date, engine_id, media_id FROM games WHERE status_id = (SELECT id FROM status WHERE value = 'dev')";

$rows = $pdo->query($sql)->fetchAll();

$games = [];
foreach ($rows as $row) {
  $category_id = $row['category_id'];
  $sql = "SELECT name FROM games_categories WHERE id = '" . $category_id . "'";
  $category = $pdo->query($sql)->fetch();
  $engine_id = $row['engine_id'];
  $sql = "SELECT name FROM engines WHERE id = '" . $engine_id . "'";
  $engine = $pdo->query($sql)->fetch();
  $media_id = $row['media_id'];
  $sql = "SELECT name FROM medias WHERE id = '" . $media_id . "'";
  $media = $pdo->query($sql)->fetch();
  $game = ["title" => $row["title"], "description" => $row["description"], "category" => $category, "engine" => $engine, "media" => $media, "date" => $row["delivery_date"]];
  array_push($games, $game);
}
$log = ['games' => $games];
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
echo json_encode($log);
?>