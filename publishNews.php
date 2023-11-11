<?php

$content = trim(file_get_contents("php://input"));

$contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';

$decoded = json_decode($content, true);

$title = str_replace('"', '\"', $decoded['title']);
$title = str_replace("'", "\'", $title);

$newsContent = str_replace('"', '\"', $decoded['content']);
$newsContent = str_replace("'", "\'", $newsContent);

$image = $decoded['image'];



session_start();
$host = "127.0.0.1";
$root = "root";
$password = "";
$db = "ecfdatabase";
$dsn = "mysql:host=$host;dbname=$db";

$pdo = new PDO($dsn, $root, $password);

$sql = "INSERT INTO news (id,title,content,image,date) VALUES (UUID(), '" . $title . "', '" . $newsContent . "', '" . $image . "', NOW());";

$result = $pdo->exec($sql);

$log = ['response' => $result];
$pdo = null;
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
echo json_encode($log);
?>