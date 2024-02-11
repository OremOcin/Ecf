const fetchFavoriteGames = async (data) => {
  const listVideoContainer = document.getElementById("videoListContainer");
  listVideoContainer.innerHTML = `<div style="display:flex; flex-direction:column; align-items:center; justify-content; center; margin-top: 350px; width:100%; height:100%; font-size:12pt; color:yellow;">
        <div class="spinner-border"></div>
          Loading please wait...
          <div class="lds-dual-ring"></div>
    </div>`;

  const fetchedGames = await fetch("../backend/userFetchFavoriteGames.php", {
    method: "POST",
    body: JSON.stringify(data),
    headers: {
      Accept: "application/json",
    },
  })
    .then((result) => {
      return result.json();
    })
    .catch((error) => {
      console.log("adminFetchVideoGames error doFetch " + error);
    });
  console.log("fetch games ", fetchedGames);
  const response =
    fetchedGames["response"] !== null && fetchedGames["response"] !== undefined;
  if (response) {
    alert(fetchedGames["response"]);
    return;
  }
  console.log(JSON.stringify(fetchedGames["response"]));
  let found =
    fetchedGames["games"] !== null &&
    fetchedGames["games"] !== undefined &&
    fetchedGames["games"].length !== 0;
  console.log("found is " + found);
  if (!found) {
    listVideoContainer.innerHTML =
      '<div style="display:flex; flex-direction:column; align-items:center; justify-content:center; width:100%; height:100%; font-size:15pt; color:yellow;" >\
            <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="currentColor" class="bi bi-database-fill-exclamation" viewBox="0 0 16 16">\
                <path d="M8 1c-1.573 0-3.022.289-4.096.777C2.875 2.245 2 2.993 2 4s.875 1.755 1.904 2.223C4.978 6.711 6.427 7 8 7s3.022-.289 4.096-.777C13.125 5.755 14 5.007 14 4s-.875-1.755-1.904-2.223C11.022 1.289 9.573 1 8 1Z"/>\
                <path d="M2 7v-.839c.457.432 1.004.751 1.49.972C4.722 7.693 6.318 8 8 8s3.278-.307 4.51-.867c.486-.22 1.033-.54 1.49-.972V7c0 .424-.155.802-.411 1.133a4.51 4.51 0 0 0-4.815 1.843A12.31 12.31 0 0 1 8 10c-1.573 0-3.022-.289-4.096-.777C2.875 8.755 2 8.007 2 7Zm6.257 3.998L8 11c-1.682 0-3.278-.307-4.51-.867-.486-.22-1.033-.54-1.49-.972V10c0 1.007.875 1.755 1.904 2.223C4.978 12.711 6.427 13 8 13h.027a4.552 4.552 0 0 1 .23-2.002Zm-.002 3L8 14c-1.682 0-3.278-.307-4.51-.867-.486-.22-1.033-.54-1.49-.972V13c0 1.007.875 1.755 1.904 2.223C4.978 15.711 6.427 16 8 16c.536 0 1.058-.034 1.555-.097a4.507 4.507 0 0 1-1.3-1.905Z"/>\
                <path d="M16 12.5a3.5 3.5 0 1 1-7 0 3.5 3.5 0 0 1 7 0Zm-3.5-2a.5.5 0 0 0-.5.5v1.5a.5.5 0 0 0 1 0V11a.5.5 0 0 0-.5-.5Zm0 4a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1Z"/>\
            </svg>\
            <p>Aucun jeu n\'a été trouvé dans la base de donnée</p>\
       </div>\
       ';

    return;
  } else {
    listVideoContainer.innerHTML = "";
    let maxIndex = fetchedGames["games"].length - 1;
    console.log("Max index = " + maxIndex);
    let i = 0,
      index = 0;
    for (i; i <= maxIndex; i++) {
      let row = fetchedGames["games"][i];
      let videoToastElement = document.createElement("div");
      // videoToastElement.addEventListener('click', clickStarIcon);
      videoToastElement.className = "videoToast";
      videoToastElement.id = "videoToast#" + index;
      videoToastElement.style.display = "flex";
      videoToastElement.style.alignItems = "center";
      videoToastElement.style.justifyContent = "center";
      videoToastElement.style.width = "100%";

      const eyeStarContainer = document.createElement("div");
      eyeStarContainer.id = "eye-star-container-" + index;
      eyeStarContainer.className = "eyeStarContainer";

      let eyeButton = document.createElement("div");
      eyeButton.className = "eyeButton";
      eyeButton.id = "eye-button" + index;

      eyeButton.innerHTML = `<div id="eye-div-${index}" style="display:flex; justify-content:center;">
        <div id="eye-div-title-${index}" hidden>${row["title"]}</div>
        <div id="eye-div-description-${index}" hidden>${row["description"]}</div>
        <div id="eye-div-category-${index}" hidden>${row["category"]}</div>
        <div id="eye-div-engine-${index}" hidden>${row["engine"]}</div>
        <div id="eye-div-status-${index}" hidden>${row["status"]}</div>
        <div id="eye-div-media-${index}" hidden>${row["media"]}</div>
        <div id="eye-div-weight-${index}" hidden>${row["weight"]}</div>
        <div id="eye-div-players-${index}" hidden>${row["players"]}</div>
        <div id="eye-div-creation-date-${index}" hidden>${row["creation_date"]}</div>
        <div id="eye-div-delivery-date-${index}" hidden>${row["delivery_date"]}</div>
        <div id="eye-div-blob-${index}" hidden>${row["blob"]}</div>
        <div id="eye-div-blob-name-${index}" hidden>${row["blob_name"]}</div>
        <div class="magnifySvg" id="div-eye-svg-${index}">
          <svg id="eye-svg-${index}" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path id="eye-path-${index}-0" d="M15.0007 12C15.0007 13.6569 13.6576 15 12.0007 15C10.3439 15 9.00073 13.6569 9.00073 12C9.00073 10.3431 10.3439 9 12.0007 9C13.6576 9 15.0007 10.3431 15.0007 12Z" stroke="#ffff00" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
          <path id="eye-path-${index}-1" d="M12.0012 5C7.52354 5 3.73326 7.94288 2.45898 12C3.73324 16.0571 7.52354 19 12.0012 19C16.4788 19 20.2691 16.0571 21.5434 12C20.2691 7.94291 16.4788 5 12.0012 5Z" stroke="#ffff00" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
        </div>
       </div>`;
      // videoToastElement.appendChild(eyeButton);

      let starButton = document.createElement("div");
      starButton.id = "star-button-" + index;
      starButton.className = "starButton";

      starButton.innerHTML = `<div id="star-div-${index}" style="display:flex; justify-content:center;">
            <span id="favorite-state-${index}" hidden >true</span>
            <span id="title-${index}" hidden >${row["title"]}</span>
            <div class="magnifySvg" id="div-star-svg-${index}">
              <svg id="star-svg-${index}" xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-star-fill" style="color:yellow;" viewBox="0 0 16 16">
                <path id="star-path-${index}" d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
              </svg>
            </div>
        </div>`;

      let content = `<table class="videoToast-dashTable">
              <thead>
                  <tr>
                    <th>Titre</th>
                    <th>Date de création</th>
                  </tr>
              </thead>
              <tbody>
                <tr class="videoToast-dashTable-content" >
                    <td id="title_${index}">  ${row["title"]}</td>
                    <td>${row["delivery_date"]}</td>
                </tr>
              </tbody>
            </table>
        </div>
        <div class="screenshot">
          <img id="screenshot#_${index}" style="max-width: 100%;box-shadow: 0 0 15px black;border-radius:2px; " src="${row["blob"]}" alt="Girl in a jacket">
        </div>`;
      if (index != maxIndex) {
        content += `<div class="videoListVerticalSpace"></div>`;
      }
      videoToastElement.innerHTML += content;

      videoToastElement.prepend(eyeStarContainer);
      eyeStarContainer.appendChild(eyeButton);
      eyeStarContainer.appendChild(starButton);

      listVideoContainer.appendChild(videoToastElement);
      videoToastElement.addEventListener("click", clickGame);
      starButton.addEventListener("click", clickGame);
      index++;
    }
  }
};

