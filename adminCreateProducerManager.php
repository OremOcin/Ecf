<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>M'enregistrer</title>
  <link rel="stylesheet" href="createProducer.css">
  <script src="adminCreateRole.js"></script>
  <script src="showPassword.js"></script>

</head>

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
    <li><a href="browseVideoGames.php">Jeux</a></li>
    <li><a href="registerPage.php">M'enregistrer</a></li>
    <li><a href="loginPage.php">Me connecter</a></li>
    <li><a href="userProfile.php">Mon Profil</a></li>
    <li><a href="adminDashboard.php">Tableau de Bord Admin</a></li>
    <li><a href="createProducer.php">Créer un compte Producteur/Manager</a></li>
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
          </script>
        </li>
      </ul>
    </form>
  </div>
  <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>

</html>