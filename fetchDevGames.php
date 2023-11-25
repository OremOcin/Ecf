<?php
session_start();
$host = "127.0.0.1";
$root = "root";
$password = "";
$db = "ecfdatabase";
$dsn = "mysql:host=$host;dbname=$db";

$pdo = new PDO($dsn, $root, $password);

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