const toggleFavorite = () => {
  let checkbox = document.getElementById("toggle-btn");
  let toggled = checkbox.checked;
  console.log("Checkbox is checked " + toggled);
  document.getElementById("toggle-state").innerHTML = toggled
    ? "false"
    : "true";

  if (toggled) {
    let email = document.getElementById("email-user");
    console.log("Email is " + email.innerHTML);
    const data = { email: email.innerHTML };
    console.log(JSON.stringify(data));

    fetchFavoriteGames(data);
    return;
  }
  fetchUserGames();
};

const getTopParent = (element, pattern) => {
  console.log("Element node name " + element.getAttribute("id"));
  if (!element.parentElement.getAttribute("id").includes(pattern)) {
    return element;
  }
  element = element.parentElement;
  return getTopParent(element, pattern);
};

const clickGame = (e) => {
  console.log("current target html : " + e.currentTarget.innerHTML);
  console.log("target html : " + e.target.innerHTML);
  let email = document.getElementById("email-user");
  console.log("email = ");
  console.log(email);
  if (email === undefined || email === null || email.innerHTML === "") {
    visualizeGameDetails(e);
    return;
  }

  if (e.target.innerHTML === "") {
    console.log("current target html : " + e.currentTarget.innerHTML);
  }

  let isEyeDiv = e.target.getAttribute("id").includes("eye");
  console.log(
    "target Node Name : " +
      e.target.nodeName +
      " " +
      e.target.getAttribute("id")
  );
  console.log(`Current target ${e.currentTarget.innerHTML}`);

  if (isEyeDiv) {
    visualizeGameDetails(e);
    return;
  } else {
    console.log("impossible.");
    console.log("target node name " + e.target.nodeName);
    let topParent = getTopParent(e.target, "star");
    console.log("TopParent " + topParent.innerHTML);
    let favoriteDiv = topParent.children[1].children[0].children[0];
    let title = topParent.children[1].children[0].children[1].innerHTML;
    console.log("favorite state " + favoriteDiv.innerHTML);
    console.log("title " + title);
    let email = document.getElementById("email-user");
    console.log("Click game email is : " + email.innerHTML);
    let favorite_id = favoriteDiv.getAttribute("id");
    favorite_id = favorite_id.substr(favorite_id.length - 1);
    console.log("Favorite id is " + favorite_id);
    console.log("Favorite html : " + favoriteDiv.innerHTML);
    let favorite_state = document.getElementById(
      "favorite-state-" + favorite_id
    );
    let isFavorite = false;
    if (favorite_state.innerHTML === "true") {
      favorite_state.innerHTML = "false";
    } else if (favorite_state.innerHTML === "false") {
      favorite_state.innerHTML = "true";
      isFavorite = true;
    }
    console.log("favorite state after " + favorite_state.innerHTML);
    let divStarSvg = document.getElementById("div-star-svg-" + favorite_id);
    console.log("div star svg html " + divStarSvg.innerHTML);
    if (!isFavorite) {
      divStarSvg.innerHTML = `<svg id="star-svg-${favorite_id}" xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-star" style="color:yellow;" viewBox="0 0 16 16">
     <path id="star-path-${favorite_id}" d="M2.866 14.85c-.078.444.36.791.746.593l4.39-2.256 4.389 2.256c.386.198.824-.149.746-.592l-.83-4.73 3.522-3.356c.33-.314.16-.888-.282-.95l-4.898-.696L8.465.792a.513.513 0 0 0-.927 0L5.354 5.12l-4.898.696c-.441.062-.612.636-.283.95l3.523 3.356-.83 4.73zm4.905-2.767-3.686 1.894.694-3.957a.565.565 0 0 0-.163-.505L1.71 6.745l4.052-.576a.525.525 0 0 0 .393-.288L8 2.223l1.847 3.658a.525.525 0 0 0 .393.288l4.052.575-2.906 2.77a.565.565 0 0 0-.163.506l.694 3.957-3.686-1.894a.503.503 0 0 0-.461 0z"/>
    </svg>`;
    } else {
      divStarSvg.innerHTML = `<svg id="star-svg-${favorite_id}" xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-star-fill" style="color:yellow;" viewBox="0 0 16 16">
    <path id="star-path-${favorite_id}" d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
    </svg>`;
    }
    let data = { email: email.innerHTML, fav: isFavorite, title: title };
    console.log(JSON.stringify(data));
    const updateGameFavoriteStatus = async (data) => {
      const updateFavoriteGameStatus = await fetch(
        "../backend/userUpdateFavoriteGame.php",
        {
          method: "POST",
          body: JSON.stringify(data),
          headers: {
            Accept: "application/json",
          },
        }
      )
        .catch((error) => {
          console.log("adminFetchVideoGames error doFetch " + error);
        })
        .then((result) => {
          return result.json();
        });
      console.log("Game status " + JSON.stringify(updateFavoriteGameStatus));
      alert(JSON.stringify(updateFavoriteGameStatus["response"]));
    };
    updateGameFavoriteStatus(data);
    data = { email: email.innerHTML };
    let checkbox = document.getElementById("toggle-btn");
    let toggled = checkbox.checked;
    if (toggled) {
      fetchFavoriteGames(data);
      return;
    }
    fetchUserGames();
  }
};

