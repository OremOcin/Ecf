<?php
session_destroy();
header("Location:" . "index.php");
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
$log = ["response" => true];
echo json_encode($log);
return;
?>