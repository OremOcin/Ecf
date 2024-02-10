<?php

$CLEARDB_DATABASE_URL = 'mysql://root:bi1MqEy6wwdk5TwQOvlleCRGLsPmzecJ@3yndg5.stackhero-network.com/root?useSSL=true&requireSSL=true';
$url = parse_url($CLEARDB_DATABASE_URL);
$server = $url["host"];
$username = $url["user"];
$password = $url["pass"];
$db = substr($url["path"], 1);
$dbname = "ecfdatabase";

echo ("server   " . $server . "\n");
echo ("username " . $username . "\n");
echo ("password " . $password . "\n");
echo ("db       " . $dbname . "\n");
$dbns = 'mysql:host=' . $server . ';dbname=' . $dbname;

echo ("dbns     " . $dbns . "\n");
try {
  $pdo = new PDO($dbns, $username, $password);
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  return;
  try {
    $sql = "CREATE TABLE IF NOT EXISTS users (id VARCHAR(36) NOT NULL,avatar BLOB,role_id VARCHAR(100) NOT NULL,pseudo VARCHAR(30) NOT NULL,firstname VARCHAR(30) NOT NULL,lastname VARCHAR(30) NOT NULL,email VARCHAR(30),hash_password VARCHAR(100) NOT NULL,creation_date DATE NOT NULL,PRIMARY KEY(id),FOREIGN KEY(role_id) REFERENCES roles(id) ON UPDATE CASCADE ON DELETE CASCADE) ";
    $pdo->exec($sql);
    echo ("\n Table 'users' created successfully");

  } catch (PDOException $e) {
    echo ("\n DB ERROR: " . $e->getMessage());
  }
  try {
    $sql = "CREATE TABLE IF NOT EXISTS roles (id VARCHAR(50) NOT NULL,name VARCHAR(50) NOT NULL,PRIMARY KEY(id))";
    $pdo->exec($sql);
    echo ("\n Table 'roles' created successfully");
    $sql = "INSERT INTO roles (id, name) VALUES (UUID(), 'admin')";
    $pdo->exec($sql);
    $sql = "INSERT INTO roles (id, name) VALUES (UUID(), 'producer')";
    $pdo->exec($sql);
    $sql = "INSERT INTO roles (id, name) VALUES (UUID(), 'manager')";
    $pdo->exec($sql);
    $sql = "INSERT INTO roles (id, name) VALUES (UUID(), 'user')";
    $pdo->exec($sql);
    echo ("\n roles DB : New records created successfully");
  } catch (PDOException $e) {
    echo ("\n DB ERROR: " . $e->getMessage());
  }

  // engine table
  try {
    $sql = "CREATE TABLE IF NOT EXISTS engines (id VARCHAR(50) NOT NULL,name VARCHAR(50) NOT NULL,PRIMARY KEY(id))";
    $pdo->exec($sql);
    echo ("\n Table 'engines' created successfully");
    $sql = "INSERT INTO engines (id, name) VALUES (UUID(), 'CryEngine')";
    $pdo->exec($sql);
    $sql = "INSERT INTO engines (id, name) VALUES (UUID(), 'Unreal Engine')";
    $pdo->exec($sql);
    $sql = "INSERT INTO engines (id, name) VALUES (UUID(), 'Unity 3D')";
    // use exec() because no results are returned
    $pdo->exec($sql);
    echo ("\n engines DB : New records created successfully");
  } catch (PDOException $e) {
    echo ("\n DB ERROR: " . $e->getMessage());
  }

  // medias categories table
  try {
    echo ("\n CREATING Table 'medias' created successfully");
    $sql = "CREATE TABLE IF NOT EXISTS medias (id VARCHAR(36) NOT NULL,name VARCHAR(30) NOT NULL,PRIMARY KEY(id))";
    $pdo->exec($sql);
    echo ("\n Table 'medias' created successfully");
    $sql = "INSERT INTO medias (id, name) VALUES (UUID(), 'XBOITE')";
    $pdo->exec($sql);
    $sql = "INSERT INTO medias (id, name) VALUES (UUID(), 'DESKTOP')";
    $pdo->exec($sql);
    echo ("\n Table 'medias' DB : New records created successfully");
  } catch (PDOException $e) {
    echo ("\n DB ERROR: " . $e->getMessage());
  }

  // games categories table
  try {
    $sql = "CREATE TABLE IF NOT EXISTS games_categories (id VARCHAR(36) NOT NULL,name VARCHAR(30) NOT NULL,PRIMARY KEY(id))";
    $pdo->exec($sql);
    echo ("\n Table 'games_categories' created successfully");
    $sql = "INSERT INTO games_categories (id, name) VALUES (UUID(), 'MMO')";
    $pdo->exec($sql);
    $sql = "INSERT INTO games_categories (id, name) VALUES (UUID(), 'RPG')";
    $pdo->exec($sql);
    $sql = "INSERT INTO games_categories (id, name) VALUES (UUID(), 'Adventure')";
    $pdo->exec($sql);
    $sql = "INSERT INTO games_categories (id, name) VALUES (UUID(), 'Action')";
    $pdo->exec($sql);
    echo ("\n games_categories DB : New records created successfully");
  } catch (PDOException $e) {
    echo ("\n DB ERROR: " . $e->getMessage());
  }

  // images  table
  try {
    $sql = "CREATE TABLE IF NOT EXISTS images (id VARCHAR(36) NOT NULL,name VARCHAR(255) NOT NULL,  image MEDIUMBLOB NOT NULL,PRIMARY KEY(id))";
    $pdo->exec($sql);
    echo ("\n Table 'images_gallery' created successfully");
  } catch (PDOException $e) {
    echo ("\n DB ERROR: " . $e->getMessage());
  }


  // games status  table
  try {
    $sql = "CREATE TABLE IF NOT EXISTS status (id VARCHAR(36) NOT NULL,value VARCHAR(30) NOT NULL,PRIMARY KEY(id))";
    $pdo->exec($sql);
    echo ("\n Table 'status' created successfully");
    $sql = "INSERT INTO status (id, value) VALUES (UUID(), 'released')";
    $pdo->exec($sql);
    $sql = "INSERT INTO status (id, value) VALUES (UUID(), 'cancelled')";
    $pdo->exec($sql);
    $sql = "INSERT INTO status (id, value) VALUES (UUID(), 'alpha')";
    $pdo->exec($sql);
    $sql = "INSERT INTO status (id, value) VALUES (UUID(), 'beta')";
    $pdo->exec($sql);
    $sql = "INSERT INTO status (id, value) VALUES (UUID(), 'dev')";
    $pdo->exec($sql);
    $sql = "INSERT INTO status (id, value) VALUES (UUID(), 'standBy')";
    $pdo->exec($sql);
    $sql = "INSERT INTO status (id, value) VALUES (UUID(), 'delayed')";

    $pdo->exec($sql);
    echo ("\n status DB : New records created successfully");
  } catch (PDOException $e) {
    echo ("\n DB ERROR: " . $e->getMessage());
  }

  // games table foreign key engine_id category_id status_id media_id
  try {

    echo ("\n creating Table 'games' ...");
    $sql = "CREATE TABLE IF NOT EXISTS games (id VARCHAR(40) NOT NULL,engine_id VARCHAR(40) NOT NULL,media_id VARCHAR(40) NOT NULL,category_id VARCHAR(40) NOT NULL, status_id VARCHAR(40) NOT NULL,title VARCHAR(30) NOT NULL,description VARCHAR(100) NOT NULL,weight INT DEFAULT 0,players TINYINT DEFAULT 1,creation_date DATE NOT NULL,delivery_date DATE NOT NULL, last_modified DATE NOT NULL,PRIMARY KEY(id), FOREIGN KEY(engine_id) REFERENCES engines(id) ON UPDATE CASCADE ON DELETE CASCADE,FOREIGN KEY(media_id) REFERENCES medias(id) ON UPDATE CASCADE ON DELETE CASCADE,FOREIGN KEY(category_id) REFERENCES games_categories(id) ON UPDATE CASCADE ON DELETE CASCADE, FOREIGN KEY(status_id) REFERENCES status(id) ON UPDATE CASCADE ON DELETE CASCADE) ";
    $pdo->exec($sql);


    try {
      $sql = "ALTER TABLE games  ADD FULLTEXT(title)";
      $pdo->exec($sql);
      $sql = "ALTER TABLE games  ADD FULLTEXT(description)";
      $pdo->exec($sql);
      echo ("\n succesfully ALTERING  Table 'games' to allow FULL TEXT search...");
    } catch (PDOException $e) {
      echo ("\n DB ERROR: " . $e->getMessage());
    }

    echo ("\n Table 'games' created successfully");
  } catch (PDOException $e) {
    echo ("\n DB ERROR: " . $e->getMessage());
  }


  // budgets   table
  try {
    $sql = "CREATE TABLE IF NOT EXISTS budgets (id VARCHAR(36) NOT NULL,value VARCHAR(30) NOT NULL,comments VARCHAR(100),date DATE,PRIMARY KEY(id))";
    $pdo->exec($sql);
    echo ("\n Table 'budgets' created successfully");

  } catch (PDOException $e) {
    echo ("\n DB ERROR: " . $e->getMessage());
  }


  // games_budgets table associative games/budgets
  try {

    $sql = "CREATE TABLE IF NOT EXISTS games_budgets (id VARCHAR(36) NOT NULL, game_id VARCHAR(36) NOT NULL,budget_id VARCHAR(100) NOT NULL, PRIMARY KEY(id),FOREIGN KEY(game_id) REFERENCES games(id) ON UPDATE CASCADE ON DELETE CASCADE, FOREIGN KEY(budget_id) REFERENCES budgets(id) ON UPDATE CASCADE ON DELETE CASCADE) ";
    $pdo->exec($sql);

    echo ("\n Table 'games/budgets' created successfully");


  } catch (PDOException $e) {
    echo ("\n DB ERROR: " . $e->getMessage());
  }


  // Users Games  table associative games/images
  try {
    echo ("\n creating Table 'games/images' ...");
    $sql = "CREATE TABLE IF NOT EXISTS games_images (id VARCHAR(36) NOT NULL, game_id VARCHAR(36) NOT NULL,image_id VARCHAR(36) NOT NULL,PRIMARY KEY(id),FOREIGN KEY(game_id) REFERENCES games(id) ON UPDATE CASCADE ON DELETE CASCADE, FOREIGN KEY(image_id) REFERENCES images(id) ON UPDATE CASCADE ON DELETE CASCADE) ";
    $pdo->exec($sql);

    echo ("\n Table 'games/images' created successfully");


  } catch (PDOException $e) {
    echo ("\n DB ERROR: " . $e->getMessage());
  }
  try {
    echo ("\n creating Table 'games/users' ...");
    $sql = "CREATE TABLE IF NOT EXISTS users_games (id VARCHAR(36) NOT NULL, user_id VARCHAR(36) NOT NULL, game_id VARCHAR(36) NOT NULL,PRIMARY KEY(id),FOREIGN KEY(user_id) REFERENCES users(id) ON UPDATE CASCADE ON DELETE CASCADE, FOREIGN KEY(game_id) REFERENCES games(id) ON UPDATE CASCADE ON DELETE CASCADE) ";
    $pdo->exec($sql);

    echo ("\n Table 'games/images' created successfully");


  } catch (PDOException $e) {
    echo ("\n DB ERROR: " . $e->getMessage());
  }
  // users_roles table associative users/roles
  try {

    $sql = "CREATE TABLE IF NOT EXISTS users_roles (id VARCHAR(50) NOT NULL, user_id VARCHAR(50) NOT NULL,role_id VARCHAR(50) NOT NULL,PRIMARY KEY(id),FOREIGN KEY(user_id) REFERENCES users(id) ON UPDATE CASCADE ON DELETE CASCADE,FOREIGN KEY(role_id) REFERENCES roles(id) ON UPDATE CASCADE ON DELETE CASCADE) ";
    $pdo->exec($sql);

    echo ("\n Table 'users/roles' created successfully");


  } catch (PDOException $e) {
    echo ("\n DB ERROR: " . $e->getMessage());
  }
} catch (PDOException $e) {
  echo ("\n EXECUTION ERROR: " . $e->getMessage());
}

// news table
try {
  $sql = "CREATE TABLE news (id VARCHAR(50) NOT NULL,title VARCHAR(255) NOT NULL,content TEXT NOT NULL,image MEDIUMBLOB NOT NULL, date DATETIME NOT NULL,PRIMARY KEY(id),FULLTEXT (title,content) )";
  $pdo->exec($sql);

  echo ("\n news DB : created successfully");
} catch (PDOException $e) {
  echo ("\n DB ERROR: " . $e->getMessage());
}

$pdo = null;
?>