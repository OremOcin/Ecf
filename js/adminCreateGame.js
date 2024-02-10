const adminCreateGame = (e) => {
  e.stopPropagation();

  let title = document.getElementById("title").value;

  let delivery_date = document.getElementById("endDate").value;
  console.log("delivery is " + delivery_date);

  let description = document.getElementById("description").value;

  let select_status = document.getElementById("select-status");

  let status = "";
  status = select_status.options[select_status.selectedIndex].value;

  let select_engine = document.getElementById("select-engine");

  let engine = "";
  engine = select_engine.options[select_engine.selectedIndex].value;

  let select_category = document.getElementById("select-type");

  let type = "";

  type = select_category.options[select_category.selectedIndex].value;

  let select_media = document.getElementById("select-device");

  let media = "";

  media = select_media.options[select_media.selectedIndex].value;

  let creation_date = document.getElementById("creationDate").value;

  let players = document.getElementById("playersNumber").value;

  let budget = document.getElementById("price").value;

  let image = document.getElementById("screenshot#_video-game-blob").src;

  let blob_name = document.getElementById("blob_filename").innerHTML;

  let weight = document.getElementById("weight").value;

  let data = {
    title: title,
    blob: image,
    blob_name: blob_name,
    weight: weight,
    description: description,
    device: media,
    engine: engine,
    status: status,
    type: type,
    creation_date: creation_date,
    end_creation: delivery_date,
    players: players,
    "total-budget": budget,
  };
  console.log(JSON.stringify(data));

  const response = fetchCreateGame(data);
};

const fetchCreateGame = async (data) => {
  const body = {
    data: data,
  };

  const doFetch = await fetch("../backend/createGame.php", {
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
  console.log(JSON.stringify(doFetch));
  alert(doFetch["response"]);
  window.location = "adminCreateGamePage.php";
  window.location.reload();
};
