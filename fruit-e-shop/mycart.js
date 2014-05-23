 // JavaScript Document

function UploadCartScript() {
    document.UploadCart.action="https://www.sandbox.paypal.com/cgi-bin/webscr";
    document.UploadCart.method="post"; 
    document.UploadCart.submit();
    return true;
}

function DeleteScript() {
	document.UploadCart.action='mycart.php';
        document.UploadCart.method="post"; 
	document.UploadCart.submit();
}