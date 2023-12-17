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
   <!DOCTYPE html>
   <html lang="en">
   <object name="forbiddenAccess" type="text/html" data="forbiddenAccess.html"></object>
   </html>
  EOL;
  return;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="adminDashboard.css">
  <script src="updateGameDetails.js"></script>
  <script src="getImageBinaryContent.js"></script>
  <script src="adminDashboard.js"></script>
</head>

<body id="adminDashboardBody">
  <?php
  function get_updated_game()
  {
    $updated_game = "";
    if (isset($_SESSION['updated_game'])) {
      $updated_game = json_encode(unserialize(base64_decode($_SESSION['updated_game'])));
    }
    echo $updated_game;
  }
  function unset_updated_game()
  {
    if (isset($_SESSION['updated_game'])) {
      unset($_SESSION['updated_game']);
    }
  }
  session_start();
  ?>

  <script>
    document.addEventListener("DOMContentLoaded", () => {
      let displayUpdatedGame = `<?php echo (int) isset($_SESSION['updated_game']) ?>`;
      console.log("Display = '" + displayUpdatedGame + "'");
      if (displayUpdatedGame === '1') {
        console.log("On est passé par la");
        let updated_game = JSON.parse(`<?php get_updated_game() ?>`);
        document.getElementById('score').value = updated_game['score'];
        document.getElementById('title').value = updated_game['title'];
        document.getElementById('endDate').value = updated_game['end_creation'];
        document.getElementById('description').innerHTML = updated_game['description'];
        document.getElementById('select-status').value = updated_game['status'];
        document.getElementById('weight').value = updated_game['weight'];
        document.getElementById('select-engine').value = updated_game['engine'];
        document.getElementById('select-type').value = updated_game['type'];
        document.getElementById('creationDate').value = updated_game['creation_date'];
        document.getElementById('select-device').value = updated_game['device'];
        document.getElementById('playersNumber').value = updated_game['players'];
        document.getElementById('total-budget').value = updated_game['total-budget'];
        document.getElementById('screenshot#_video-game-blob').src = updated_game['blob'];
        document.getElementById('blob_filename').innerHTML = updated_game['blob_name'];
        alert(JSON.stringify(updated_game));
        let unset_updated_game = `<?php unset_updated_game(); ?>`;
        fetchBudgets();
      }
    });

  </script>
  <?php
  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL);
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
    <li><a href="adminBrowseVideoGames.php">Les Jeux Vidéos</a></li>
    <li><a href="registerPage.php">M'enregistrer</a></li>
    <li><a href="loginPage.php">Me connecter</a></li>
    <li><a href="userProfile.php">Mon Profil</a></li>
    <li><a href="adminDashboard.php">Tableau de Bord Admin</a></li>
    <li><a href="adminCreateProducerManager.php">Créer un compte Producteur/Manager</a></li>
  </ul>


  <div class="flex-container">
    <div id="horizontalSpaceContainer"></div>
    <div id="horizontalMainSpaceContainer">
      <div id="videoListContainer">

      </div>
      <div id="internalhorizontalSpaceContainer"></div>
      <div class="displayGame">
        <form action="updateGameDetails.php" method="post">
          <ul class="wrapper">
            <li class="form-row">
              <label id="video-game-title" for="title">Titre</label>
              <input type="text" name="title" id="title" required />
            </li>
            <li class="form-row">
              <label for="score">Score</label>
              <input type="text" name="score" id="score" required />
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
                style="display:flex; align-items:center; justify-content: center; ; width:50%; font-size:16pt; color: yellow; text-shadow: 3px 3px 5px rgba(0, 0, 0, 0.306); background: transparent;  box-shadow: 0 0 15px rgba(61, 61, 61, 0.303); border-radius: 5px ; font-family:'Play', sans-serif; ; text-align:center; vertical-align:middle;"
                id="blob_filename"></div>
              <script type="text/javascript">
                document.getElementById("video-game-blob").addEventListener("change", getBlob);
              </script>
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
              <input type="date" name="creation_date" id="creationDate" />
            </li>
            <li id="video-game-delivery-date" class="form-row">
              <label for="endDate">Fin de production</label>
              <input type="date" name="end_creation" id="endDate">
            </li>
            <li id="video-game-budget" class="form-row">
              <label for="price">Budget Total</label>
              <input type="number" name="budget" id="total-budget" />
            </li>

            <li id="video-game-players" class="form-row">
              <label for="playersNumber">Nombres de joueurs</label>
              <input type="text" name="players" id="playersNumber">
            </li>
            <li id="video-game-create" class="form-row">
              <button type="submit" id="submit-button" style="width:25%;">Mettre à jour</button>

              <!--  <script>
           // document.getElementById('submit-button').addEventListener('click', updateGameDetails);
            </script> !-->

            </li>
          </ul>
        </form>
      </div>
      <div id="internalhorizontalSpaceContainer"></div>
      <div class="budgetListFormContainer">
        <div id="budgetListContainer" class="budgetListContainer">

        </div>
        <div class="internalVerticalSpaceContainer"></div>
        <div class="budgetFormContainer">

          <ul class="budgetForm">
            <li>
              <label for="actualBudget">Budget actuel</label>
              <input type="number" id="actualBudget">
            </li>
            <li>
              <label for="lastMaj">Dernière Maj</label>
              <input type="date" id="lastMaj">
            </li>
            <li>
              <label for="causeLastMaj">Motif</label>
              <textarea id="causeLastMaj"></textarea>
            </li>
            <li class="submit-container">
              <div style="width:20%;"></div>
              <button id="submit-budget" type="button">Ajouter</button>
              <div style="width:20%;"></div>
            </li>
          </ul>
        </div>
      </div>
      <div id="horizontalSpaceContainer"></div>
    </div>
    <script>
      fetchGames(true);
      document.getElementById("submit-budget").addEventListener("click", updateBudgets);
    </script>
  </div>
</body>

</html>
</body>

</html>