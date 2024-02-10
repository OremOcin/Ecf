<?php
$content = trim(file_get_contents("php://input"));

$contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';

//Receive the RAW post data.

$decoded = json_decode($content, true);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
$hostname = '3yndg5.stackhero-network.com';
$user = 'root';
$password = 'bi1MqEy6wwdk5TwQOvlleCRGLsPmzecJ';
$database = 'ecfdatabase'; // Vous ne devez pas utiliser la base de données "root". Ceci est juste pour l'exemple. La méthode recommandée est de créer une base de données dédiée (et un utilisateur) dans PhpMyAdmin et de l'utiliser ensuite ici.

$dsn = "mysql:host=$hostname;dbname=$database";

$options = array(
    // See below if you have an error like "Uncaught PDOException: PDO::__construct(): SSL operation failed with code 1. OpenSSL Error messages: error:0A000086:SSL routines::certificate verify failed".
  PDO::MYSQL_ATTR_SSL_CAPATH => '/etc/ssl/certs/',
    // PDO::MYSQL_ATTR_SSL_CA => 'isrgrootx1.pem',
  PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT => true,
);

try {
  function GetUUID()
  {
    global $pdo;
    $sql = "SELECT UUID()";
    $res = $pdo->query($sql);
    $result = $res->fetch();
    return $result['UUID()'];
  }

  $title = str_replace('"', '\"', $decoded['title']); // Récupérer l'email avec get depuis un autre script
  $title = str_replace("'", "\'", $title);
  $blob = $decoded['blob'];
  $blob_name = $decoded['blob_name'];
  $weight = $decoded['weight']; // Récupérer l'email avec get depuis un autre script
  $description = str_replace('"', '\"', mb_convert_encoding($decoded['description'], "UTF-8")); // Récupérer l'email avec get depuis un autre script
  $description = str_replace("'", "\'", $description);
  $device = $decoded['device']; // Récupérer l'email avec get depuis un autre script
  $engine = $decoded['engine']; // Récupérer l'email avec get depuis un autre script
  $status = $decoded['status']; // Récupérer l'email avec get depuis un autre script
  $type = $decoded['type']; // Récupérer l'email avec get depuis un autre script
  $creation_date = $decoded['creation_date']; // Récupérer l'email avec get depuis un autre script
  $end_creation = $decoded['end_creation']; // Récupérer l'email avec get depuis un autre script
  $budget = $decoded['total-budget']; // Récupérer l'email avec get depuis un autre script
  $players = $decoded['players']; // Récupérer l'email avec get depuis un autre script
  try {
    $pdo = new PDO($dsn, $user, $password, $options);

    // check table not empty
    //
    $sql = "SELECT EXISTS (SELECT 1 FROM games) AS Output";
    $res = $pdo->query($sql);
    $result = $res->fetch();
    if ($result['Output'] != 0) {

      $sql = "SELECT title FROM games WHERE title = '$title' ";

      $res = $pdo->query($sql);
      $result = $res->fetch();

      if (is_array($result) == true) {
        $log = ['response' => "Insertion impossible, le jeu existe déjà."];
        $pdo = null;
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');
        echo json_encode($log);
        return;
      }
    }

    // update budgets table

    $budget_id = '';
    try {
      $budget_id = GetUUID();
      $sql = "INSERT INTO budgets (id,value,comments,date) VALUES('$budget_id','$budget','initial estimated budget',NOW())";
      $result = $pdo->exec($sql);
    } catch (PDOException $e) {
      $log = ['response' => 'budgets table insert failed'];
      $pdo = null;
      header('Access-Control-Allow-Origin: *');
      header('Content-Type: application/json');
      echo json_encode($log);
      return;
    }

    $category_id = "";
    try {
      $sql = "SELECT name,id FROM games_categories WHERE name ='$type'";
      $res = $pdo->query($sql);
      $result = $res->fetch();



      if ((!is_array($result) || count($result) == 0)) {
        $log = ['response' => 'category_id not found'];
        $pdo = null;
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');
        echo json_encode($log);
        return;
      }

      $category_id = $result['id'];
    } catch (PDOException $e) {
      $log = ['response' => 'category_id not found'];
      $pdo = null;
      header('Access-Control-Allow-Origin: *');
      header('Content-Type: application/json');
      echo json_encode($log);
      return;
    }



    // get medium category

    $media_id = "";
    try {
      $sql = "SELECT name,id FROM medias WHERE name ='$device'";

      $res = $pdo->query($sql);
      $result = $res->fetch();

      if ((!is_array($result) || count($result) == 0)) {
        $log = ['response' => 'media_id not found'];
        $pdo = null;
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');
        echo json_encode($log);
        return;
      }


      $media_id = $result['id'];

    } catch (PDOException $e) {
      $log = ['response' => 'media_id not found'];
      $pdo = null;
      header('Access-Control-Allow-Origin: *');
      header('Content-Type: application/json');
      echo json_encode($log);
      return;
    }

    // get status category

    $status_id = "";
    try {
      $sql = "SELECT value,id FROM status WHERE value ='$status'";
      $res = $pdo->query($sql);
      $result = $res->fetch();

      if ((!is_array($result) || count($result) == 0)) {
        $log = ['response' => 'status_id not found'];
        $pdo = null;
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');
        echo json_encode($log);
        return;
      }
      $status_id = $result['id'];

    } catch (PDOException $e) {
      $log = ['response' => 'status_id not found'];
      $pdo = null;
      header('Access-Control-Allow-Origin: *');
      header('Content-Type: application/json');
      echo json_encode($log);
      return;
    }

    // get engine category

    $engine_id = "";
    try {

      $sql = "SELECT name,id FROM engines WHERE name ='$engine' ";
      $res = $pdo->query($sql);
      $result = $res->fetch();
      if (!is_array($result) || count($result) == 0) {
        $log = ['response' => 'engine_id not found'];
        $pdo = null;
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');
        echo json_encode($log);
        return;
      }
      $engine_id = $result['id'];

    } catch (PDOException $e) {
      $log = ['response' => 'engine_id not found'];
      $pdo = null;
      header('Access-Control-Allow-Origin: *');
      header('Content-Type: application/json');
      echo json_encode($log);
      return;
    }

    // insert game into games db

    $game_id = '';
    try {
      $delivery_date = str_replace('-', '/', $end_creation);
      $game_id = GetUUID();
      $sql = "INSERT INTO games (id,engine_id,media_id,category_id,status_id,title,description,weight,players,creation_date,delivery_date,last_modified ) VALUES ('" . $game_id . "','" . $engine_id . "','" . $media_id . "','" . $category_id . "','" . $status_id . "','" . $title . "','" . $description . "','" . $weight . "','" . $players . "',NOW(),DATE('" . $delivery_date . "'),NOW())";

      $res = $pdo->query($sql);
      $result = $res->fetch();

    } catch (PDOException $e) {
      $log = ['response' => $e->getMessage()];
      $pdo = null;
      header('Access-Control-Allow-Origin: ');
      header('Content-Type: application/json');
      echo json_encode($log);
      return;
    }

    // upate game/budget id

    try {
      $sql = "INSERT INTO games_budgets VALUES( UUID(),'$game_id','$budget_id')";
      $res = $pdo->query($sql);
      $result = $res->fetch();
      if (is_array($result) && count($result) == 0) {
        $log = ['response' => 'games_budgets not updated'];
        $pdo = null;
        header('Access-Control-Allow-Origin:');
        header('Content-Type: application/json');
        echo json_encode($log);
        return;
      }
    } catch (PDOException $e) {
      $log = ['response' => 'games_budgets not updated'];
      $pdo = null;
      header('Access-Control-Allow-Origin: *');
      header('Content-Type: application/json');
      echo json_encode($log);
      return;
    }
    $image_id = "";
    $sql = "SELECT name FROM images WHERE name = '$blob_name'";
    $res = $pdo->query($sql)->fetch();
    if (is_array($res) && count($res) != 0) {
      $log = ['response' => "Une image portant le nom  '" . $blob_name . "' existe déjà."];
      $pdo = null;
      header('Access-Control-Allow-Origin: *');
      header('Content-Type: application/json');
      echo json_encode($log);
      return;
    }
    $image_id = GetUUID();
    $sql = "INSERT INTO images (id,name,image) VALUES( '$image_id','$blob_name','$blob' ); ";
    $res = $pdo->exec($sql);

    try {


      $sql = "INSERT INTO games_images (id,game_id,image_id) VALUES( UUID(),'$game_id','$image_id');";
      $res = $pdo->exec($sql);

    } catch (PDOException $e) {
      $log = ['response' => $e->getMessage()];
      $pdo = null;
      header('Access-Control-Allow-Origin: *');
      header('Content-Type: application/json');
      echo json_encode($log);
      return;
    }
    $timestamp = time(); // get the current timestamp
    $now = date('Y-m-d H:i:s', $timestamp); // format the timestamp as a string in the desired format
    $message = "Game was successfully inserted at " . $now;
    $log = ['response' => $message];
    $pdo = null;
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    echo json_encode($log);
    return;


  } catch (PDOException $e) {
    $log = ['response' => 'ERROR Game not inserted'];
    $pdo = null;
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    echo json_encode($log);
    return;
  }

} catch (PDOException $e) {
  $log = ['response' => $e->getMessage()];
  $pdo = null;
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  echo json_encode($log);
  return;
}

?>