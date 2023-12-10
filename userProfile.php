<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="userProfile.css">
</head>

<body id="userProfileBody">
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
    <li><a href="loginPage.php">Me connecter</a></li>
    <li><a href="userProfile.php">Mon Profil</a></li>
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
</body>

</html>