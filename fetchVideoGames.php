<?php
$content = trim(file_get_contents("php://input"));
if (isset($content)) {
  $contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';

  $decoded = json_decode($content, true);
  if (isset($decoded) && !is_null($decoded) && is_array($decoded)) {
    $email = array_key_exists("email", $decoded) ? $decoded['email'] : null;
    $device = array_key_exists("device", $decoded) ? $decoded['device'] : null;
    $engine = array_key_exists("engine", $decoded) ? $decoded['engine'] : null;
    $status = array_key_exists("status", $decoded) ? $decoded['status'] : null;
    $type = array_key_exists("type", $decoded) ? $decoded['type'] : null;
    $fav = array_key_exists("fav", $decoded) ? $decoded['fav'] : null;
    $weight = array_key_exists("weight", $decoded) ? $decoded['weight'] : null;
    $delivery_date = array_key_exists("delivery_date", $decoded) ? $decoded['delivery_date'] : null;
  }
}
session_start();
$host = "127.0.0.1";
$root = "root";
$password = "";
$db = "ecfdatabase";
$dsn = "mysql:host=$host;dbname=$db";

$pdo = new PDO($dsn, $root, $password);


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
$WHERE = "";
$WHEREIsActive = false;
if (!empty($engine)) {
  $WHEREIsActive = true;
  $sql = "SELECT id FROM engines WHERE name ='" . $engine . "'";
  $res = $pdo->query($sql);
  $result = $res->fetch();
  $engine_id = $result[0];
  $WHERE = " WHERE engine_id = '" . $engine_id . "'";
}

if (!empty($device)) {
  $sql = "SELECT id FROM medias WHERE name ='" . $device . "'";
  $res = $pdo->query($sql);
  $result = $res->fetch();
  $device_id = $result[0];

  if ($WHEREIsActive) { // Début
    $WHERE = $WHERE . " AND ";
  } else { //A faire sur les trois autres qui suivent.
    $WHERE = " WHERE ";
  }
  $WHERE = $WHERE . " media_id = '" . $device_id . "'"; //Fin
}
if (!empty($status)) {
  $sql = "SELECT id FROM status WHERE value ='" . $status . "'";
  $res = $pdo->query($sql);
  $result = $res->fetch();
  $status_id = $result[0];
  if ($WHEREIsActive) { // Début
    $WHERE = $WHERE . " AND ";
  } else { //A faire sur les trois autres qui suivent.
    $WHERE = " WHERE ";
  }
  $WHERE = $WHERE . " status_id = '" . $status_id . "'"; //Fin
}

if (!empty($type)) {
  $sql = "SELECT id FROM games_categories WHERE name ='" . $type . "'";
  $res = $pdo->query($sql);
  $result = $res->fetch();
  $type_id = $result[0];

  if ($WHEREIsActive) { // Début
    $WHERE = $WHERE . " AND ";
  } else { //A faire sur les trois autres qui suivent.
    $WHERE = " WHERE ";
  }
  $WHERE = $WHERE . " category_id = '" . $type_id . "'"; //Fin
}
$ORDERBY = "";
$isOrderBy = false;
if (!empty($weight)) {
  $isOrderBy = true;
  $ORDERBY = " ORDER BY weight " . $weight;
}
if (!empty($delivery_date)) {
  if ($isOrderBy) {
    $ORDERBY = $ORDERBY . ", delivery_date " . $delivery_date;
  } else {
    $ORDERBY = " ORDER BY delivery_date " . $delivery_date;
  }
}

if (!isset($email) || is_null($email) || empty($email)) {
  $sql = "SELECT * FROM games";
  $sql = $sql . $WHERE;
  $sql = $sql . $ORDERBY;
  $rows = $pdo->query($sql)->fetchAll();
  $games = [];
  foreach ($rows as $row) {
    $game_id = $row['id'];
    $category_id = $row['category_id'];
    $engine_id = $row['engine_id'];
    $status_id = $row['status_id'];
    $media_id = $row['media_id'];

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
      'blob' => $blob[0],
      "blob_name" => $blob[1]
    ];
    array_push($games, $game); // On met $game dans $games
  }
  $log = ['sql' => $sql, 'games' => $games];
  $pdo = null;
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  echo json_encode($log);
  return;
}
$sql = "SELECT * FROM games ";
$sql = $sql . $WHERE;
$sql = $sql . $ORDERBY;
$globalsql = $sql;
$log = ['sql' => $globalsql];

/* $pdo = null;
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
echo json_encode($log);
return; */

$rows = $pdo->query($sql)->fetchAll();


$games = [];
foreach ($rows as $row) {

  $game_id = $row['id'];
  $category_id = $row['category_id'];
  $engine_id = $row['engine_id'];
  $status_id = $row['status_id'];
  $media_id = $row['media_id'];

  //get score of this game : 
  $sql_score = "SELECT COUNT(*) FROM users_games WHERE game_id = '$game_id'";
  $score_result = $pdo->query($sql_score)->fetch();
  $score = $score_result[0];

  $sql_budget = "SELECT COUNT(*) FROM games_budgets WHERE game_id = '$game_id'";
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

  //CHECK IF GAME IS FAVORITE
  $sql = "SELECT id FROM users WHERE email ='$email' ";
  $res = $pdo->query($sql);
  $result = $res->fetch();
  if (!is_array($result)) {

    $log = ['response' => "L'utilisateur n'existe pas"];
    $pdo = null;
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    echo json_encode($log);
    return;
  }
  $user_id = $result[0];


  $sql = "SELECT COUNT(*) FROM users_games WHERE game_id ='$game_id' AND user_id = '$user_id'";
  $res = $pdo->query($sql);
  $result = $res->fetch();
  $favorite = (bool) $result[0];
  $game = [
    "favorite" => $favorite,
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
$log = ['games' => $games, 'sql' => $globalsql, 'rows' => $rows];
$pdo = null;
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
echo json_encode($log);
return;

try {
} catch (PDOException $e) {
  $log = ['response' => 'budgets table insert failed'];
  $pdo = null;
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  echo json_encode($log);
  return;
}
?>