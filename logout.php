<?php
session_start();
if (array_key_exists("username", $_SESSION)) {
  unset($_SESSION["username"]);
}
if (array_key_exists("email", $_SESSION)) {
  unset($_SESSION["email"]);
}
session_destroy();
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
$log = ["response" => $_SESSION];
echo json_encode($log);
return;
?>