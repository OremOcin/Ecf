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

$pdo = new PDO($dsn, $user, $password, $options);

$sql = "INSERT INTO news (id,title,content,image,date) VALUES (UUID(), '" . $title . "', '" . $newsContent . "', '" . $image . "', NOW());";

$result = $pdo->exec($sql);

$log = ['response' => $result];
$pdo = null;
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
echo json_encode($log);
?>