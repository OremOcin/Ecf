<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Rechercher dans la liste des jeux-vidéos</title>
  <link rel="stylesheet" href="browseVideoGames.css">
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
    <div style="display: flex; flex-direction: row; background-color: transparent">
      <div id="horizontalSpaceContainer"></div>
      <div class="display-favorite-games">
        <div
          style="display:flex; flex-direction:row;height:70%;width:30%;align-items:center;background: transparent; backdrop-filter: blur(5px); box-shadow: 0 0 5px rgba(0, 0, 0, 0.31); border-radius: 5px;">
          <div class="toggle-favorite-games">
            <div class="content">
              <input type="checkbox" id="toggle-btn">
              <label class="label-toggle" for="toggle-btn">
                <span class="thumb"></span>
              </label>
              <div class="lights">
                <span class="light-off"></span>
                <span class="light-on"></span>
              </div>

            </div>
          </div>
          <p
            style="font-family: 'Play', sans-serif ;text-align:center; vertical-align:middle ; text-shadow: 4px 4px 5px rgb(0, 0, 0) ; font-size:20pt ; color:yellow;">
            Mes jeux favoris
          </p>
        </div>
      </div>
      <div id="horizontalSpaceContainer"></div>
    </div>
    <div class="flex-container">

      <div id="horizontalSpaceContainer"></div>
      <div id="horizontalMainSpaceContainer">
        <div id="videoListContainer">
          <?php
          $size = 5;
          for ($i = 0; $i < $size; $i++) {
            echo "<div class=\"videoToast\" id=\"videoToast#$i\" >
          
          <div style=\"height:100%; width:60%; text-align: justify; text-justify: inter-word; margin:50px\">
          <svg xmlns=\"http://www.w3.org/2000/svg\" width=\"30\" height=\"30\" fill=\"currentColor\" class=\"bi bi-star\" viewBox=\"0 0 16 16\">
           <path d=\"M2.866 14.85c-.078.444.36.791.746.593l4.39-2.256 4.389 2.256c.386.198.824-.149.746-.592l-.83-4.73 3.522-3.356c.33-.314.16-.888-.282-.95l-4.898-.696L8.465.792a.513.513 0 0 0-.927 0L5.354 5.12l-4.898.696c-.441.062-.612.636-.283.95l3.523 3.356-.83 4.73zm4.905-2.767-3.686 1.894.694-3.957a.565.565 0 0 0-.163-.505L1.71 6.745l4.052-.576a.525.525 0 0 0 .393-.288L8 2.223l1.847 3.658a.525.525 0 0 0 .393.288l4.052.575-2.906 2.77a.565.565 0 0 0-.163.506l.694 3.957-3.686-1.894a.503.503 0 0 0-.461 0z\"/>
          </svg>
          <h1>Crysis</h1>
          <h2>22/03/2012</h2>
          <h3>Score</h3>
          <h4>12000€</h4>
          </div>
          <img style=\"max-width: 100%;box-shadow: 0 0 15px black;border-radius:2px; \" src=\"img/RemnantBG.png\" alt=\"Girl in a jacket\">
    </div>";
            if ($i != $size - 1) {
              echo "<div class=\"videoListVerticalSpace\" ></div>";
            }
          }
          ?>
        </div>
      </div>
      <div class="filters-container">
        <div style="display:flex; flex-direction:row; width:100%; height:50%; margin:15px;">
          <div style="width:15%; height:100%;"></div>
          <div class="top-container">
            <label class="score-label" for="admin-select-score">SCORE</label>
            <div class="filters-top">
              <select name="admin-select-score" id="admin-select-score">
                <option value="ascendant">Ascendant</option>
                <option value="descendant">Descendant</option>
              </select>
            </div>
          </div>
          <div style="width:15%; height:100%;"></div>
        </div>
        <div class="middle-container">
          <div style="width:10%; height:100%;"></div>
          <div style="width:80%; height:100%;">
            <label class="score-label" for="admin-select-score">FILTRES</label>
            <div class="category-container">
              <label class="category-label" for="category-label">Catégories</label>
              <div class="filters-middle">
                <select name="select-category" id="select-category">
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
                  <option value="DESKTOP">DESKTOP</option>
                  <option value="XBOITE">XBOITE</option>
                </select>
              </div>
            </div>
          </div>
          <div style="width:10%; height:100%;"></div>
        </div>
        <div class="bottom-container">
          <div class="category-container">
            <label class="category-label" for="category-label">Priorité</label>
            <div class="filters-middle">
              <select name="select-category" id="select-category">
                <option value="ascendant">Ascendant</option>
                <option value="descendant">Descendant</option>
              </select>
            </div>
          </div>
          <div class="category-container">
            <label class="category-label" for="category-label">Date de Création</label>
            <div class="filters-middle">
              <select name="select-category" id="select-category">
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

</body>

</html>
</body>

</html>

<!--  <table class="videoListTable">
        <thead>
          <tr>
            <th scope="col" class="videoGameCell">Nom</th>
            <th scope="col" class="videoGameCell">Date</th>
            <th scope="col" class="videoGameCell">Catégorie</th>
          </tr>
        </thead>
        <tbody>
     /*  <?php
     for ($i = 0; $i < 100; $i++) {

       echo "<tr>
              <th class=\"videoGameCell\"> nom $i </th>
              <td class=\"videoGameCell\">Date $i</td>
              <td class=\"videoGameCell\">Category $i</td>
              </tr>";
     }
     ?> */
        </tbody>
      </table>