function formatDate(date) {
  var d = new Date(date),
    month = "" + (d.getMonth() + 1),
    day = "" + d.getDate(),
    year = d.getFullYear();

  if (month.length < 2) month = "0" + month;
  if (day.length < 2) day = "0" + day;

  return [year, month, day].join("-");
}

const clickToast = (e) => {
  e.stopPropagation();
  let target = e.currentTarget;
  let tbody = target.querySelector("tbody");

  let title = tbody.children[0].children[0].innerHTML;
  document.getElementById("title").value = title;

  let score = tbody.children[0].children[1].innerHTML;
  document.getElementById("score").value = score;

  let delivery_date = tbody.children[0].children[2].innerHTML;
  delivery_date = new Date(delivery_date);
  delivery_date = formatDate(delivery_date);
  document.getElementById("endDate").value = delivery_date;

  let span = target.querySelector("span");
  let description = span.children[0].innerHTML;
  document.getElementById("description").innerHTML = description;

  let status = span.children[1].innerHTML;
  document.getElementById("select-status").value = status;

  let weight = span.children[5].innerHTML;
  document.getElementById("weight").value = weight;

  let engine = span.children[3].innerHTML;
  document.getElementById("select-engine").value = engine;

  let type = span.children[2].innerHTML;
  document.getElementById("select-type").value = type;

  let creation_date = span.children[7].innerHTML;
  document.getElementById("creationDate").value = creation_date;

  let media = span.children[4].innerHTML;
  document.getElementById("select-device").value = media;

  let players = span.children[6].innerHTML;
  document.getElementById("playersNumber").value = players;

  let budget = span.children[9].innerHTML;
  document.getElementById("total-budget").value = budget;

  let image = span.children[10].innerHTML;
  document.getElementById("screenshot#_video-game-blob").src = image;
  document.getElementById("blob-content").value = image;

  let filename = span.children[11].innerHTML;
  document.getElementById("blob_filename").innerHTML = filename;
  document.getElementById("blob-filename").value = filename;
  fetchBudgets();
};

