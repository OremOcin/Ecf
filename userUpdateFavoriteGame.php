<?php
$content = trim(file_get_contents("php://input"));

$contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';

//Receive the RAW post data.

$decoded = json_decode($content, true);

$email = $decoded['email'];
$title = $decoded['title'];
$fav = $decoded['fav'];


session_start();
$host = "127.0.0.1";
$root = "root";
$password = "";
$db = "ecfdatabase";
$dsn = "mysql:host=$host;dbname=$db";

$pdo = new PDO($dsn, $root, $password);

try {

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