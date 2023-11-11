function showPassword() {
  let showPasswordElement = document.getElementById("toggle-show-password");
  let viewPassword = showPasswordElement.value === "false";
  let pwdInput = document.getElementById("pwd");
  let eyeDiv = document.getElementById("eye-state");
  if (viewPassword) {
    showPasswordElement.attributes["value"].value = "true";
    pwdInput.attributes["type"].value = "text";
    eyeDiv.innerHTML = "<ion-icon style=\"width:25px; height:47px;\" name=\"eye-outline\"></ion-icon>";
  } else {
    showPasswordElement.attributes["value"].value = "false";
    pwdInput.attributes["type"].value = "password";
    eyeDiv.innerHTML = "<ion-icon style=\"width:25px; height:47px;\" name=\"eye-off-outline\"></ion-icon>";
  }
}

// Regarder tout les shémas de bases de données