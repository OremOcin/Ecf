function publishNews() {
  const image = document.getElementById("blob-content").innerHTML;
  const title = document.getElementById("title").value;
  const content = document.getElementById("news-content").value;
  const data = { title: title, content: content, image: image };
  console.log("content = " + data);
  fetchNews(data);
}
async function fetchNews(data) {
  const doFetchNews = await fetch("publishNews.php", {
    method: "POST",
    body: JSON.stringify(data),
    headers: {
      Accept: "application/json",
    },
  })
    .catch((error) => {
      console.log("publishNews error doFetch " + error);
    })
    .then((result) => {
      return result.json();
    });
  console.log("doFetchNews response " + JSON.stringify(doFetchNews));
  fetchAllNews();
  document.getElementById("blob-content").innerHTML = "";
  document.getElementById("title").value = "";
  document.getElementById("news-content").value = "";
}

async function fetchAllNews() {
  const newsContainer = document.getElementById("news-container");
  newsContainer.innerHTML = `<div style="display:flex; flex-direction:column; align-items:center; justify-content; center; margin-top: 350px; width:100%; height:100%; font-size:12pt; color:yellow;">
        <div class="spinner-border"></div>
          Loading please wait...
          <div class="lds-dual-ring"></div>
    </div>`;
  const doFetchAllNews = await fetch("fetchAllNews.php", {
    method: "POST",
    body: JSON.stringify({}),
    headers: {
      Accept: "application/json",
    },
  })
    .catch((error) => {
      console.log("fetchAllNews error doFetch " + error);
    })
    .then((result) => {
      return result.json();
    });
  const allNews = doFetchAllNews["news"];
  //console.log("All news = " + JSON.stringify(allNews));
  if (allNews === null || allNews === undefined || allNews.length === 0) {
    const isNullOrUndefined = allNews === null || allNews === undefined;
    newsContainer.innerHTML = `<div style="display:flex; flex-direction:column; align-items:center; justify-content:center; width:100%; height:100%; font-size:15pt; color:yellow;" >
              <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="currentColor" class="bi bi-database-fill-exclamation" viewBox="0 0 16 16">
                  <path d="M8 1c-1.573 0-3.022.289-4.096.777C2.875 2.245 2 2.993 2 4s.875 1.755 1.904 2.223C4.978 6.711 6.427 7 8 7s3.022-.289 4.096-.777C13.125 5.755 14 5.007 14 4s-.875-1.755-1.904-2.223C11.022 1.289 9.573 1 8 1Z"/>
                  <path d="M2 7v-.839c.457.432 1.004.751 1.49.972C4.722 7.693 6.318 8 8 8s3.278-.307 4.51-.867c.486-.22 1.033-.54 1.49-.972V7c0 .424-.155.802-.411 1.133a4.51 4.51 0 0 0-4.815 1.843A12.31 12.31 0 0 1 8 10c-1.573 0-3.022-.289-4.096-.777C2.875 8.755 2 8.007 2 7Zm6.257 3.998L8 11c-1.682 0-3.278-.307-4.51-.867-.486-.22-1.033-.54-1.49-.972V10c0 1.007.875 1.755 1.904 2.223C4.978 12.711 6.427 13 8 13h.027a4.552 4.552 0 0 1 .23-2.002Zm-.002 3L8 14c-1.682 0-3.278-.307-4.51-.867-.486-.22-1.033-.54-1.49-.972V13c0 1.007.875 1.755 1.904 2.223C4.978 15.711 6.427 16 8 16c.536 0 1.058-.034 1.555-.097a4.507 4.507 0 0 1-1.3-1.905Z"/>
                  <path d="M16 12.5a3.5 3.5 0 1 1-7 0 3.5 3.5 0 0 1 7 0Zm-3.5-2a.5.5 0 0 0-.5.5v1.5a.5.5 0 0 0 1 0V11a.5.5 0 0 0-.5-.5Zm0 4a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1Z"/>
              </svg>
             ${
               isNullOrUndefined
                 ? `<p>Un problème est survenu avec la base de donnée.</p>`
                 : `<p>La base des news est vide.</p>`
             } 
         </div>
         `;
    return;
  }
  newsContainer.innerHTML = "";
  let content = "";
  const size = allNews.length;
  let i = 0;
  for (; i < size; i++) {
    content += `
    <div id="videoToast-${i}" class="toast" >
          <div id="toast-header-${i}" class="toast-header">
              <div id="toast-header-title-${i}" class="toast-header-title">${allNews[i]["title"]}
              </div>
              <div id="toast-header-date-${i}" class="toast-header-date">
                ${allNews[i]["date"]}
              </div>
          </div>
          <div id="toast-contents-${i}" class="toast-contents">
                <div class="toast-content">
                  <h2 >${allNews[i]["content"]}</h2>
                </div>
                <div class="toast-image">
                    <img class="screen-shot" id="screenshot#_${i}" src="${allNews[i]["image"]}" alt="Girl in a jacket">
                    </img>
                </div>
          </div>
    </div>`;
    if (i !== size - 1) {
      content += `<div class="videoListVerticalSpace"></div>`;
    }
  }
  newsContainer.innerHTML = content;
}