const visualizeGameDetails = (e) => {
  e.stopPropagation();

  let topParent = getTopParent(e.target, "eye");
  if (topParent.children[0].id.indexOf("gameData") !== -1) {
    console.log("Found gameData");
    let title = topParent.children[0].innerHTML;
    document.getElementById("title").value = title;

    let description = topParent.children[1].innerHTML;
    document.getElementById("description").innerHTML = description;

    let type = topParent.children[2].innerHTML;
    document.getElementById("type").value = type;

    let engine = topParent.children[3].innerHTML;
    document.getElementById("engine").value = engine;

    let status = topParent.children[4].innerHTML;
    document.getElementById("status").value = status;

    let media = topParent.children[5].innerHTML;
    document.getElementById("device").value = media;

    let weight = topParent.children[6].innerHTML;
    document.getElementById("weight").value = weight;

    let players = topParent.children[7].innerHTML;
    document.getElementById("playersNumber").value = players;

    let creation_date = topParent.children[8].innerHTML;
    document.getElementById("creationDate").value = creation_date;

    let delivery_date = topParent.children[9].innerHTML;
    delivery_date = new Date(delivery_date);
    delivery_date = formatDate(delivery_date);
    document.getElementById("endDate").value = delivery_date;

    let image = topParent.children[10].innerHTML;
    document.getElementById("screenshot#_video-game-blob").src = image;
    document.getElementById("blob-content").value = image;

    let filename = topParent.children[11].innerHTML;
    document.getElementById("blob_filename").innerHTML = filename;
    document.getElementById("blob-filename").value = filename;
    return;
  }
  console.log("TopParent ", topParent.children[0].innerHTML);
  console.log(topParent);

  let title = topParent.children[0].children[0].children[0].innerHTML;
  document.getElementById("title").value = title;

  let description = topParent.children[0].children[0].children[1].innerHTML;
  document.getElementById("description").innerHTML = description;

  let type = topParent.children[0].children[0].children[2].innerHTML;
  document.getElementById("type").value = type;

  let engine = topParent.children[0].children[0].children[3].innerHTML;
  document.getElementById("engine").value = engine;

  let status = topParent.children[0].children[0].children[4].innerHTML;
  document.getElementById("status").value = status;

  let media = topParent.children[0].children[0].children[5].innerHTML;
  document.getElementById("device").value = media;

  let weight = topParent.children[0].children[0].children[6].innerHTML;
  document.getElementById("weight").value = weight;

  let players = topParent.children[0].children[0].children[7].innerHTML;
  document.getElementById("playersNumber").value = players;

  let creation_date = topParent.children[0].children[0].children[8].innerHTML;
  document.getElementById("creationDate").value = creation_date;

  let delivery_date = topParent.children[0].children[0].children[9].innerHTML;
  delivery_date = new Date(delivery_date);
  delivery_date = formatDate(delivery_date);
  document.getElementById("endDate").value = delivery_date;

  let image = topParent.children[0].children[0].children[10].innerHTML;
  document.getElementById("screenshot#_video-game-blob").src = image;
  document.getElementById("blob-content").value = image;

  let filename = topParent.children[0].children[0].children[11].innerHTML;
  document.getElementById("blob_filename").innerHTML = filename;
  document.getElementById("blob-filename").value = filename;
};

