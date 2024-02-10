<?php
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