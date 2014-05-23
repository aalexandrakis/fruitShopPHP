 // JavaScript Document
function AddToCart() {
    if (document.BuyNow.quantity.value == 0 ||
        document.BuyNow.quantity.value == "") {
        alert("No quantity selected");
        return false;
    } 
    document.BuyNow.action="mycart.php";
    document.BuyNow.method="POST";
    document.BuyNow.submit();
    return true;
}

function BuyNowScript() {
    document.BuyNow.action="https://www.sandbox.paypal.com/cgi-bin/webscr";
    document.BuyNow.method="post"; 
    document.BuyNow.quantity.value=Math.round(document.BuyNow.quantity.value);
    document.BuyNow.submit();
    return true;
}