const fetchUserGames = async () => {
  let select_delivery_date = document.getElementById("select-delivery-date");
  let delivery_date = "";
  if (
    !isNullOrUndefined(select_delivery_date) &&
    select_delivery_date.selectedIndex !== 0
  ) {
    delivery_date =
      select_delivery_date.options[select_delivery_date.selectedIndex].text;
    delivery_date = delivery_date === "Ascendant" ? "ASC" : "DESC";
    console.log("Delivery date is " + delivery_date);
  }

  let select_status = document.getElementById("select-statut");
  let status = "";
  if (!isNullOrUndefined(select_status) && select_status.selectedIndex !== 0) {
    status = select_status.options[select_status.selectedIndex].text;
    console.log("Status is " + status);
  }

  let select_weight = document.getElementById("select-weight");
  let weight = "";
  if (!isNullOrUndefined(select_weight) && select_weight.selectedIndex !== 0) {
    weight = select_weight.options[select_weight.selectedIndex].text;
    weight = weight === "Ascendant" ? "ASC" : "DESC";
    console.log("Weight is " + weight);
  }

  let select_engine = document.getElementById("select-engine");
  let engine = "";
  if (!isNullOrUndefined(select_engine) && select_engine.selectedIndex !== 0) {
    engine = select_engine.options[select_engine.selectedIndex].text;
    console.log("Engine is " + engine);
  }

  let select_category = document.getElementById("select-category");
  let type = "";
  if (
    !isNullOrUndefined(select_category) &&
    select_category.selectedIndex !== 0
  ) {
    type = select_category.options[select_category.selectedIndex].text;
    console.log("Type is " + type);
  }

  let select_media = document.getElementById("select-device");
  let media = "";
  if (!isNullOrUndefined(select_media) && select_media.selectedIndex !== 0) {
    media = select_media.options[select_media.selectedIndex].text;
    console.log("Media is " + media);
  }

  let toggle = document.getElementById("toggle-state");
  let fav = false;
  if (!isNullOrUndefined(toggle)) {
    fav = toggle.checked === "true";
    console.log("Fav is " + fav);
  }

  const data = {
    email: email,
    type: type,
    device: media,
    delivery_date: delivery_date,
    status: status,
    weight: weight,
    engine: engine,
    fav: fav,
  };

  const listVideoContainer = document.getElementById("videoListContainer");
  listVideoContainer.innerHTML = `<div style="display:flex; flex-direction:column; align-items:center; justify-content; center; margin-top: 350px; width:100%; height:100%; font-size:12pt; color:yellow;">
        <div class="spinner-border"></div>
          Loading please wait...
          <div class="lds-dual-ring"></div>
    </div>`;
  console.log("fetchUserGames data = " + JSON.stringify(data));

  const fetchedGames = await fetch("../backend/fetchVideoGames.php", {
    method: "POST",
    body: JSON.stringify(data),
    headers: {
      Accept: "application/json",
    },
  })
    .catch((error) => {
      console.log("adminFetchVideoGames error doFetch " + error);
    })
    .then((result) => {
      return result.json();
    });
  console.log("sql " + JSON.stringify(fetchedGames["sql"]));
  console.log("rows " + JSON.stringify(fetchedGames["rows"]));
  let nodata =
    fetchedGames["no_data"] != null && fetchedGames["no_data"] != undefined;
  let dataFound =
    fetchedGames["games"] != null && fetchedGames["games"] != undefined;
  console.log("no data = " + nodata + " Data found = " + dataFound);
  if (nodata) {
    listVideoContainer.innerHTML = `<div style="display:flex; flex-direction:column; align-items:center; justify-content:center; width:100%; height:100%; font-size:15pt; color:yellow;" >
              <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="currentColor" class="bi bi-database-fill-exclamation" viewBox="0 0 16 16">
                  <path d="M8 1c-1.573 0-3.022.289-4.096.777C2.875 2.245 2 2.993 2 4s.875 1.755 1.904 2.223C4.978 6.711 6.427 7 8 7s3.022-.289 4.096-.777C13.125 5.755 14 5.007 14 4s-.875-1.755-1.904-2.223C11.022 1.289 9.573 1 8 1Z"/>
                  <path d="M2 7v-.839c.457.432 1.004.751 1.49.972C4.722 7.693 6.318 8 8 8s3.278-.307 4.51-.867c.486-.22 1.033-.54 1.49-.972V7c0 .424-.155.802-.411 1.133a4.51 4.51 0 0 0-4.815 1.843A12.31 12.31 0 0 1 8 10c-1.573 0-3.022-.289-4.096-.777C2.875 8.755 2 8.007 2 7Zm6.257 3.998L8 11c-1.682 0-3.278-.307-4.51-.867-.486-.22-1.033-.54-1.49-.972V10c0 1.007.875 1.755 1.904 2.223C4.978 12.711 6.427 13 8 13h.027a4.552 4.552 0 0 1 .23-2.002Zm-.002 3L8 14c-1.682 0-3.278-.307-4.51-.867-.486-.22-1.033-.54-1.49-.972V13c0 1.007.875 1.755 1.904 2.223C4.978 15.711 6.427 16 8 16c.536 0 1.058-.034 1.555-.097a4.507 4.507 0 0 1-1.3-1.905Z"/>
                  <path d="M16 12.5a3.5 3.5 0 1 1-7 0 3.5 3.5 0 0 1 7 0Zm-3.5-2a.5.5 0 0 0-.5.5v1.5a.5.5 0 0 0 1 0V11a.5.5 0 0 0-.5-.5Zm0 4a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1Z"/>
              </svg>
              <p>Aucun jeu n'a été trouvé dans la base de donnée</p>
         </div>
         `;

    return;
  } else if (dataFound) {
    console.log(JSON.stringify(fetchedGames["games"]));
    //  listVideoContainer.innerHTML = "";
    listVideoContainer.innerHTML = "";
    let maxIndex = fetchedGames["games"].length - 1;
    console.log("Max index = " + maxIndex);
    let i = 0,
      index = 0;
    for (i; i <= maxIndex; i++) {
      let row = fetchedGames["games"][i];
      let videoToastElement = document.createElement("div");
      // videoToastElement.addEventListener('click', clickStarIcon);
      videoToastElement.className = "videoToast";
      videoToastElement.id = "videoToast#" + index;
      videoToastElement.style.display = "flex";
      videoToastElement.style.alignItems = "center";
      videoToastElement.style.justifyContent = "center";
      videoToastElement.style.width = "100%";

      const eyeStarContainer = document.createElement("div");
      eyeStarContainer.id = "eye-star-container-" + index;
      eyeStarContainer.className = "eyeStarContainer";
      let eyeButton = document.createElement("div");
      eyeButton.className = "eyeButton";
      eyeButton.id = "eye-button-" + index;

      eyeButton.innerHTML = `<div id="eye-div-${index}" style="display:flex; justify-content:center;">
        <div id="eye-div-title-${index}" hidden> ${row["title"]} </div>
        <div id="eye-div-description-${index}" hidden> ${row["description"]}</div>
        <div id="eye-div-category-${index}" hidden> ${row["category"]}</div>
        <div id="eye-div-engine-${index}" hidden> ${row["engine"]}</div>
        <div id="eye-div-status-${index}" hidden> ${row["status"]}</div>
        <div id="eye-div-media-${index}" hidden> ${row["media"]}</div>
        <div id="eye-div-weight-${index}" hidden> ${row["weight"]}</div>
        <div id="eye-div-players-${index}" hidden>${row["players"]}</div>
        <div id="eye-div-creation-date-${index}" hidden> ${row["creation_date"]}</div>
        <div id="eye-div-delivery-date-${index}" hidden> ${row["delivery_date"]}</div>
        <div id="eye-div-blob-${index}" hidden> ${row["blob"]}</div>
        <div id="eye-div-blob-name-${index}" hidden>" ${row["blob_name"]}</div>
        <div class="magnifySvg" id="div-eye-svg-${index}">
          <svg id="eye-svg-${index}" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path id="eye-path-${index}-0" d="M15.0007 12C15.0007 13.6569 13.6576 15 12.0007 15C10.3439 15 9.00073 13.6569 9.00073 12C9.00073 10.3431 10.3439 9 12.0007 9C13.6576 9 15.0007 10.3431 15.0007 12Z" stroke="#ffff00" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
          <path id="eye-path-${index}-1" d="M12.0012 5C7.52354 5 3.73326 7.94288 2.45898 12C3.73324 16.0571 7.52354 19 12.0012 19C16.4788 19 20.2691 16.0571 21.5434 12C20.2691 7.94291 16.4788 5 12.0012 5Z" stroke="#ffff00" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
        </div>
        </div>`;

      let starButton = document.createElement("div");
      starButton.id = "star-button-" + index;
      starButton.className = "starButton";

      if (!row["favorite"]) {
        starButton.innerHTML = `<div id="star-div-${index}" style="display:flex; justify-content:center;">
            <span id="favorite-state-${index}" hidden >${row["favorite"]}</span>
            <span id="title-${index}" hidden >${row["title"]}</span>
            <div class="magnifySvg" id="div-star-svg-${index}">
              <svg id="star-svg-${index}" xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-star" style="color:yellow;" viewBox="0 0 16 16">
                <path id="star-path-${index}" d="M2.866 14.85c-.078.444.36.791.746.593l4.39-2.256 4.389 2.256c.386.198.824-.149.746-.592l-.83-4.73 3.522-3.356c.33-.314.16-.888-.282-.95l-4.898-.696L8.465.792a.513.513 0 0 0-.927 0L5.354 5.12l-4.898.696c-.441.062-.612.636-.283.95l3.523 3.356-.83 4.73zm4.905-2.767-3.686 1.894.694-3.957a.565.565 0 0 0-.163-.505L1.71 6.745l4.052-.576a.525.525 0 0 0 .393-.288L8 2.223l1.847 3.658a.525.525 0 0 0 .393.288l4.052.575-2.906 2.77a.565.565 0 0 0-.163.506l.694 3.957-3.686-1.894a.503.503 0 0 0-.461 0z"/>
              </svg>
            </div>
        </div>`;
      } else {
        starButton.innerHTML = `<div id="star-div-${index}" style="display:flex; justify-content:center;" >
            <span id="favorite-state-${index}" hidden >${row["favorite"]}</span>
            <span id="title-${index}" hidden >${row["title"]}</span>
            <div class="magnifySvg" id="div-star-svg-${index}">
              <svg id="star-svg-${index}" xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-star-fill" style="color:yellow;" viewBox="0 0 16 16">
                <path id="star-path-${index}" d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
              </svg>
            </div>
        </div>`;
      }

      eyeStarContainer.appendChild(eyeButton);
      eyeStarContainer.appendChild(starButton);
      videoToastElement.appendChild(eyeStarContainer);

      let content = `<table class="videoToast-dashTable" style="justify-content:center; align-items:center;">
                <thead>
                    <tr>
                      <th>Titre</th>
                      <th>Date de création</th>
                    </tr>
                </thead>
                <tbody>
                  <tr class="videoToast-dashTable-content" >
                      <td id="title_${index}" > ${row["title"]}</td>
                      <td> ${row["delivery_date"]}</td>
                  </tr>
                </tbody>
              </table>
          </div>
           <div class="screenshot">
                 <img id="screenshot#_${index}" style="max-width: 100%;box-shadow: 0 0 15px black;border-radius:2px; " src="${row["blob"]}" alt="Girl in a jacket">
           </div>`;
      if (index != maxIndex) {
        content += `<div class="videoListVerticalSpace"></div>`;
      }
      videoToastElement.innerHTML += content;

      listVideoContainer.appendChild(videoToastElement);
      videoToastElement.addEventListener("click", clickGame);
      index++;
    }
  }
};