function getBlob(e) {
  e.stopPropagation();
  if (e.target.files) {
    {
      let file = e.target.files[0];
      var filename = String(file.name);
      let reader = new FileReader();
      reader.readAsDataURL(file);
      reader.onloadend = () => {
        if (file.size > 500 * 1024) {
          alert("size of uploaded file is more than 500 KB ");
          return;
        }
        document.getElementById("blob-content").innerHTML = reader.result;
        const dataTransfer = new DataTransfer();
        dataTransfer.items.add(file);
        document.getElementById("news-file-blob").files = dataTransfer.files;
        document.getElementById("image-news-blob").src = reader.result;
        console.log("Filename = " + filename);
      };
    }
  }
}

async function FetchAllDevGames() {
  const devGamesContainer = document.getElementById("games-dev-container");
  devGamesContainer.innerHTML = `<div style="display:flex; flex-direction:column; align-items:center; justify-content; center; margin-top: 350px; width:100%; height:100%; font-size:12pt; color:yellow;">
        <div class="spinner-border"></div>
          Loading please wait...
          <div class="lds-dual-ring"></div>
    </div>`;
  const doFetchDevGames = await fetch("fetchDevGames.php", {
    method: "POST",
    body: JSON.stringify({}),
    headers: {
      Accept: "application/json",
    },
  })
    .catch((error) => {
      console.log("fetchDevGames error doFetch " + error);
    })
    .then((result) => {
      return result.json();
    });

  console.log(doFetchDevGames);
  const fetchedDevGames = doFetchDevGames["games"];
  if (
    fetchedDevGames === null ||
    fetchedDevGames === undefined ||
    fetchedDevGames.length === 0
  ) {
    const isNullOrUndefined =
      fetchedDevGames === null || fetchedDevGames === undefined;
    devGamesContainer.innerHTML = `<div style="display:flex; flex-direction:column; align-items:center; justify-content:center; width:100%; height:100%; font-size:15pt; color:yellow;" >
              <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="currentColor" class="bi bi-database-fill-exclamation" viewBox="0 0 16 16">
                  <path d="M8 1c-1.573 0-3.022.289-4.096.777C2.875 2.245 2 2.993 2 4s.875 1.755 1.904 2.223C4.978 6.711 6.427 7 8 7s3.022-.289 4.096-.777C13.125 5.755 14 5.007 14 4s-.875-1.755-1.904-2.223C11.022 1.289 9.573 1 8 1Z"/>
                  <path d="M2 7v-.839c.457.432 1.004.751 1.49.972C4.722 7.693 6.318 8 8 8s3.278-.307 4.51-.867c.486-.22 1.033-.54 1.49-.972V7c0 .424-.155.802-.411 1.133a4.51 4.51 0 0 0-4.815 1.843A12.31 12.31 0 0 1 8 10c-1.573 0-3.022-.289-4.096-.777C2.875 8.755 2 8.007 2 7Zm6.257 3.998L8 11c-1.682 0-3.278-.307-4.51-.867-.486-.22-1.033-.54-1.49-.972V10c0 1.007.875 1.755 1.904 2.223C4.978 12.711 6.427 13 8 13h.027a4.552 4.552 0 0 1 .23-2.002Zm-.002 3L8 14c-1.682 0-3.278-.307-4.51-.867-.486-.22-1.033-.54-1.49-.972V13c0 1.007.875 1.755 1.904 2.223C4.978 15.711 6.427 16 8 16c.536 0 1.058-.034 1.555-.097a4.507 4.507 0 0 1-1.3-1.905Z"/>
                  <path d="M16 12.5a3.5 3.5 0 1 1-7 0 3.5 3.5 0 0 1 7 0Zm-3.5-2a.5.5 0 0 0-.5.5v1.5a.5.5 0 0 0 1 0V11a.5.5 0 0 0-.5-.5Zm0 4a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1Z"/>
              </svg>
             ${
               isNullOrUndefined
                 ? `<p>Un problème est survenu avec la base de donnée.</p>`
                 : `<p>La base des jeux en développement est vide.</p>`
             } 
         </div>
         `;
    return;
  }
  devGamesContainer.innerHTML = "";
  let content = "";
  const size = fetchedDevGames.length;
  let index = 0;
  for (; index < size; index++) {
    content += `<table class="videoToast-dashTable" style="justify-content:center; align-items:center;">
    <thead>
        <tr>
          <th>Titre</th>
          <th>Description</th>
          <th>Catégorie</th>
          <th>Support</th>
          <th>Moteur de jeux</th>
          <th>Date de sortie</th>
        </tr>
    </thead>
    <tbody>
      <tr class="videoToast-dashTable-content" >
          <td  id="title-${index}" > ${fetchedDevGames[index]["title"]}</td>
          <td id="description-${index}"> ${fetchedDevGames[index]["description"]}</td>
          <td id="category-${index}"> ${fetchedDevGames[index]["category"]["name"]}</td>
          <td id="media-${index}"> ${fetchedDevGames[index]["media"]["name"]}</td>
          <td id="engine-${index}"> ${fetchedDevGames[index]["engine"]["name"]}</td>
          <td id="delivery-date-${index}"> ${fetchedDevGames[index]["date"]}</td>
      </tr>
    </tbody>
  </table>
</div>`;
    if (index !== size - 1) {
      content += `<div class="videoListVerticalSpace"></div>`;
    }
  }
  devGamesContainer.innerHTML = content;
}
