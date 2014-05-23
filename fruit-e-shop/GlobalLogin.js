// JavaScript Document
function GlobalForgotPasswordScript(){
    document.login.action="forgotpassword.php";
    document.login.method="POST";
    document.login.submit();
}

function GlobalCheckLoginData(){
    if (document.login.loginemail.value==""){
       alert("Email is missing");
       document.login.loginemail.focus(true);
       return false;
    }
    if (document.login.loginpassword.value==""){
       alert("Password is missing");
       document.login.loginpassword.focus(true);
       return false;
    }
    document.login.method="POST";
    document.login.submit();
    return true;
}


function LogOutScript(){
    document.logout.method="POST";
    document.logout.submit();
 
}