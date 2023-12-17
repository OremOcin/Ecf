<?php
$host = "127.0.0.1";
$user = "root";
$password = "";
$db = "ecfdatabase";
$dsn = "mysql:host=$host;dbname=$db";
$pdo = new PDO($dsn, $user, $password);
// users  table foreign key role_id
try {

    // get admin hash in roles table

    function GetUUID()
    {
        global $pdo;
        $sql = "SELECT UUID()";
        $res = $pdo->query($sql);
        $result = $res->fetch();
        return $result['UUID()'];
    }

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