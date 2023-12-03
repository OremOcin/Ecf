async function login() {
  const loginButton = document.getElementById("login");
  if (loginButton) {
    const email = document.getElementById("email").value;
    const pwd = document.getElementById("pwd").value;
    if (email && pwd) {
      const doLogin = await fetch("login.php", {
        method: "POST",
        body: JSON.stringify({ email: email, pwd: pwd }),
        headers: {
          Accept: "application/json",
        },
      })
        .catch((error) => {
          console.log("login error doFetch " + error);
        })
        .then((result) => {
          return result.json();
        });
      if (doLogin && doLogin["response"] === false) {
        alert("Connexion impossible : Aucun utilisateur n'a été trouvé.");
      } else {
        alert("Connexion réussie");
      }
      window.location.replace("index.php");
    }
  }
}
