<?php
$content = trim(file_get_contents("php://input"));
$contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';
//Receive the RAW post data.
$decoded = json_decode($content, true);
$title = $decoded['title'];

try {
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