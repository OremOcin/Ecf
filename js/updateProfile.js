function getBlob(e) {
  e.stopPropagation();
  if (e.target.files) {
    {
      let file = e.target.files[0];
      var filename = String(file.name);
      let reader = new FileReader();
      reader.readAsDataURL(file);
      reader.onloadend = () => {
        if (file.size > 500 * 1024) {
          alert("size of uploaded file is more than 500 KB ");
          return;
        }
        document.getElementById("blob-content").innerHTML = reader.result;
        const dataTransfer = new DataTransfer();
        dataTransfer.items.add(file);
        document.getElementById("avatar").files = dataTransfer.files;
        document.getElementById("image-avatar-blob").src = reader.result;
      };
    }
  }
}

function updateProfile(e) {
  e.stopPropagation();
  const email = document.getElementById("email").value;
  const currentEmail = document.getElementById("user-email").innerHTML;
  if (email === "") {
    return;
  }
  const pseudo = document.getElementById("pseudo").value;
  if (pseudo === "") {
    return;
  }
  const password = document.getElementById("password").value;
  if (password === "") {
    return;
  }
  const blob = document.getElementById("blob-content").innerHTML;

  const firstName = document.getElementById("firstName").value;
  if (firstName === "") {
    return;
  }
  const lastName = document.getElementById("lastName").value;
  if (lastName === "") {
    return;
  }

  const data = {
    pseudo: pseudo,
    email: email,
    currentemail: currentEmail,
    password: password,
    blob: blob,
    firstname: firstName,
    lastname: lastName,
  };
  const doUpdate = doUpdateProfile(data);
}

const doUpdateProfile = async (data) => {
  const body = {
    data: data,
  };

  const doFetch = await fetch("../backend/doUpdateProfile.php", {
    method: "POST",
    body: JSON.stringify(data),
    headers: {
      Accept: "application/json",
    },
  })
    .then((result) => {
      return result.json();
    })
    .catch((error) => {
      console.log("doUpdateProfile error doFetch " + error);
    });
  alert(doFetch["response"]);
  const username = doFetch["username"];
  const loginDataDiv = document.getElementById("user-name-div");
  loginDataDiv.innerHTML = `${username}`;
};

async function fetchUserProfile() {
  const email = document.getElementById("user-email").innerHTML;
  const data = {
    email: email,
  };
  const fetchUserProfile = await doFetchUserProfile(data);
}

const doFetchUserProfile = async (data) => {
  const body = {
    data: data,
  };

  const doFetch = await fetch("../backend/fetchuserprofile.php", {
    method: "POST",
    body: JSON.stringify(data),
    headers: {
      Accept: "application/json",
    },
  })
    .catch((error) => {
      console.log("fetchuserprofile error doFetch " + error);
    })
    .then((result) => {
      return result.json();
    });
  document.getElementById("pseudo").value = doFetch["response"]["pseudo"];
  document.getElementById("email").value = doFetch["response"]["email"];
  document.getElementById("firstName").value = doFetch["response"]["firstname"];
  document.getElementById("lastName").value = doFetch["response"]["lastname"];
  const avatar = doFetch["response"]["avatar"];
  if (avatar === undefined || avatar === null) {
    return;
  }
  document.getElementById("image-avatar-blob").src =
    doFetch["response"]["avatar"];
  document.getElementById("blob-content").innerHTML =
    doFetch["response"]["avatar"];
};
