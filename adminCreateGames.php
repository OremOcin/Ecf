<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="adminDashboard.css">
  <script src="getImageBinaryContent.js"></script>
  <script src="adminFetchVideoGames.js"></script>
  <script src="adminCreateGame.js"></script>
</head>

<body id="adminDashboardBody">
  <?php
  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL);
  session_start();
  if (isset($_SESSION['message'])) {
    echo '<script language="javascript">';
    echo 'alert("' . $_SESSION['message'] . '")';
    unset($_SESSION['message']);
    echo '</script>';
  }
  ?>
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
      <div id="videoListContainer">

      </div>
    </div>
    <div id="internalhorizontalSpaceContainer"></div>
    <div class="displayGame">
      <form>
        <ul class="wrapper">
          <li class="form-row">
            <label id="video-game-title" for="title">Titre</label>
            <input type="text" name="title" id="title" required>
          </li>
          <li class="form-row">
            <label for="score">Score</label>
            <input type="text" name="score" id="score" required>
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
            <input type="text" id="studio" value="Gamesoft" readonly>
          </li>
          <div class="screenshot">
            <input type="text" name="blob" id="blob-content" hidden></input>
            <input type="text" name="blob-name" id="blob-filename" hidden></input>
            <img id="screenshot#_video-game-blob" style="max-width: 100%;box-shadow: 0 0 15px black;border-radius:2px; "
              src="img/RemnantBG.png" alt="Girl in a jacket">
            <input type="file" id="video-game-blob" accept=".png, .jpg, .jpeg">
            <script type="text/javascript">
              document.getElementById("video-game-blob").addEventListener("change", getBlob);
            </script>
            </input>
          </div>
          <div
            style="display:flex; align-items:center; justify-content: center; ; width:50%; font-size:16pt; color: yellow; text-shadow: 3px 3px 5px rgba(0, 0, 0, 0.306); background: transparent;  box-shadow: 0 0 15px rgba(61, 61, 61, 0.303); border-radius: 5px ; font-family:'Play', sans-serif; ; text-align:center; vertical-align:middle;"
            id="blob_filename">
          </div>
          <li id="video-game-device" class="form-row">
            <div class="filters-container">
              <label style="flex-grow:1;" for="device">Support</label>
              <div class="filters">
                <select style="flex-grow: 2;" name="select-device" id="select-device" required>
                  <option value="DESKTOP">DESKTOP</option>
                  <option value="XBOITE">XBOITE</option>
                </select>
              </div>
            </div>
          </li>
          <li id="video-game-engine" class="form-row">
            <div class="filters-container">
              <label style="flex-grow:1;" for="engine">Moteur de jeu</label>
              <div class="filters">
                <select style="flex-grow: 2;" name="select-engine" id="select-engine" required>
                  <option value="CryEngine">CryEngine</option>
                  <option value="Unreal Engine">Unreal Engine</option>
                  <option value="Unity 3D">Unity 3D</option>
                </select>
              </div>
            </div>
          </li>
          <li id="video-game-status" class="form-row">
            <div class="filters-container">
              <label style="flex-grow:1;" for="status">Statut</label>
              <div class="filters">
                <select style="flex-grow: 2;" name="select-status" id="select-status" required>
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
          </li>
          <li id="video-game-type" class="form-row">
            <div class="filters-container">
              <label style="flex-grow:1;" for="type">Type</label>
              <div class="filters">
                <select style="flex-grow: 2;" name="select-type" id="select-type" required>
                  <option value="RPG">RPG</option>
                  <option value="MMO">MMO</option>
                  <option value="Adventure">AVENTURE</option>
                  <option value="Action">ACTION</option>
                </select>
              </div>
            </div>
          </li>
          <li id="video-game-creation-date" class="form-row">
            <label for="creationDate">Début de création</label>
            <input type="date" name="creation_date" id="creationDate">
          </li>
          <li id="video-game-delivery-date" class="form-row">
            <label for="endDate">Fin de production</label>
            <input type="date" name="end_creation" id="endDate">
          </li>
          <li id="video-game-budget" class="form-row">
            <label for="price">Budget estimé</label>
            <input type="number" name="budget" id="price">
          </li>

          <li id="video-game-players" class="form-row">
            <label for="playersNumber">Nombres de joueurs</label>
            <input type="number" name="players" id="playersNumber">
          </li>
          <li id="video-game-create" class="form-row">
            <button type="button" id="button-create-game" style="width:25%;">Créer le jeu</button>
          </li>
        </ul>
      </form>
    </div>
    <div id="internalhorizontalSpaceContainer"></div>
    <div class="budgetListFormContainer">
      <div class="budgetListContainer">
        <ul class="budgetList">
          <?php
          $size = 10;
          for ($i = 0; $i < $size; $i++) {
            $budgetId = "budget_" . $i;

            echo "<div class=\"budgetContainer\" >
            <div class=\"budgetIcon\">
            <button class=\"trash-button\">
              <svg xmlns=\"http://www.w3.org/2000/svg\" width=\"25\" height=\"25\" fill=\"currentColor\" class=\"bi bi-trash-fill\" viewBox=\"0 0 16 16\">
                <path d=\"M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z\"/>
              </svg>
              </button>
            </div>
                      <div style=\"width:90%; height:100%;\" >
                          <li id=\"$budgetId\" class=\"budgetItem\" >
                            <label for=\"budgetValue\">Montant</label>
                            <input type=\"text\" id=\"budgetValue\" value=\"8000€\">
                            <label for=\"budgetMotif\">Motif</label>
                            <textarea id=\"budgetMotif\" rows=\"4\" cols=\"50\">
                            Voici le Motif
                            </textarea>
                          </li>
                      </div> 
                  </div>";
            if ($i != $size - 1) {
              echo "<div style=\"height:20px; width:100% ; \"></div>";
            }
          }
          ?>
        </ul>
      </div>
      <div class="internalVerticalSpaceContainer"></div>
      <div class="budgetFormContainer">

        <ul class="budgetForm">
          <li>
            <label for="actualBudget">Budget actuel</label>
            <input type="text" id="actualBudget">
          </li>
          <li>
            <label for="lastMaj">Dernière Maj</label>
            <input type="text" id="lastMaj">
          </li>
          <li>
            <label for="causeLastMaj">Motif</label>
            <input type="text" id="causeLastMaj">
          </li>
          <div class="submit-container">
            <div style="width:20%;"></div>
            <input id="submit-button" type="submit">
            <div style="width:20%;"></div>
          </div>
        </ul>
      </div>
    </div>
    <div id="horizontalSpaceContainer"></div>
  </div>
  <script>document.getElementById("button-create-game").addEventListener("click", adminCreateGame);
    fetchGames(false);
  </script>
</body>

</html>