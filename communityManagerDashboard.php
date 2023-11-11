<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="communityManagerDashboard.css">
  <script src="managerDashboard.js"></script>
</head>

<body id="communityManagerDashboardBody">
  <header id="indexHeader">
    <img id="indexLogo" src="img/logo_gamesoft refait.png" alt="Logo de L'entreprise">
    <h1 id="indexTitle">Bienvenue sur votre plateforme en ligne Gamesoft Studio <br> Stats et News sur
      vos jeux
      favoris ! Infos de développement ! Suivi de tous vos jeux ! <br>
      Discussion entre passionnés ! </h1>
  </header>

  <ul class="homeNavBar">
    <li><a href="index.php">Accueil</a></li>
    <li><a href="browseVideoGames.php">Les Jeux Vidéos</a></li>
    <li><a href="registerPage.php">M'enregistrer</a></li>
    <li><a href="loginPage.php">Me connecter</a></li>
    <li><a href="userProfile.php">Mon Profil</a></li>
    <li><a href="adminDashboard.php">Tableau de Bord Admin</a></li>
    <li><a href="createProducer.php">Créer un compte Producteur/Manager</a></li>
  </ul>

  <div class="flex-container">
    <div id="horizontalSpaceContainer"></div>
    <div id="horizontalMainSpaceContainer">
      <div id="news-container">
        <h1 style="color: rgb(253, 253, 0); font-family: 'Play' , sans-serif; font-size: 30px; text-align: center; text-shadow:
          3px 3px 4px rgba(0, 0, 0, 0.527); ">Fil d'Actualité</h1>
      </div>
    </div>
    <div id=" internalhorizontalSpaceContainer">
    </div>
    <div class="displayGame">
      <h1
        style=" color: rgb(253, 253, 0); font-family: 'Play', sans-serif; font-size: 30px; text-align: center; text-shadow: 3px 3px 4px rgba(0, 0, 0, 0.527); ">
        Créer/Editer une news
      </h1>
      <form>
        <ul class="wrapper">
          <li class="form-row">
            <label for="newsFormTitle">Titre</label>
            <input type="text" id="title" required>
          </li>
          <li class="form-row">
            <label for="newsFormContent">Contenu</label>
            <textarea id="news-content" style="resize:none; background:rgba(255,255,255,0.4); border: none;" rows="3"
              cols="90" required></textarea>
          </li>
          <li class="form-row">
            <div class="screenshot">
              <div name="blob" id="blob-content" hidden></div>
              <img id="image-news-blob" style="max-width: 100%;box-shadow: 0 0 15px black;border-radius:2px; "
                src="img/RemnantBG.png" alt="Girl in a jacket"></img>
              <input style="width:100%;" type="file" id="news-file-blob" accept=".png, .jpg, .jpeg" />
            </div>
          </li>
          <div id="managerFormButtonContainer">
            <button type="button" id="publish-news">Publier</button>
          </div>

        </ul>
      </form>
    </div>
    <script>
      document.getElementById("news-file-blob").addEventListener("change", getBlob);
      document.getElementById("publish-news").addEventListener("click", publishNews);
      fetchAllNews()
    </script>
</body>

</html>