const registerUser = (e) => {
  e.stopPropagation();
  let message = "Veuillez renseigner";
  let status = true;
  let firstname = document.getElementById("firstName").value;
  if (firstname === "") {
    status = false;
    message += `<br> Votre prénom `;
  }
  let name = document.getElementById("name").value;
  if (name === "") {
    status = false;
    message += `<br> Votre Nom `;
  }
  let email = document.getElementById("email").value;
  if (email === "") {
    status = false;
    message += `<br> Votre adresse courriel `;
  }
  let pwd = document.getElementById("pwd").value;
  if (pwd === "") {
    status = false;
    message += `<br> Votre mot de passe `;
  }
  if (!status) {
    const dialogue = `
       <button id="close-dialogue">
          Fermer
       </button>   
        <p>
          ${message}
        </p> `;
    const element = document.createElement("DIALOG");
    element.innerHTML = dialogue;
    element.setAttribute("id", "div-dialogue");
    document.body.appendChild(element);
    document
      .getElementById("close-dialogue")
      .addEventListener("click", closeDialogue);
    element.showModal();
    return;
  }
  let pseudo = document.getElementById("pseudo").value;

  let data = {
    firstname: firstname,
    name: name,
    email: email,
    pwd: pwd,
    pseudo: pseudo,
  };
  console.log(JSON.stringify(data));
  const response = fetchUserInfo(data);
};

function closeDialogue(e) {
  e.stopPropagation();
  const dialogue = document.getElementById("div-dialogue");
  dialogue.close();
  dialogue.remove();
  return;
}

const fetchUserInfo = async (data) => {
  const body = {
    data: data,
  };

  const fetchUserDetails = await fetch("../backend/registerUser.php", {
    method: "POST",
    body: JSON.stringify(data),
    headers: {
      Accept: "application/json",
    },
  })
    .catch((error) => {
      console.log("registerPage error doFetch " + error);
    })
    .then((result) => {
      return result.json();
    });
  console.log(JSON.stringify(fetchUserDetails));
  alert(fetchUserDetails["response"]);
  window.location = "index.php";
};
