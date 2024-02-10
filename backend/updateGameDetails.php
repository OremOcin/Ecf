<?php
//$content = trim(file_get_contents("php://input"));

//$contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';

//Receive the RAW post data.

//$decoded = json_decode($content, true);

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
$host = "127.0.0.1";
$root = "root";
$password = "";
$db = "ecfdatabase";
$dsn = "mysql:host=$host;dbname=$db";
try {
  function GetUUID()
  {
    global $pdo;
    $sql = "SELECT UUID()";
    $res = $pdo->query($sql);
    $result = $res->fetch();
    return $result['UUID()'];
  }

  $title = str_replace('"', '"', $_POST['title']);
  // Récupérer l'email avec get depuis un autre script 
  $score = $_POST["score"];
  $blob = $_POST['blob'];
  $blob_name = $_POST['blob-name'];
  $weight = $_POST['weight'];
  $description = str_replace('"', '"', mb_convert_encoding($_POST['description'], "UTF-8"));
  $device = $_POST['select-device'];
  $engine = $_POST['select-engine'];
  $status = $_POST['select-status'];
  $type = $_POST['select-type'];
  $creation_date = $_POST['creation_date'];
  $end_creation = $_POST['end_creation'];
  $budget = $_POST['budget'];
  $players = $_POST['players'];


  try {
    $pdo = new PDO($dsn, $root, $password);

    // check table not empty
    //
    $sql = "SELECT EXISTS (SELECT 1 FROM games) AS Output";
    $res = $pdo->query($sql);
    $result = $res->fetch();
    if ($result['Output'] == 0) {
      $message = "Update impossible, aucun jeu trouvé.";
      $_SESSION["message"] = $message;
      $pdo = null;
      $log = ['no_games_founds' => 'true'];
      header('Access-Control-Allow-Origin: *');
      header('Content-Type: application/json');
      echo json_encode($log);
      return;
    }
    $sql = "SELECT id FROM games WHERE title = '$title'";
    $res = $pdo->query($sql);
    $result = $res->fetch();
    $game_id = $result['0'];
    /*  $log = ['result' => $result, 'game_id' => $game_id];
      $pdo = null;
      header('Access-Control-Allow-Origin: *');
      header('Content-Type: application/json');
      echo json_encode($log);
      return;  */
    $category_id = "";
    try {
      $sql = "SELECT name,id FROM games_categories WHERE name ='$type'";
      $res = $pdo->query($sql);
      $result = $res->fetch();


      if ((!is_array($result) || count($result) == 0)) {
        $log = ['error' => 'category_id not found'];
        $pdo = null;
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');
        echo json_encode($log);
        return;
      }

      $category_id = $result['id'];
    } catch (PDOException $e) {
      $log = ['exception' => 'category_id not found'];
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
        $log = ['error' => 'media_id not found'];
        $pdo = null;
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');
        echo json_encode($log);
        return;
      }


      $media_id = $result['id'];

    } catch (PDOException $e) {
      $log = ['exception' => 'media_id not found'];
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
        $log = ['error' => 'status_id not found'];
        $pdo = null;
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');
        echo json_encode($log);
        return;
      }
      $status_id = $result['id'];

    } catch (PDOException $e) {
      $log = ['exception' => 'status_id not found'];
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
        $log = ['error' => 'engine_id not found'];
        $pdo = null;
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');
        echo json_encode($log);
        return;
      }
      $engine_id = $result['id'];

    } catch (PDOException $e) {
      $log = ['exception' => 'engine_id not found'];
      $pdo = null;
      header('Access-Control-Allow-Origin: *');
      header('Content-Type: application/json');
      echo json_encode($log);
      return;
    }

    // insert game into games db

    try {
      $delivery_date = date($end_creation);
      $sql_update_game = "UPDATE games SET engine_id = '$engine_id', media_id ='$media_id', category_id = '$category_id', status_id ='$status_id', description =\"" . $description . "\",weight = $weight, players = $players, delivery_date = DATE('$delivery_date'), last_modified = NOW() WHERE id = '$game_id'";
      $res = $pdo->query($sql_update_game);
      $result = $res->fetch();
    } catch (PDOException $e) {
      $log = ['exception' => $e->getMessage()];
      $pdo = null;
      header('Access-Control-Allow-Origin: ');
      header('Content-Type: application/json');
      echo json_encode($log);
      return;
    }

    $image_id = "";

    try {


      $sql = "SELECT image_id FROM games_images WHERE game_id ='$game_id'";
      $res = $pdo->query($sql)->fetch();
      $image_id = $res[0];
    } catch (PDOException $e) {
      $_SESSION["message"] = $e->getMessage();
      return;
    }

    $sql = "UPDATE images SET name = '$blob_name', image = '$blob' WHERE id = '$image_id'";
    $res = $pdo->exec($sql);
    $timestamp = time(); // get the current timestamp
    $now = date('Y-m-d H:i:s', $timestamp); // format the timestamp as a string in the desired format
    $message = "Game was successfully updated at " . $now;
    $_SESSION["message"] = $message;

    $pdo = null;

    // $log = ['sql' => $sql_update_game, 'decoded' => $decoded];

    $updated_game = [
      'title' => $_POST['title'],
      'score' => $_POST['score'],
      'blob' => $blob,
      'blob_name' => $_POST['blob-name'],
      'weight' => $_POST['weight'],
      'description' => mb_convert_encoding($_POST['description'], "UTF-8"),
      'device' => $_POST['select-device'],
      'engine' => $_POST['select-engine'],
      'status' => $_POST['select-status'],
      'type' => $_POST['select-type'],
      'creation_date' => $_POST['creation_date'],
      'end_creation' => $_POST['end_creation'],
      'budget' => $_POST['budget'],
      'players' => $_POST['players']
    ];

    $pdo = null;
    $_SESSION["updated_game"] = base64_encode(serialize($updated_game));
    header('Access-Control-Allow-Origin: *');
    header('location: ./pages/adminDashboardPage.php');
    exit;

  } catch (PDOException $e) {
    $log = ['exception' => 'ERROR Game not updated'];
    $pdo = null;
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    echo json_encode($log);
    return;
  }

} catch (PDOException $e) {
  (print_r($pdo->errorInfo(), true));
  die("DB ERROR: " . $e->getMessage());
}

?>