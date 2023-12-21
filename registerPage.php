<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>M'enregistrer</title>
  <link rel="stylesheet" href="registerPage.css">
  <script src="showPassword.js"></script>
  <script src="fetchUserRegisterPage.js"></script>
</head>

<?php
session_start();
$role = array_key_exists("role", $_SESSION) ? $_SESSION["role"] : null;
$user_name = array_key_exists("username", $_SESSION) ? $_SESSION["username"] : null;
$user_email = array_key_exists("email", $_SESSION) ? $_SESSION["email"] : null;
echo "role " . is_null($role) . "\n";
echo "username " . is_null($user_name) . "\n";
echo "email " . is_null($user_email) . "\n";
?>

<body id="registerPageBody">


  <header id="indexHeader">
    <img id="indexLogo" src="img/logo_gamesoft refait.png" alt="Logo de L'entreprise">
    <h1 id="indexTitle">Bienvenue sur votre plateforme en ligne Gamesoft Studio <br> Stats et News sur
      vos jeux
      favoris ! Infos de développement ! Suivi de tous vos jeux ! <br>
      Discussion entre passionnés ! </h1>
  </header>

  <ul class="homeNavBar">
    <li><a href="index.php">Accueil</a></li>
    <li><a href="userBrowseVideoGames.php">Jeux</a></li>
    <?php
    if (is_null($user_name) && is_null($user_email)) {
      echo "<li><a href=\"registerPage.php\">M'enregistrer</a></li>\
            <li><a href=\"loginPage.php\">Me connecter</a></li>";
    }
    if (!is_null($user_name) && !is_null($user_email)) {
      echo "<li><a href=\"userProfile.php\">Mon Profil</a></li>";
      if (!is_null($role) && !strcmp($role, "admin")) {
        echo "<li><a href=\"adminDashboard.php\">Tableau de Bord Admin</a></li>";
      }
      if (!is_null($role) && !strcmp($role, "manager")) {
        echo "<li><a href=\"managerDashboard.php\">Tableau de Bord Manager</a></li>";
      }
    }
    ?>
  </ul>

  <div class="registerContainer">
    <div style="width: 35%;"></div>
    <form style="width: 30%;">
      <ul class="wrapper">
        <li class="form-row">
          <label for="firstName">Prénom</label>
          <input type="text" id="firstName" required />
        </li>
        <li class="form-row">
          <label for="name">Nom</label>
          <input type="text" id="name" required />
        </li>
        <li class="form-row">
          <label for="email">Adresse E-mail</label>
          <input type="email" id="email" required />
        </li>
        <li class="form-row">
          <label for="pwd">Mot de Passe</label>
          <input name="showpassword" type="password" id="pwd" required />
          <div>
            <button hidden id="toggle-show-password" value="false"></button>
            <button value="false" onclick="showPassword()" type="button" id="show-password">
              <div id="eye-state" style="width:100%;">
                <!-- <svg xmlns="http://www.w3.org/2000/svg" width="20" height="45" fill="currentColor" class="bi bi-eye"
                  viewBox="0 0 16 16">
                  <path
                    d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z" />
                  <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z" />
                </svg> !-->
                <ion-icon style="width:25px; height:47px;" name="eye-outline"></ion-icon>
              </div>
            </button>
          </div>
        </li>
        <li class="form-row">
          <label for="pseudo">Pseudo</label>
          <input type="text" id="pseudo" required />
        </li>
        <li class="form-row">
          <button type="button" id="submit-button">Submit</button>
          <script type="text/javascript">
            document.getElementById('submit-button').addEventListener('click', registerUser);
          </script>
        </li>
      </ul>
    </form>
    <div style="width: 35%;"></div>
  </div>

  <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>

</html>