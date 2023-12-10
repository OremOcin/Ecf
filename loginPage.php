<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="loginPage.css">
  <script src="login.js"></script>
</head>

<body id="loginPageBody">
  <header id="indexHeader">
    <img id="indexLogo" src="img/logo_gamesoft refait.png" alt="Logo de L'entreprise">
    <h1 id="indexTitle">Bienvenue sur votre plateforme en ligne Gamesoft Studio <br> Stats et News sur
      vos jeux
      favoris ! Infos de développement ! Suivi de tous vos jeux ! <br>
      Discussion entre passionnés ! </h1>
  </header>

  <ul class="homeNavBar">
    <li><a href="index.php">Accueil</a></li>
    <li><a href="browseVideoGames.php">Jeux</a></li>
    <li><a href="registerPage.php">M'enregistrer</a></li>
    <li><a href="#help">Me connecter</a></li>
    <li><a href="userProfile.php">Mon Profil</a></li>
  </ul>

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
  <script>
    document.getElementById("login").addEventListener("click", login);
  </script>
</body>

</html>