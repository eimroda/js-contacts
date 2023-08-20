const setEventtListeners = () =>{
  document.getElementById("btnLogin").addEventListener("click", ()=>{login();});
  document.getElementById("linkRegister").addEventListener("click", ()=>{register();});
}

const login = () =>{
  const json = {
      username:document.getElementById("txtUsername").value,
      password:document.getElementById("txtPassword").value
  }
  const formData = new FormData();
  formData.append("json", JSON.stringify(json));
  formData.append("operation", "login")
  axios({
    url:'http://localhost/coc/contacts/api/user.php',
    method:'post',
    data:formData
  }).then(response =>{
    console.log(response.data)
    if(response.data == 0){
      alert("Invalid username or password, please try again!");
    }else{
      sessionStorage.setItem('userId', response.data.usr_id);
      sessionStorage.setItem('fullname', response.data.usr_fullname);
      window.location = 'main.html';
    }
  }).catch(error =>{
    alert(error);
  })

  

}

const register = () => {
  clearBlankModalBody();
  //display modal here
  document.getElementById("blankModalTitle").innerText = "Register";

  var myHtml = `
    <label for="txtFullname" class="form-label mt-2">Full Name</label>
    <input type="text" id="txtFullname" class="form-control form-control-sm">
    <label for="txtUsername" class="form-label mt-2">Userame</label>
    <input type="text" id="txtUsername" class="form-control form-control-sm">
    <label for="txtPassword" class="form-label mt-2">Password</label>
    <input type="password" id="txtPassword" class="form-control form-control-sm">
  `;
  document.getElementById("blankModalMainDiv").innerHTML = myHtml;

  const div = document.createElement("div"); div.classList.add("text-center");
  const btnReg = document.createElement("button");
  btnReg.classList.add("btn", "btn-primary", "w-75", "mt-5");
  btnReg.innerText = "Register";
  btnReg.onclick = ()=>{closeModal();};

  div.append(btnReg);
  document.getElementById("blankModalMainDiv2").innerHTML="";
  document.getElementById("blankModalMainDiv2").append(div)

  const myModal = new bootstrap.Modal(document.getElementById('blankModal'), {
    keyboard: true,
    backdrop: "static"
  });
  myModal.show();
}

const closeModal = ()=>{
  const myModal = bootstrap.Modal.getInstance(document.getElementById('blankModal'));
  myModal.hide();
} 

const clearBlankModalBody = () =>{
  document.getElementById("blankModalMainDiv").innerHTML="";
  document.getElementById("blankModalMainDiv2").innerHTML="";
  document.getElementById("blankModalFooterDiv").innerHTML="";
}



setEventtListeners();