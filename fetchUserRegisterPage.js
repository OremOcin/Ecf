const registerUser = (e)=>{
  e.stopPropagation();
  
  let firstname = document.getElementById('firstName').value;
  let name = document.getElementById('name').value;
  let email = document.getElementById('email').value;
  let pwd = document.getElementById('pwd').value;

  let data = {"firstname":firstname, "name":name, "email":email, "pwd":pwd};
  console.log(JSON.stringify(data));
  const response = fetchUserInfo(data);
}

const fetchUserInfo = async (data)=>{

  const body={
    'data':data
      };
    

const fetchUserDetails = await fetch('registerUser.php', 
  {
      method: "POST",
      body: JSON.stringify(data),
      headers: {
          Accept: 'application/json'
      }
  }).catch( (error)=>{console.log("registerPage error doFetch "+error);} ).
  then( (result) =>{
     return  result.json();

  });
  console.log(JSON.stringify(fetchUserDetails));
  alert(fetchUserDetails['response']);
  window.location = "index.php";
}
