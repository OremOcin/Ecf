async function login() {
  const loginButton = document.getElementById("login");
  if (loginButton) {
    const email = document.getElementById("email");
    const pwd = document.getElementById("pwd");
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
    }
  }
}
