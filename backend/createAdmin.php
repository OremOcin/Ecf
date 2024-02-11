<?php
function GetUUID()
{
    global $pdo;
    $sql = "SELECT UUID()";
    $res = $pdo->query($sql);
    $result = $res->fetch();
    return $result['UUID()'];
}

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
try {

    $admin_id = "";

    $sql = "SELECT id FROM roles WHERE name ='admin'";
    $result = $pdo->query($sql)->fetch();
    $admin_id = $result['id'];


    echo ("\n found UUID from admin id  '" . $admin_id . "' ... OK ");

    $hashed_password = password_hash('adminpassword', CRYPT_BLOWFISH);
    $id = getUUID();
    // admin password : adminpassword
    $sql = "INSERT INTO users (id, role_id, pseudo,firstname,lastname,email,hash_password,creation_date) VALUES ('" . $id . "','" . $admin_id . "', 'admin','admin','admin','admin@gamesoft.com','$hashed_password',NOW())";

    echo ("executing'" . $sql . "'\n");

    $pdo->exec($sql);
    $sql = "INSERT INTO users_roles (id, user_id, role_id) VALUES (UUID(),'" . $id . "','" . $admin_id . "')";
    $pdo->exec($sql);
    echo ("\n users DB : New records created successfully");

} catch (PDOException $e) {
    echo ("\n DB ERROR: " . $e->getMessage());
}
?>