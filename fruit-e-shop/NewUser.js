// JavaScript Document


function CheckNewUserData() {
  if (document.NewUser.name.value==""){
     window.alert("Name is missing");
     document.NewUser.name.focus(true);
     return false;
  }
  if (document.NewUser.address.value==""){
     window.alert("Address is missing");
     document.NewUser.address.focus(true);
     return false;
  }
  if (document.NewUser.city.value==""){
     window.alert("City is missing");
     document.NewUser.city.focus(true);
     return false;
  }
  if (document.NewUser.phone.value==""){
     window.alert("Phone is missing");
     document.NewUser.phone.focus(true);
     return false;
  }
  if (document.NewUser.email.value==""){
     window.alert("E-mail is missing");
     document.NewUser.email.focus(true);
     return false;
  }
  if (document.NewUser.password.value==""){
     window.alert("Password is missing");
     document.NewUser.password.focus(true);
     return false;
  }
  if (document.NewUser.confpass.value==""){
     window.alert("Password confirmation is missing");
     document.NewUser.confpass.focus(true);
     return false;
  }
  if (document.NewUser.password.value!=document.NewUser.confpass.value){
     window.alert("Password confirmation is not tha same with password");
     document.NewUser.confpass.focus(true);
     return false;
  }
  
  document.NewUser.submit();
}

 function OnKeyPressFunc(e) {
     if (e.keyCode==13){
        CheckNewUserData();
     }
 }