const fetchGames = async () => {
  const data = {};

  const listVideoContainer = document.getElementById("videoListContainer");
  listVideoContainer.innerHTML =
    "<div style=display:flex; flex-direction:column; width:100%; height:100%; font-size:12pt; color:yellow;>\
        <div class=spinner-border></div>\
          Loading please wait...\
    </div>";

  const fetchedGames = await fetch("../backend/adminBrowseVideoGames.php", {
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
  if (nodata) {
    listVideoContainer.innerHTML = `<div style=display:flex; flex-direction:column; align-items:center; width:100%; height:100%; font-size:15pt; color:yellow; >
              <svg xmlns=http://www.w3.org/2000/svg width=64 height=64 fill=currentColor class=bi bi-database-fill-exclamation viewBox=0 0 16 16>
                  <path d=M8 1c-1.573 0-3.022.289-4.096.777C2.875 2.245 2 2.993 2 4s.875 1.755 1.904 2.223C4.978 6.711 6.427 7 8 7s3.022-.289 4.096-.777C13.125 5.755 14 5.007 14 4s-.875-1.755-1.904-2.223C11.022 1.289 9.573 1 8 1Z/>
                  <path d=M2 7v-.839c.457.432 1.004.751 1.49.972C4.722 7.693 6.318 8 8 8s3.278-.307 4.51-.867c.486-.22 1.033-.54 1.49-.972V7c0 .424-.155.802-.411 1.133a4.51 4.51 0 0 0-4.815 1.843A12.31 12.31 0 0 1 8 10c-1.573 0-3.022-.289-4.096-.777C2.875 8.755 2 8.007 2 7Zm6.257 3.998L8 11c-1.682 0-3.278-.307-4.51-.867-.486-.22-1.033-.54-1.49-.972V10c0 1.007.875 1.755 1.904 2.223C4.978 12.711 6.427 13 8 13h.027a4.552 4.552 0 0 1 .23-2.002Zm-.002 3L8 14c-1.682 0-3.278-.307-4.51-.867-.486-.22-1.033-.54-1.49-.972V13c0 1.007.875 1.755 1.904 2.223C4.978 15.711 6.427 16 8 16c.536 0 1.058-.034 1.555-.097a4.507 4.507 0 0 1-1.3-1.905Z/>
                  <path d=M16 12.5a3.5 3.5 0 1 1-7 0 3.5 3.5 0 0 1 7 0Zm-3.5-2a.5.5 0 0 0-.5.5v1.5a.5.5 0 0 0 1 0V11a.5.5 0 0 0-.5-.5Zm0 4a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1Z/>
              </svg>
              <p>Aucun jeu n'a été trouvé dans la base de donnée</p>
         </div>
         `;

    return;
  } else if (dataFound) {
    listVideoContainer.innerHTML = "";
    let maxIndex = fetchedGames["games"].length - 1;
    let i = 0,
      index = 0;
    for (i; i <= maxIndex; i++) {
      let row = fetchedGames["games"][i];
      let videoToastElement = document.createElement("div");
      videoToastElement.className = "videoToast";
      videoToastElement.id = "videoToast#" + index;
      videoToastElement.addEventListener("click", clickToast);
      let content = `<span id="hidden-variables#${index}" hidden>
              <span id="description#${index}" >${row["description"]}</span>
              <span id="status#${index}" >${row["status"]}</span>
              <span id="category#${index}" >${row["category"]}</span>
              <span id="engine#${index}" >${row["engine"]}</span>
              <span id="media#${index}" >${row["media"]}</span>
              <span id="weight#${index}" >${row["weight"]}</span>
              <span id="players#${index}" >${row["players"]}</span>
              <span id="creation_date#${index}" >${row["creation_date"]}</span>
              <span id="last_modified#${index}" >${row["last_modified"]}</span>
              <span id="total_budget#${index}" >${row["budget"]}</span>
              <span id="blob#${index}" >${row["blob"]}</span>
              <span id="blob_name#${index}" >${row["blob_name"]}</span>
          </span>
         <div style="height:100%; width:100%; margin:10px; flex-grow:1;">
              <table class="videoToast-dashTable">
                <thead>
                    <tr>
                      <th>Titre</th>
                      <th>Score</th>
                      <th>Date de création</th>
                    </tr>
                </thead>
                <tbody>
                  <tr class=videoToast-dashTable-content >
                      <td id="title_${index}" >${row["title"]}</td>
                      <td>${row["score"]}</td>
                      <td>${row["delivery_date"]}</td>
                  </tr>
                </tbody>
              </table>
          </div>
           <div class=screenshot>
                 <img id="screenshot#_${index}" style="max-width: 100%;box-shadow: 0 0 15px black;border-radius:2px;"  src="${row["blob"]}" alt="Girl in a jacket">
           </div>`;
      if (index++ != maxIndex) {
        content += `<div class="videoListVerticalSpace"></div>`;
      }
      videoToastElement.innerHTML = content;
      listVideoContainer.appendChild(videoToastElement);
    }
  }
};

const fetchBudgets = () => {
  const title = document.getElementById("title").value;
  if (title === "") {
    return;
  }
  doFetchBudgets(title);
};
const doFetchBudgets = async (title) => {
  const data = { title: title };
  const fetchedBudgets = await fetch("../backend/fetchGameBudgets.php", {
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
  processBudgetsHtml(fetchedBudgets);
};

const getTopParent = (element, pattern) => {
  if (!element.parentElement.getAttribute("id").includes(pattern)) {
    return element;
  }
  element = element.parentElement;
  return getTopParent(element, pattern);
};

const clickTrash = async (e) => {
  e.stopPropagation();
  const buttonTrash = getTopParent(e.target, "button-trash");
  const title = document.getElementById("trash-button-title").innerHTML;
  const date = document.getElementById("trash-button-date").innerHTML;
  const value = document.getElementById("trash-button-value").innerHTML;
  const comments = document.getElementById("trash-button-motif").innerHTML;
  const data = { title: title, date: date, value: value, comments: comments };
  const fetchRemoveBudget = await fetch("../backend/removeBudget.php", {
    method: "POST",
    body: JSON.stringify(data),
    headers: {
      Accept: "application/json",
    },
  })
    .catch((error) => {
      console.log("CreateGame error doFetch " + error);
    })
    .then((result) => {
      return result.json();
    });
  fetchBudgets();
};
const updateBudgets = async (e) => {
  e.stopPropagation();
  const title = document.getElementById("title").value;
  const value = document.getElementById("actualBudget").value;
  let date = document.getElementById("lastMaj").value;
  date = date.replaceAll("-", "/");
  const comment = document.getElementById("causeLastMaj").value;
  const budget = { title: title, value: value, date: date, comment: comment };

  const fetchedBudgets = await fetch("../backend/fetchAddBudget.php", {
    method: "POST",
    body: JSON.stringify(budget),
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
  processBudgetsHtml(fetchedBudgets);
  document.getElementById("title").value = "";
  document.getElementById("actualBudget").value = "";
  document.getElementById("lastMaj").value = "";
  document.getElementById("causeLastMaj").value = "";
};

function processBudgetsHtml(fetchedBudgets) {
  const size = fetchedBudgets["response"].length;
  let index = 0;
  const budgetListDiv = document.getElementById("budgetListContainer");
  budgetListDiv.innerHTML = "";
  for (let budget of fetchedBudgets["response"]) {
    const budgetDiv = document.createElement("div");
    budgetDiv.className = "budgetContainer";

    budgetDiv.setAttribute("id", "budget-div-" + index);
    const budgetValue = "budget-li-input-value-" + index;
    const budgetDate = "budget-li-input-date-" + index;
    const budgetMotif = "budget-li-textarea-" + index;
    const trashButtonId = "button-trash-" + index;
    budgetDiv.innerHTML = `<div id=${"icon-trash-" + index} class="budgetIcon">
    <button id=${trashButtonId} class="trash-button">
    <div id="trash-button-title" hidden>${title}</div>
    <div id="trash-button-date" hidden>${budget["date"]}</div>
    <div id="trash-button-value" hidden>${budget["value"]}</div>
    <div id="trash-button-motif" hidden>${budget["comments"]}</div>
      <svg id=${
        "button-trash-svg" + index
      } xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16">
        <path id=${
          "button-trash-svg-path-" + index
        } d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z"/>
      </svg>
      </button>
    </div>
      <div id=${"budget-" + index} style="width:90%; height:100%;" >
          <li id=${"budget-li-" + index} class="budgetItem" >
            <label id=${
              "budget-li-label-0-" + index
            } for=${budgetValue}>Montant</label>
            <input id=${budgetValue} type="text" value=${
      budget["value"]
    } readonly></input>
            <label id=${
              "budget-li-label-1-" + index
            } for=${budgetDate}>Date</label>
            <input id=${budgetDate} type="text" value=${
      budget["date"]
    } readonly></input>
            <label id=${
              "budget-li-label-1-" + index
            } for=${budgetMotif}>Motif</label>
            <textarea id=${budgetMotif} rows="4" cols="50" readonly>
            ${budget["comments"]}
            </textarea>
          </li>
      </div> 
    </div>`;
    budgetListDiv.appendChild(budgetDiv);
    document
      .getElementById(trashButtonId)
      .addEventListener("click", clickTrash);
    index++;
  }
}
