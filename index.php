<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="index.css">
  <link rel="stylesheet" href="../css/responsive-navbar.css">
  <script src="../js/managerDashboard.js"></script>
  <script src="../js/logout.js"></script>
  <script src="../js/clickHamburger.js"></script>
</head>

<?php
session_start();
$role = array_key_exists("role", $_SESSION) ? $_SESSION["role"] : null;
$user_name = array_key_exists("username", $_SESSION) ? $_SESSION["username"] : null;
$user_email = array_key_exists("email", $_SESSION) ? $_SESSION["email"] : null;
?>

<body id="indexBody">
  <script>
    var intervalId = -1;
  </script>

  <header id="indexHeader" class="index-header">
    <img id="indexLogo" src="img/logo_gamesoft refait.png" alt="Logo de L'entreprise">
    <h1 class="index-title" id="indexTitle">Bienvenue sur votre plateforme en ligne Gamesoft Studio <br> Stats et News
      sur
      vos jeux
      favoris ! Infos de développement ! Suivi de tous vos jeux ! <br>
      Discussion entre passionnés !</h1>
    <?php
    if (!is_null($user_name) && !is_null($user_email)) {
      echo "
      <div class=\"login-data\">
      <div class=\"login-data-inside-div\">
       <div class=\"login-data-svg-div\">
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
       <div style=\"display:block;justify-content:start;padding-right:2rem;padding-left:2rem; font-size:1rem;\">
       <div style=\"padding-bottom:5px;\">
       Bienvenue
       " . $user_name . "
       </div>
       <div>
       accès : " . $role . "
       </div>
       </div>
       <div id=\"sign-out\" class=\"login-data-svg-div\">
       <svg height=\"32px\" width=\"32px\" class=\"svg-icon\" style=\"vertical-align: middle;fill: #ffff00;overflow: hidden;\" viewBox=\"0 0 1024 1024\" version=\"1.1\" xmlns=\"http://www.w3.org/2000/svg\"><path d=\"M768 106V184c97.2 76 160 194.8 160 328 0 229.6-186.4 416-416 416S96 741.6 96 512c0-133.2 62.8-251.6 160-328V106C121.6 190.8 32 341.2 32 512c0 265.2 214.8 480 480 480s480-214.8 480-480c0-170.8-89.6-321.2-224-406z\" /><path d=\"M512 32c-17.6 0-32 14.4-32 32v448c0 17.6 14.4 32 32 32s32-14.4 32-32V64c0-17.6-14.4-32-32-32z\" /></svg>
       </div>
       </div>
       </div>";
    }
    ?>
  </header>
  <ul id="home-navbar" class="homeNavBar" style="display:flex;">
    <div id="hamburger" class="hamburger">
      <li><img src="../img/hamburger.svg" alt=""></li>
    </div>
    <script>document.getElementById("hamburger").addEventListener("click", clickHamburger);</script>
    <div id="responsive-navbar" class="responsive-navbar" style="display:flex;">
      <li><a href="./pages/userBrowseVideoGamesPage.php">Jeux</a></li>
      <?php
      if (is_null($user_name) && is_null($user_email)) {
        echo "<li><a href=\"../pages/registerPage.php\">M'enregistrer</a></li>
            <li><a href=\"../pages/loginPage.php\">Me connecter</a></li>";
      }
      if (!is_null($user_name) && !is_null($user_email) && !is_null($role)) {
        echo "<li><a href=\"../pages/userProfilePage.php\">Mon Profil</a></li>";
        if (strcmp($role, "admin") === 0 || strcmp($role, "producer") === 0) {
          echo "<li><a href=\"./pages/adminDashboardPage.php\">Tableau de Bord</a></li>";
        } else if (strcmp($role, "manager") === 0) {
          echo "<li><a href=\"../pages/managerDashboardPage.php\">Tableau de Bord</a></li>";
        }
      }
      ?>
    </div>
  </ul>
  <script>
    const homeNavBar = document.getElementById("home-navbar");
    const navbar = document.getElementById("responsive-navbar");
    window.addEventListener("resize", (e) => {
      if (window.screen.width >= 600) {
        navbar.style.display = "flex";
        navbar.style.flexDirection = "row";
        homeNavBar.style.display = "flex";
        homeNavBar.style.flexDirection = "row";
        homeNavBar.style.justifyContent = "";
        homeNavBar.style.alignItems = "";
      } else {
        navbar.style.display = "none";
        navbar.style.flexDirection = "column";
        homeNavBar.style.flexDirection = "column";
        homeNavBar.style.justifyContent = "start";
        homeNavBar.style.alignItems = "start";
      }
    });
  </script>
  <div class="mainContainer">
    <div class="presentationContainer">
      <div class="presentationBox">
        <h1 class="presentationHeader">PRESENTATION</h1>
        <p class="presentationText">Gamesoft est une société spécialisée dans le développement de jeux vidéos sur PC et
          Xboite Lorem ipsum dolor sit amet consectetur adipisicing elit. Nemo ipsum aut reiciendis accusantium
          cupiditate maiores in accu
          samus delectus iure consequuntur! Iste ipsum vitae natus doloremque quod a perferendis nihil nisi.</p>
      </div>
    </div>
    <div class="lastNewsContainer">
      <div class="headerText">FIL D'ACTUALITES</div>
      <div id="news-container" class="lastNewsList"></div>
    </div>
    <div class="gamesInDevContainer">
      <div class="headerText presentationText">JEUX EN DEVELOPPEMENT</div>
      <div id="games-dev-container" class="gamesInDevList"></div>
    </div>
  </div>
  <script>
    fetchAllNews();
    window.onbeforeunload = function (event) {
      clearInterval(intervalId);
      clearInterval = -1;
    };
    FetchAllDevGames();
    const signout = document.getElementById("sign-out");
    if (signout) {
      signout.addEventListener("click", logout);
    }
  </script>
</body>

</html>