<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="../css/loginPage.css">
  <link rel="stylesheet" href="../css/responsive-navbar.css">
  <script src="../js/login.js"></script>
  <script src="../js/clickHamburger.js"></script>
  <script src="../js/logout.js"></script>
</head>

<?php
session_start();
$role = array_key_exists("role", $_SESSION) ? $_SESSION["role"] : null;
$user_name = array_key_exists("username", $_SESSION) ? $_SESSION["username"] : null;
$user_email = array_key_exists("email", $_SESSION) ? $_SESSION["email"] : null;
?>

<body id="loginPageBody">
  <header id="indexHeader" class="index-header">
    <img id="indexLogo" src="../img/logo_gamesoft refait.png" alt="Logo de L'entreprise">
    <h1 id="indexTitle">Bienvenue sur votre plateforme en ligne Gamesoft Studio <br> Stats et News sur
      vos jeux
      favoris ! Infos de développement ! Suivi de tous vos jeux ! <br>
      Discussion entre passionnés !</h1>

  </header>
  <ul id="home-navbar" class="homeNavBar" style="display:flex;">
    <div id="hamburger" class="hamburger">
      <li> <img src="../img/hamburger.svg" alt=""> </li>
    </div>
    <script>document.getElementById("hamburger").addEventListener("click", clickHamburger);</script>
    <div id="responsive-navbar" class="responsive-navbar" style="display:flex;">
      <li><a href="../index.php">Accueil</a></li>
      <li><a href="userBrowseVideoGamesPage.php">Jeux</a></li>
      <?php
      if (is_null($user_name) && is_null($user_email)) {
        echo "<li><a href=\"registerPage.php\">M'enregistrer</a></li>";
      }
      if (!is_null($user_name) && !is_null($user_email)) {
        echo "<li><a href=\"userProfilePage.php\">Mon Profil</a></li>";
        if (!is_null($role) && !strcmp($role, "admin")) {
          echo "<li><a href=\"adminDashboardPage.php\">Tableau de Bord Admin</a></li>";
        }
        if (!is_null($role) && !strcmp($role, "manager")) {
          echo "<li><a href=\"managerDashboardPage.php\">Tableau de Bord Manager</a></li>";
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
  <div style="display:flex; justify-content:center; align-items:center;">
    <div class="registerContainer">
      <form>
        <ul class="wrapper">
          <li class="form-row">
            <label for="email">Adresse E-mail</label>
            <input type="email" id="email" required>
          </li>
          <li class="form-row">
            <label for="pwd">Mot de Passe</label>
            <input type="password" id="pwd" required>
          </li>
          <li class="form-row">
            <button id="login" class="submit-button" type="button">Se connecter</button>
          </li>
        </ul>
      </form>
    </div>
  </div>

  <script>
    document.getElementById("login").addEventListener("click", login);
    const signout = document.getElementById("sign-out");
    if (signout) {
      signout.addEventListener("click", logout);
    }
  </script>
</body>

</html>