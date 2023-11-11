<?php
session_start();
$host = "127.0.0.1";
$root = "root";
$password = "";
$db = "ecfdatabase";
$dsn = "mysql:host=$host;dbname=$db";

$pdo = new PDO($dsn, $root, $password);


$sql = "SELECT EXISTS (SELECT 1 FROM news) AS Output";
$res = $pdo->query($sql);
$result = $res->fetch();
if ($result['Output'] == 0) {
  $_SESSION['message'] = "La base de news est vide.";
  $log = ['news' => []];
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  echo json_encode($log);
  return;
}

$sql = "SELECT title, content, image, date FROM news ORDER BY date DESC ";

$rows = $pdo->query($sql)->fetchAll();

$news = [];
foreach ($rows as $row) {
  $title = $row['title'];
  $content = $row['content'];
  $image = $row['image'];
  $date = $row['date'];
  $new = [
    'title' => $title,
    'content' => $content,
    'image' => $image,
    'date' => $date
  ];
  array_push($news, $new);
}
$log = ['news' => $news];
$pdo = null;
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
echo json_encode($log);
return;
?>