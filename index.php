<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="index.css">
  <script src="managerDashboard.js"></script>
</head>

<body id="indexBody">
  <script>
    var intervalId = -1;
  </script>

  <header id="indexHeader">
    <img id="indexLogo" src="img/logo_gamesoft refait.png" alt="Logo de L'entreprise">
    <h1 id="indexTitle">Bienvenue sur votre plateforme en ligne Gamesoft Studio <br> Stats et News sur
      vos jeux
      favoris ! Infos de développement ! Suivi de tous vos jeux ! <br>
      Discussion entre passionnés !</h1>
  </header>

  <ul class="homeNavBar">
    <li><a href="#home">Accueil</a></li>
    <li><a href="userBrowseVideoGames.php">Jeux</a></li>
    <li><a href="registerPage.php">M'enregistrer</a></li>
    <li><a href="loginPage.php">Me connecter</a></li>
    <li><a href="userProfile.php">Mon Profil</a></li>
    <li><a href="adminDashboard.php">Tableau de Bord Admin</a></li>
  </ul>

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
    console.log("intervalId before = " + intervalId);
    window.onbeforeunload = function (event) {
      clearInterval(intervalId);
      clearInterval = -1;
    };
    /*window.addEventListener("load", (e) => {
      intervalId = setInterval(() => {
        fetchAllNews();
      }, 15000);
    });*/
    FetchAllDevGames();
  </script>
</body>

</html>