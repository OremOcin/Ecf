<?php
$content = trim(file_get_contents("php://input"));
$contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';
//Receive the RAW post data.
$decoded = json_decode($content, true);
$title = $decoded['title'];

try {
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
    $log = ['response' => 'no_data_found'];
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    echo json_encode($log);
    return;
  }

  $sql = "SELECT id FROM games WHERE title = '" . $title . "'";

  $fetch_game_id = $pdo->query($sql)->fetch();
  $game_id = $fetch_game_id["id"];


  $sql_budget = "SELECT comments, value, date FROM budgets JOIN games_budgets ON budgets.id = games_budgets.budget_id WHERE games_budgets.game_id = '" . $game_id . "'";
  $budgets = $pdo->query($sql_budget)->fetchAll();
  $log = ['response' => $budgets];

  $pdo = null;
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  echo json_encode($log);
  return;


} catch (PDOException $e) {
  $log = ['exception' => 'budgets table insert failed'];
  $pdo = null;
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  echo json_encode($log);
  return;
}
?>