function isNullOrUndefined(variable) {
  return variable === null || variable === undefined;
}

function isSelected(text) {
  return !text.includes("Sélectionner");
}

function formatDate(date) {
  var d = new Date(date),
    month = "" + (d.getMonth() + 1),
    day = "" + d.getDate(),
    year = d.getFullYear();

  if (month.length < 2) month = "0" + month;
  if (day.length < 2) day = "0" + day;

  return [year, month, day].join("-");
}

const fetchAllVideoGames = async () => {
  let select_delivery_date = document.getElementById("select-delivery-date");
  let delivery_date = "";
  if (
    !isNullOrUndefined(select_delivery_date) &&
    select_delivery_date.selectedIndex !== 0
  ) {
    delivery_date =
      select_delivery_date.options[select_delivery_date.selectedIndex].text;
    delivery_date = delivery_date === "Ascendant" ? "ASC" : "DESC";
    console.log("Delivery date is " + delivery_date);
  }

  let select_status = document.getElementById("select-statut");
  let status = "";
  if (!isNullOrUndefined(select_status) && select_status.selectedIndex !== 0) {
    status = select_status.options[select_status.selectedIndex].text;
    console.log("Status is " + status);
  }

  let select_weight = document.getElementById("select-weight");
  let weight = "";
  if (!isNullOrUndefined(select_weight) && select_weight.selectedIndex !== 0) {
    weight = select_weight.options[select_weight.selectedIndex].text;
    weight = weight === "Ascendant" ? "ASC" : "DESC";
    console.log("Weight is " + weight);
  }

  let select_engine = document.getElementById("select-engine");
  let engine = "";
  if (!isNullOrUndefined(select_engine) && select_engine.selectedIndex !== 0) {
    engine = select_engine.options[select_engine.selectedIndex].text;
    console.log("Engine is " + engine);
  }

  let select_category = document.getElementById("select-category");
  let type = "";
  if (
    !isNullOrUndefined(select_category) &&
    select_category.selectedIndex !== 0
  ) {
    type = select_category.options[select_category.selectedIndex].text;
    console.log("Type is " + type);
  }

  let select_media = document.getElementById("select-device");
  let media = "";
  if (!isNullOrUndefined(select_media) && select_media.selectedIndex !== 0) {
    media = select_media.options[select_media.selectedIndex].text;
    console.log("Media is " + media);
  }
  console.log("Executing fetchallvideogames");
  const listVideoContainer = document.getElementById("videoListContainer");
  listVideoContainer.innerHTML = `<div style="display:flex; flex-direction:column; align-items:center; justify-content; center; margin-top: 350px; width:100%; height:100%; font-size:12pt; color:yellow;">
        <div class="spinner-border"></div>
          Loading please wait...
          <div class="lds-dual-ring"></div>
    </div>`;
  const data = {
    media: media,
    category: type,
    engine: engine,
    weight: weight,
    status: status,
    delivery_date: delivery_date,
  };
  const fetchedGames = await fetch("../backend/fetchVideoGames.php", {
    method: "POST",
    body: JSON.stringify(data),
    headers: {
      Accept: "application/json",
    },
  })
    .catch((error) => {
      console.log("adminFetchVideoGames error doFetch " + error);
    })
    .then((result) => {
      return result.json();
    });
  let nodata =
    fetchedGames["no_data"] != null && fetchedGames["no_data"] != undefined;
  let dataFound =
    fetchedGames["games"] != null && fetchedGames["games"] != undefined;
  console.log("no data = " + nodata + " Data found = " + dataFound);
  if (nodata) {
    listVideoContainer.innerHTML = `<div style="display:flex; flex-direction:column; align-items:center; justify-content:center; width:100%; height:100%; font-size:15pt; color:yellow;" >
              <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="currentColor" class="bi bi-database-fill-exclamation" viewBox="0 0 16 16">
                  <path d="M8 1c-1.573 0-3.022.289-4.096.777C2.875 2.245 2 2.993 2 4s.875 1.755 1.904 2.223C4.978 6.711 6.427 7 8 7s3.022-.289 4.096-.777C13.125 5.755 14 5.007 14 4s-.875-1.755-1.904-2.223C11.022 1.289 9.573 1 8 1Z"/>
                  <path d="M2 7v-.839c.457.432 1.004.751 1.49.972C4.722 7.693 6.318 8 8 8s3.278-.307 4.51-.867c.486-.22 1.033-.54 1.49-.972V7c0 .424-.155.802-.411 1.133a4.51 4.51 0 0 0-4.815 1.843A12.31 12.31 0 0 1 8 10c-1.573 0-3.022-.289-4.096-.777C2.875 8.755 2 8.007 2 7Zm6.257 3.998L8 11c-1.682 0-3.278-.307-4.51-.867-.486-.22-1.033-.54-1.49-.972V10c0 1.007.875 1.755 1.904 2.223C4.978 12.711 6.427 13 8 13h.027a4.552 4.552 0 0 1 .23-2.002Zm-.002 3L8 14c-1.682 0-3.278-.307-4.51-.867-.486-.22-1.033-.54-1.49-.972V13c0 1.007.875 1.755 1.904 2.223C4.978 15.711 6.427 16 8 16c.536 0 1.058-.034 1.555-.097a4.507 4.507 0 0 1-1.3-1.905Z"/>
                  <path d="M16 12.5a3.5 3.5 0 1 1-7 0 3.5 3.5 0 0 1 7 0Zm-3.5-2a.5.5 0 0 0-.5.5v1.5a.5.5 0 0 0 1 0V11a.5.5 0 0 0-.5-.5Zm0 4a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1Z"/>
              </svg>
              <p>Aucun jeu n'a été trouvé dans la base de donnée</p>
         </div>
         `;

    return;
  } else if (dataFound) {
    console.log(JSON.stringify(fetchedGames["games"]));
    //  listVideoContainer.innerHTML = "";
    listVideoContainer.innerHTML = "";
    let maxIndex = fetchedGames["games"].length - 1;
    console.log("Max index = " + maxIndex);
    let i = 0,
      index = 0;
    for (i; i <= maxIndex; i++) {
      let row = fetchedGames["games"][i];
      let videoToastElement = document.createElement("div");
      // videoToastElement.addEventListener('click', clickStarIcon);
      videoToastElement.className = "videoToast";
      videoToastElement.id = "videoToast#" + index;
      videoToastElement.style.display = "flex";
      videoToastElement.style.alignItems = "center";
      videoToastElement.style.justifyContent = "center";
      videoToastElement.style.width = "100%";

      videoToastElement.innerHTML = ` <div id="gameData-div-title-${index}" hidden>${row["title"]}</div>
      <div id="gameData-div-description-${index}" hidden>${row["description"]}</div>
      <div id="gameData-div-category-${index}" hidden>${row["category"]}</div>
      <div id="gameData-div-engine-${index}" hidden>${row["engine"]}</div>
      <div id="gameData-div-status-${index}" hidden>${row["status"]}</div>
      <div id="gameData-div-media-${index}" hidden>${row["media"]}</div>
      <div id="gameData-div-weight-${index}" hidden>${row["weight"]}</div>
      <div id="gameData-div-players-${index}" hidden>${row["players"]}</div>
      <div id="gameData-div-creation-date-${index}" hidden>${row["creation_date"]}</div>
      <div id="gameData-div-delivery-date-${index}" hidden>${row["delivery_date"]}</div>
      <div id="gameData-div-blob-${index}" hidden>${row["blob"]}</div>
      <div id="gameData-div-blob-name-${index}" hidden>${row["blob_name"]}</div>`;

      let tableContent = `<table class="videoToast-dashTable" style="justify-content:center; align-items:center;">
                <thead>
                    <tr>
                      <th>Titre</th>
                      <th>Date de création</th>
                    </tr>
                </thead>
                <tbody>
                  <tr class="videoToast-dashTable-content" >
                      <td id="title_${index}" > ${row["title"]}</td>
                      <td> ${row["delivery_date"]}</td>
                  </tr>
                </tbody>
              </table>
          </div>
           <div class="screenshot">
                 <img id="screenshot#_${index}" style="max-width: 100%;box-shadow: 0 0 15px black;border-radius:2px; " src="${row["blob"]}" alt="Girl in a jacket">
           </div>`;
      if (index != maxIndex) {
        tableContent += `<div class="videoListVerticalSpace"></div>`;
      }
      videoToastElement.innerHTML += tableContent;

      listVideoContainer.appendChild(videoToastElement);
      videoToastElement.addEventListener("click", clickGame);
      index++;
    }
  }
};
