<?php
session_start();
$_SESSION['email'] = 'bobo@bubu.com';
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>Rechercher dans la liste des jeux-vidéos</title>
  <link rel="stylesheet" href="userbrowseVideoGames.css">
  <script src="userFetchVideoGames.js"></script>
</head>

<body id="browseVideoGamesBody">
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

  <div class="mainContainer">
    <?php
    echo "<span id=\"email-user\" hidden>" . $_SESSION['email'] . "</span>"
      ?>

    <div style="display: flex; flex-direction: row; background-color: transparent">
      <div id="horizontalSpaceContainer"></div>
      <div class="toggle-favorite-games">
        <div class="content">
          <div id="toggle-state" hidden>false</div>
          <input type="checkbox" id="toggle-btn" />
          <label class="label-toggle" for="toggle-btn">
            <span class="thumb"></span>
          </label>
          <div class="lights">
            <span class="light-off"></span>
            <span class="light-on"></span>
          </div>

        </div>
      </div>
      <script>
        document.getElementById('toggle-btn').addEventListener('change', toggleFavorite);
      </script>
      <div id="horizontalSpaceContainer"></div>
    </div>
    <div class="flex-container">

      <div id="horizontalSpaceContainer"></div>
      <div id="horizontalMainSpaceContainer">
        <div id="videoListContainer">

        </div>
      </div>

      <div class="displayGame">
        <form action="updateGameDetails.php" method="post">
          <ul class="wrapper">
            <li class="form-row">
              <label id="video-game-title" for="title">Titre</label>
              <input type="text" name="title" id="title" required />
            </li>
            <li class="form-row">
              <label for="description">Description</label>
              <textarea id="description" name="description" rows="3" cols="80" required></textarea>
            </li>
            <li id="video-game-weight" class="form-row">
              <label for="weight">Priorité</label>
              <input type="number" id="weight" name="weight" required></input>
            </li>
            <li id="video-game-studio" class="form-row">
              <label for="studio">Studio</label>
              <input type="text" id="studio" value="Gamesoft" readonly></input>
            </li>
            <div style="display:flex; flex-direction:row;">
              <div class="screenshot">
                <input type="text" name="blob" id="blob-content" hidden></input>
                <input type="text" name="blob-name" id="blob-filename" hidden></input>
                <img id="screenshot#_video-game-blob"
                  style="max-width: 100%;box-shadow: 0 0 15px black;border-radius:2px; " src="img/RemnantBG.png"
                  alt="Girl in a jacket"></img>
                <input style="width:100%;" type="file" id="video-game-blob" accept=".png, .jpg, .jpeg" />
              </div>
              <div
                style="display:flex; align-items:center; justify-content: center; ; width:50%; font-size:16pt; color: yellow; text-shadow: 3px 3px 5px rgba(0, 0, 0, 0.306); background: transparent;  box-shadow: 0 0 15px rgba(61, 61, 61, 0.303); border-radius: 5px ; font-family:'Play', sans-serif; ; text-align:center; vertical-align:middle;overflow:auto"
                id="blob_filename"></div>
              <script type="text/javascript">
                document.getElementById("video-game-blob").addEventListener("change", getBlob);
              </script>
            </div>
            <li id="video-game-device" class="form-row">
              <label id="labelModified" for="device">Support</label>
              <input type="text" name="device" id="device" readonly />
            </li>
            <li id="video-game-engine" class="form-row">
              <label id="labelModified" for="engine">Moteur de jeu</label>
              <input type="text" name="engine" id="engine" readonly />
            </li>
            <li id="video-game-status" class="form-row">
              <label id="labelModified" for="status">Statut</label>
              <input type="text" name="status" id="status" readonly>
            </li>
            <li id="video-game-type" class="form-row">
              <label id="labelModified" for="type">Type</label>
              <input type="text" name="type" id="type" readonly />
            </li>
            <li id="video-game-creation-date" class="form-row">
              <label for="creationDate">Début de création</label>
              <input type="text" name="creation_date" id="creationDate" readonly />
            </li>
            <li id="video-game-delivery-date" class="form-row">
              <label for="endDate">Fin de production</label>
              <input type="text" name="end_creation" id="endDate" readonly>
            </li>
            <li id="video-game-players" class="form-row">
              <label for="playersNumber">Nombres de joueurs</label>
              <input type="text" name="players" id="playersNumber" readonly>
            </li>
          </ul>
        </form>
      </div>
      <div class="filters-container">
        <div class="middle-container">
          <div style="width:10%; height:100%;"></div>
          <div style="width:80%; height:100%;">
            <label class="score-label" for="admin-select-score">FILTRES</label>
            <div class="category-container">
              <label class="category-label" for="category-label">Catégories</label>
              <div class="filters-middle">
                <select name="select-category" id="select-category">
                  <option value="select category">Sélectionner la catégorie</option>
                  <option value="RPG">RPG</option>
                  <option value="MMO">MMO</option>
                  <option value="Adventure">AVENTURE</option>
                  <option value="Action">ACTION</option>
                </select>
              </div>
            </div>
            <div class="category-container">
              <label class="category-label" for="engine-label">Moteurs de jeux</label>
              <div class="filters-middle">
                <select name="select-engine" id="select-engine">
                  <option value="select engine">Sélectionner le moteur</option>
                  <option value="CryEngine">CryEngine</option>
                  <option value="Unreal Engine">Unreal Engine</option>
                  <option value="Unity 3D">Unity 3D</option>
                </select>
              </div>
            </div>
            <div class="category-container">
              <label class="category-label" for="engine-label">STATUT</label>
              <div class="filters-middle">
                <select name="select-statut" id="select-statut">
                  <option value="select status">Sélectionner le statut</option>
                  <option value="dev">dev</option>
                  <option value="released">released</option>
                  <option value="cancelled">Supprimé</option>
                  <option value="alpha">Version alpha</option>
                  <option value="beta">Version Beta</option>
                  <option value="standBy">En pause</option>
                  <option value="delayed">Sortie différée</option>
                </select>
              </div>
            </div>
            <div class="category-container">
              <label class="category-label" for="device-label">SUPPORT</label>
              <div class="filters-middle">
                <select name="select-device" id="select-device">
                  <option value="select device">Sélectionner le support</option>
                  <option value="DESKTOP">DESKTOP</option>
                  <option value="XBOITE">XBOITE</option>
                </select>
              </div>
            </div>
          </div>
          <div style="width:10%; height:100%;"></div>
        </div>
        <div style="height:30px; width:100%;"></div>
        <div class="bottom-container">
          <div class="category-container">
            <label class="category-label" for="category-label">Priorité</label>
            <div class="filters-middle">
              <select name="select-weight" id="select-weight">
                <option value="select weight">Sélectionner la priorité</option>
                <option value="ascendant">Ascendant</option>
                <option value="descendant">Descendant</option>
              </select>
            </div>
          </div>
          <div class="category-container">
            <label class="category-label" for="category-label">Date de Sortie</label>
            <div class="filters-middle">
              <select name="select-delivery-date" id="select-delivery-date">
                <option value="select date">Sélectionner la date</option>
                <option value="ascendant">Ascendant</option>
                <option value="descendant">Descendant</option>
              </select>
            </div>
          </div>
        </div>
      </div>
      <div id="horizontalSpaceContainer"></div>
    </div>
  </div>
  <script>
    document.getElementById('select-engine').addEventListener('change', userFetchGames);
    document.getElementById('select-statut').addEventListener('change', userFetchGames);
    document.getElementById('select-category').addEventListener('change', userFetchGames);
    document.getElementById('select-device').addEventListener('change', userFetchGames);
    document.getElementById('select-delivery-date').addEventListener('change', userFetchGames);
    document.getElementById('select-weight').addEventListener('change', userFetchGames);
    userFetchGames();
  </script>
</body>

</html>
</body>

</html>