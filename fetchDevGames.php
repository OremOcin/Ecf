<?php
session_start();
$host = "127.0.0.1";
$root = "root";
$password = "";
$db = "ecfdatabase";
$dsn = "mysql:host=$host;dbname=$db";

$pdo = new PDO($dsn, $root, $password);

// check table not empty
//
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

$sql = "SELECT * FROM games WHERE status_id = (SELECT id FROM status WHERE value = 'dev')";

$rows = $pdo->query($sql)->fetchAll();


$games = [];
foreach ($rows as $row) {

  $game_id = $row['id'];
  $category_id = $row['category_id'];
  $engine_id = $row['engine_id'];
  $status_id = $row['status_id'];
  $media_id = $row['media_id'];
}
?>