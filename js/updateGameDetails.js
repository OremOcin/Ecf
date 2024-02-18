const updateGameDetails = () => {
  let title = document.getElementById("title").value;

  let description = document.getElementById("description").value;

  let score = document.getElementById("score").value;

  let delivery_date = document.getElementById("endDate").value;

  let span = document.getElementById("description").innerHTML;

  let status = document.getElementById("select-status").value;

  let weight = document.getElementById("weight").value;

  let engine = document.getElementById("select-engine").value;

  let type = document.getElementById("select-type").value;

  let creation_date = document.getElementById("creationDate").value;

  let media = document.getElementById("select-device").value;

  let players = document.getElementById("playersNumber").value;

  let budget = document.getElementById("total-budget").value;

  let image = document.getElementById("screenshot#_video-game-blob").src;

  let blob_name = document.getElementById("blob_filename").innerHTML;

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
    score: score,
    "total-budget": budget,
  };

  const response = fetchGameDetails(data);
};

const fetchGameDetails = async (data) => {
  const body = {
    data: data,
  };

  const fetchDetails = await fetch("../backend/updateGameDetails.php", {
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
};
