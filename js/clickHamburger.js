function clickHamburger(e) {
  e.stopPropagation();
  const homeNavBar = document.getElementById("home-navbar");
  const navbar = document.getElementById("responsive-navbar");
  if (navbar.style.display === "none") {
    navbar.style.display = "flex";
    homeNavBar.style.flexDirection = "column";
    homeNavBar.style.justifyContent = "start";
    homeNavBar.style.alignItems = "start";
  } else {
    navbar.style.display = "none";
  }
}
