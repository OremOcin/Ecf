<?php
$content = trim(file_get_contents("php://input"));
$contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';
//Receive the RAW post data.
$decoded = json_decode($content, true);
$title = $decoded['title'];
$comments = $decoded['comments'];
$date = $decoded['date'];
$value = $decoded['value'];

try {
  session_start();
  $host = "toto";
  $root = "toto";
  $password = "toto";
  $db = "toto";
  $dsn = "mysql:host=$host;dbname=$db";

  $pdo = new PDO($dsn, $root, $password);
  $sql = "SELECT id FROM games WHERE title = '".$title."'";
  $result = $pdo->query($sql)->fetch();
  if(!is_array($result) || count($result) == 0) {
    $log = ['response' => 'removing budget error : game not found'];
    $pdo = null;
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    echo json_encode($log);
    return; 
  } 
  $game_id = $result["id"];
  $sql = "DELETE FROM budgets WHERE id = (SELECT budgets.id FROM budgets ";
  $sql .= "JOIN games_budgets ";
  $sql .= "ON budgets.id = games_budgets.budget_id ";
  $sql .= "WHERE games_budgets.game_id = '" . $game_id . "' AND budgets.value = '" . $value . "' AND budgets.comments = '" . $comments . "' AND budgets.date = '" . $date . "');";
  $result = $pdo->query($sql)->fetch();
  $log = ['response' => $sql];
  $pdo = null;
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  echo json_encode($log);
  return;
} catch (PDOException $e) {
  $log = ['exception' => $e->getMessage(), 'sql' => $sql];
  $pdo = null;
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  echo json_encode($log);
  return;
}
?>