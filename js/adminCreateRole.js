const adminCreateRole = (e) => {
  e.stopPropagation();

  let firstname = document.getElementById("firstName").value;
  let name = document.getElementById("name").value;
  let email = document.getElementById("email").value;
  let pwd = document.getElementById("pwd").value;
  let select = document.getElementById("adminAccountCreate");
  let role_select = select.options[select.selectedIndex].text;
  let role = "";
  switch (role_select) {
    case "Producteur/Productrice":
      role = "producer";
      break;
    default:
    case "Community Manager":
      role = "manager";
      break;
  }
  let data = {
    firstname: firstname,
    name: name,
    email: email,
    pwd: pwd,
    role: role,
  };
  console.log(JSON.stringify(data));
  const response = fetchRoleInfo(data);
};

const fetchRoleInfo = async (data) => {
  const body = {
    data: data,
  };

  const fetchRoleDetails = await fetch("../backend/adminCreateRole.php", {
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
  console.log(JSON.stringify(fetchRoleDetails));
  alert(fetchRoleDetails["response"]);
  window.location = "../pages/adminCreateProducerManagerPage.php";
};
