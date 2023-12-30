<?php
session_start();
$role = array_key_exists("role", $_SESSION) ? $_SESSION["role"] : null;
$user_name = array_key_exists("username", $_SESSION) ? $_SESSION["username"] : null;
$user_email = array_key_exists("email", $_SESSION) ? $_SESSION["email"] : null;
echo "role " . is_null($role) . "\n";
echo "username " . is_null($user_name) . "\n";
echo "email " . is_null($user_email) . "\n";
if (is_null($user_email) || is_null($role) || strcmp($role, "admin") != 0) {
  echo <<<EOL
   <script>
   window.location = "./forbiddenAccess.html";
   </script>
  EOL;
  return;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>M'enregistrer</title>
  <link rel="stylesheet" href="createProducer.css">
  <script src="adminCreateRole.js"></script>
  <script src="showPassword.js"></script>
  <script src="logout.js"></script>
</head>

<body id="registerPageBody">
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
      <div style=\"padding-right:2rem;padding-left:2rem;\">
      <h6>Bienvenue</h6>
      <h6>" . $user_name . "</h6>
      <h6>connecté en tant que " . $role . "</h6>
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
    <li><a href="userProfile.php">Mon Profil</a></li>
    <li><a href="adminDashboard.php">Tableau de Bord Admin</a></li>
  </ul>

  <div class="registerContainer">

    <form>
      <ul class="wrapper">
        <li class="form-row">
          <label for="firstName">Prénom</label>
          <input type="text" id="firstName" required>
        </li>
        <li class="form-row">
          <label for="name">Nom</label>
          <input type="text" id="name" required>
        </li>
        <li class="form-row">
          <label for="role">Rôle</label>
          <select name="adminAccountCreate" id="adminAccountCreate">
            <option value="CommunityManager">Community Manager</option>
            <option value="CommunityManager">Producteur/Productrice</option>
          </select>
        </li>
        <li class="form-row">
          <label for="email">Adresse E-mail</label>
          <input type="email" id="email" required>
        </li>
        <li class="form-row">
          <label for="pseudo">Pseudo</label>
          <input type="text" id="pseudo" required>
        </li>
        <li class="form-row">
          <label for="pwd">Mot de Passe</label>
          <input name="showpassword" type="password" id="pwd" required />
          <div>
            <button hidden id="toggle-show-password" value="false"></button>
            <button value="false" onclick="showPassword()" type="button" id="show-password">
              <div id="eye-state" style="width:100%;">
                <ion-icon style="width:25px; height:47px;" name="eye-outline"></ion-icon>
              </div>
            </button>
          </div>
        </li>
        <li class="form-row">
          <button id="submit-button" type="button">Submit</button>
          <script type="text/javascript">
            document.getElementById('submit-button').addEventListener('click', adminCreateRole);
            const signout = document.getElementById("sign-out");
            if (signout) {
              signout.addEventListener("click", logout);
            }
          </script>
        </li>
      </ul>
    </form>
  </div>
  <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>

</html>