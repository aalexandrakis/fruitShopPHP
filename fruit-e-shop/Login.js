// JavaScript Document
function ForgotPasswordScript(){
    document.login.action="forgotpassword.php";
    document.login.method="POST";
    document.login.submit();
}

function NewUserScript(){
    window.location="newuser.php";
}

function CheckLoginData(){
    if (document.login.email.value==""){
       alert("Email is missing");
       document.login.email.focus(true);
       return false;
    }
    if (document.login.password.value==""){
       alert("Password is missing");
       document.login.password.focus(true);
       return false;
    }
    document.login.action="login.php";
    document.login.method="POST";
    document.login.submit();
    return true;
}

function onBodyKeyPressed(e){
    if (e.keyCode==13){
        CheckLoginData();
    } 
}