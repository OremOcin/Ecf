async function logout() {
  const doLogOut = await fetch("logout.php", {
    method: "POST",
    body: JSON.stringify({}),
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
  alert("Vous avez été déconnecté.");
}
