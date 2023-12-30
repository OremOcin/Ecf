<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="userProfile.css">
</head>

<?php
session_start();
$role = array_key_exists("role", $_SESSION) ? $_SESSION["role"] : null;
$user_name = array_key_exists("username", $_SESSION) ? $_SESSION["username"] : null;
$user_email = array_key_exists("email", $_SESSION) ? $_SESSION["email"] : null;
echo "role " . is_null($role) . "\n";
echo "username " . is_null($user_name) . "\n";
echo "email " . is_null($user_email) . "\n";
if (is_null($user_email) && is_null($role)) {
  echo <<<EOL
   <script>
   window.location = "./forbiddenAccess.html";
   </script>
  EOL;
  return;
}
?>

<body id="userProfileBody">
  <header id="indexHeader" class="index-header">
    <img id="indexLogo" src="img/logo_gamesoft refait.png" alt="Logo de L'entreprise">
    <h1 id="indexTitle">Bienvenue sur votre plateforme en ligne Gamesoft Studio <br> Stats et News sur
      vos jeux
      favoris ! Infos de développement ! Suivi de tous vos jeux ! <br>
      Discussion entre passionnés !</h1>
    <?php
    if (!is_null($user_name) && !is_null($user_email)) {
      echo "
     <div class=\"login-data\">
      <div class=\"login-data-inside-div\">
        <svg fill=\"#ffff00\" height=\"32px\" width=\"32px\" version=\"1.1\" id=\"Layer_1\" xmlns=\"http://www.w3.org/2000/svg\" xmlns:xlink=\"http://www.w3.org/1999/xlink\" \
        viewBox=\"0 0 512 512\" xml:space=\"preserve\">\
      <path d=\"M333.187,237.405c32.761-23.893,54.095-62.561,54.095-106.123C387.282,58.893,328.389,0,256,0
        S124.718,58.893,124.718,131.282c0,43.562,21.333,82.23,54.095,106.123C97.373,268.57,39.385,347.531,39.385,439.795
        c0,39.814,32.391,72.205,72.205,72.205H400.41c39.814,0,72.205-32.391,72.205-72.205
        C472.615,347.531,414.627,268.57,333.187,237.405z M164.103,131.282c0-50.672,41.225-91.897,91.897-91.897
        s91.897,41.225,91.897,91.897S306.672,223.18,256,223.18S164.103,181.954,164.103,131.282z M400.41,472.615H111.59
        c-18.097,0-32.82-14.723-32.82-32.821c0-97.726,79.504-177.231,177.231-177.231s177.231,79.504,177.231,177.231
        C433.231,457.892,418.508,472.615,400.41,472.615z\"/>
  </svg>
      </div>
      <div style=\"padding-right:2rem;padding-left:2rem; font-size:1rem;\">
      Bienvenue
      " . $user_name . "
      <br>
      connecté en tant que " . $role . "
      <br>
      </div>
      <div id=\"sign-out\" class=\"login-data-inside-div\">
      <svg height=\"32px\" width=\"32px\" class=\"svg-icon\" style=\"vertical-align: middle;fill: #ffff00;overflow: hidden;\" viewBox=\"0 0 1024 1024\" version=\"1.1\" xmlns=\"http://www.w3.org/2000/svg\"><path d=\"M768 106V184c97.2 76 160 194.8 160 328 0 229.6-186.4 416-416 416S96 741.6 96 512c0-133.2 62.8-251.6 160-328V106C121.6 190.8 32 341.2 32 512c0 265.2 214.8 480 480 480s480-214.8 480-480c0-170.8-89.6-321.2-224-406z\" /><path d=\"M512 32c-17.6 0-32 14.4-32 32v448c0 17.6 14.4 32 32 32s32-14.4 32-32V64c0-17.6-14.4-32-32-32z\" /></svg>
      </div>
      </div>";
    }
    ?>
  </header>

  <ul class="homeNavBar">
    <li><a href="index.php">Accueil</a></li>
    <li><a href="userBrowseVideoGames.php">Jeux</a></li>
    <?php
    if (is_null($user_name) && is_null($user_email)) {
      echo "<li><a href=\"registerPage.php\">M'enregistrer</a></li>
            <li><a href=\"loginPage.php\">Me connecter</a></li>";
    } else {
      if (!is_null($role)) {
        if (strcmp($role, "admin") === 0 || strcmp($role, "producer") === 0) {
          echo "<li><a href=\"adminDashboard.php\">Tableau de Bord</a></li>";
        } else if (strcmp($role, "manager") === 0) {
          echo "<li><a href=\"managerDashboard.php\">Tableau de Bord</a></li>";
        }
      }
    }
    ?>
  </ul>
  <div class="formContainer">
    <div class="verticalEmptyContainer"></div>
    <div class="formUserProfile">
      <form action="">

        <div class="svgContainer">
          <div height="100%" width="100%" style="display:flex; flex-direction: column;">
            <svg xmlns="http://www.w3.org/2000/svg" width="80%" height="80%" fill="currentColor" class="svgFile"
              viewBox="0 0 16 16">
              <path
                d="M1.5 1a.5.5 0 0 0-.5.5v3a.5.5 0 0 1-1 0v-3A1.5 1.5 0 0 1 1.5 0h3a.5.5 0 0 1 0 1h-3zM11 .5a.5.5 0 0 1 .5-.5h3A1.5 1.5 0 0 1 16 1.5v3a.5.5 0 0 1-1 0v-3a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 1-.5-.5zM.5 11a.5.5 0 0 1 .5.5v3a.5.5 0 0 0 .5.5h3a.5.5 0 0 1 0 1h-3A1.5 1.5 0 0 1 0 14.5v-3a.5.5 0 0 1 .5-.5zm15 0a.5.5 0 0 1 .5.5v3a1.5 1.5 0 0 1-1.5 1.5h-3a.5.5 0 0 1 0-1h3a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 1 .5-.5z" />
              <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3zm8-9a3 3 0 1 1-6 0 3 3 0 0 1 6 0z" />
            </svg>
            <input class="avatarInput" type="file">
          </div>
        </div>
        <ul class="wrapper">
          <li class="form-row">
            <label for="pseudoInput">Pseudo
              <input name="pseudoInput" class="pseudoInput" type="text">
            </label>
          </li>
          <li class="form-row">
            <label for="emailInput">Email
              <input name="emailInput" type="email">
            </label>
          </li>
          <li class="form-row">
            <label for="newPwd">Nouveau Mot de Passe
              <input name="newPwd" type="password">
            </label>
          </li>
          <li class="form-row">
            <button type="submit">Confirmer</button>

          </li>
        </ul>
      </form>
    </div>
    <div class="verticalEmptyContainer"></div>
  </div>
  <script>
    const signout = document.getElementById("sign-out");
    if (signout) {
      signout.addEventListener("click", logout);
    }
  </script>
</body>

</html>