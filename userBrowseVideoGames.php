<?php
session_start();
$role = array_key_exists("role", $_SESSION) ? $_SESSION["role"] : null;
$user_name = array_key_exists("username", $_SESSION) ? $_SESSION["username"] : null;
$user_email = array_key_exists("email", $_SESSION) ? $_SESSION["email"] : null;
echo "role " . is_null($role) . "\n";
echo "username " . is_null($user_name) . "\n";
echo "email " . is_null($user_email) . "\n";

function getEmail()
{
  global $user_email;
  if (!is_null($user_email)) {
    return $user_email;
  }
  return null;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>Rechercher dans la liste des jeux-vidéos</title>
  <link rel="stylesheet" href="userBrowseVideoGames.css">
  <script src="fetchVideoGames.js"></script>
  <script src="logout.js"></script>
</head>

<body id="browseVideoGamesBody">
  <script>
    var email = `<?php echo getEmail(); ?>`;
    console.log("email is set to : '" + email + "'");
  </script>
  <header id="indexHeader" class="index-header">
    <img id="indexLogo" src="img/logo_gamesoft refait.png" alt="Logo de L'entreprise">
    <h1 id="indexTitle">Bienvenue sur votre plateforme en ligne Gamesoft Studio <br> Stats et News sur
      vos jeux
      favoris ! Infos de développement ! Suivi de tous vos jeux ! <br>
      Discussion entre passionnés !</h1>
    <?php
    if (!is_null($user_name) && !is_null($user_email)) {
      echo "
     <div class=\"login-data\">
      <div class=\"login-data-inside-div\">
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
      <div style=\"padding-right:2rem;padding-left:2rem;font-size:1rem;\">
      Bienvenue
      " . $user_name . "
      connecté en tant que " . $role . "
      </div>
      <div id=\"sign-out\" class=\"login-data-inside-div\">
      <svg height=\"32px\" width=\"32px\" class=\"svg-icon\" style=\"vertical-align: middle;fill: #ffff00;overflow: hidden;\" viewBox=\"0 0 1024 1024\" version=\"1.1\" xmlns=\"http://www.w3.org/2000/svg\"><path d=\"M768 106V184c97.2 76 160 194.8 160 328 0 229.6-186.4 416-416 416S96 741.6 96 512c0-133.2 62.8-251.6 160-328V106C121.6 190.8 32 341.2 32 512c0 265.2 214.8 480 480 480s480-214.8 480-480c0-170.8-89.6-321.2-224-406z\" /><path d=\"M512 32c-17.6 0-32 14.4-32 32v448c0 17.6 14.4 32 32 32s32-14.4 32-32V64c0-17.6-14.4-32-32-32z\" /></svg>
      </div>
      </div>";
    }
    ?>
  </header>

  <ul class="homeNavBar">
    <li><a href="index.php">Accueil</a></li>
    <?php
    if (is_null($user_name) && is_null($user_email)) {
      echo "<li><a href=\"registerPage.php\">M'enregistrer</a></li>
            <li><a href=\"loginPage.php\">Me connecter</a></li>";
    } else {
      if (!is_null($role) && strcmp($role, "user") !== 0) {
        echo "<li><a href=\"adminDashboard.php\">Tableau de Bord</a></li>";
      }
      echo "<li><a href=\"userProfile.php\">Mon Profil</a></li>";
    }
    ?>
  </ul>

  <div class="mainContainer">
    <div style="display: flex; flex-direction: row; background-color: transparent">
      <div id="horizontalSpaceContainer"></div>
      <?php
      if (!is_null($user_name) && !is_null($role) && $role === "user") {
        echo <<<EOL
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
      EOL;
      }
      ?>
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
  <?php
  echo ("email = '" . $user_email . "'");
  if (!is_null($user_email) && !is_null($role) && $role === "user") {
    echo <<<EOL
      <script>
      fetchUserGames();
      document.getElementById('select-engine').addEventListener('change', fetchUserGames);
      document.getElementById('select-statut').addEventListener('change', fetchUserGames);
      document.getElementById('select-category').addEventListener('change', fetchUserGames);
      document.getElementById('select-device').addEventListener('change', fetchUserGames);
      document.getElementById('select-delivery-date').addEventListener('change', fetchUserGames);
      document.getElementById('select-weight').addEventListener('change', fetchUserGames);
      </script>
      EOL;
  } else {

    echo <<<EOL
      <script>
      fetchAllVideoGames();
      document.getElementById('select-engine').addEventListener('change', fetchAllVideoGames);
      document.getElementById('select-statut').addEventListener('change', fetchAllVideoGames);
      document.getElementById('select-category').addEventListener('change', fetchAllVideoGames);
      document.getElementById('select-device').addEventListener('change', fetchAllVideoGames);
      document.getElementById('select-delivery-date').addEventListener('change', fetchAllVideoGames);
      document.getElementById('select-weight').addEventListener('change', fetchAllVideoGames);
      </script>
      EOL;
  }
  ?>
  <script>
    const signout = document.getElementById("sign-out");
    if (signout) {
      signout.addEventListener("click", logout);
    }
  </script>
</body>

</html>
</body>

</html>