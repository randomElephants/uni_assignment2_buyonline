/**
Author: Claire O'Donoghue 2074575
Target: buying.html
Purpose: Processing of the buy/remove/etc commands
Created: 12/10/2016
Last Updated: 15/10/2016
Credits: -
*/

"use strict";

var cartHTTP = false;
var addHTTP = false;
var removeHTTP = false;
var actionHTTP = false;
if (window.XMLHttpRequest) {
	addHTTP = new XMLHttpRequest();
    cartHTTP = new XMLHttpRequest();
    removeHTTP = new XMLHttpRequest();
    actionHTTP = new XMLHttpRequest();
} else if (window.ActiveXObject) { 
	addHTTP = new ActiveXObject("Microsoft.XMLHTTP");
	cartHTTP = new ActiveXObject("Microsoft.XMLHTTP");
	removeHTTP = new ActiveXObject("Microsoft.XMLHTTP");
	actionHTTP = new ActiveXObject("Microsoft.XMLHTTP");
}


function getRemoveFromCartResponse() {
	if ((removeHTTP.readyState == 4) && (removeHTTP.status == 200)) {
		var serverResult = removeHTTP.responseText;
		//TODO: use switch for response here?
		document.getElementById("test").innerHTML = serverResult;
		updateCartInSession();
	}
}

function processRemoveFromCart() {    
    var itemNumber =  this.parentNode.parentNode.firstElementChild.textContent;
        
    removeHTTP.open("POST", "RemoveFromCart.php", true);
    var params = "itemNum="+itemNumber;
    removeHTTP.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    removeHTTP.setRequestHeader("Content-length", params.length);
    removeHTTP.onreadystatechange = getRemoveFromCartResponse;
    removeHTTP.send(params); 
}

function getCartActionResponse() {
	if ((actionHTTP.readyState == 4) && (actionHTTP.status == 200)) {
		var serverResponse = actionHTTP.responseText;
		document.getElementById("test").innerHTML = serverResponse;
		
		updateCartInSession();
	}
}

function cancelPurchase() {	
	var param = "action=cancel";
	
	actionHTTP.open("GET", "ProcessCart.php?"+param, true);
	actionHTTP.onreadystatechange = getCartActionResponse;
	actionHTTP.send(null);
}

function confirmPurchase() {	
	var param = "action=confirm";
	
	actionHTTP.open("GET", "ProcessCart.php?"+param, true);
	actionHTTP.onreadystatechange = getCartActionResponse;
	actionHTTP.send(null);
}

function getShoppingCartResponse() {
    if ((cartHTTP.readyState == 4) && (cartHTTP.status == 200)) {
        var serverResult = cartHTTP.responseText;
        document.getElementById("shoppingCart").innerHTML = serverResult;
        
        if (serverResult != "") {
            var footerButtons = "<tr><td colspan=2><input type='button' id='confirm' value='Confirm'/></td><td colspan=2><input type='button' id='cancel' value='Cancel'/></td></tr>";
            document.getElementById("cartFooter").innerHTML = footerButtons;
            
            var cartRemoveButtons = document.getElementsByClassName("removeItemButton");
            
            //Already know response has items in it
            for (var i =0; i < cartRemoveButtons.length; i++) {
                cartRemoveButtons[i].onclick = processRemoveFromCart;
            }
            
            var cancelButton = document.getElementById("cancel");
            cancelButton.onclick = cancelPurchase;
            
            var confirmButton = document.getElementById("confirm");
            confirmButton.onclick = confirmPurchase;
        }
        
        getAvailableProducts();
    }
}

function updateCartInSession() {    
    var date = new Date().toString();
    
    cartHTTP.open("GET", "GetCart.php?date="+date, true);
    cartHTTP.onreadystatechange = getShoppingCartResponse;
	cartHTTP.send(null);   
}

function getAddToCartResponse() {
	if ((addHTTP.readyState == 4) && (addHTTP.status == 200)) {
		var serverResult = addHTTP.responseText;
        
		//TODO: response should not be in test variable??
        switch (serverResult) {
            case "0":
                //Success case, item ready to add to cart
                updateCartInSession();
                document.getElementById("test").innerHTML = "Item added to your cart";
                break;
            case "1":
                //Error case, item no longer available
                document.getElementById("test").innerHTML = "Sorry, this item is no longer available for sale";
                getAvailableProducts();
                break;
            case "2":
            case "3":
            case "4":
                //Various error cases, same message
                document.getElementById("test").innerHTML = "Sorry, there was an error processing your request (Error " + serverResult + ")";
                break;
            default:
                //shouldn't happen??
                document.getElementById("test").innerHTML = "Sorry, there was an error processing your request (Error " + serverResult + ")";
        }
	}
}

function processAddToCart() {
    
    var itemNumber =  this.parentNode.parentNode.firstElementChild.textContent;   
    
    addHTTP.open("POST", "AddToCart.php", true);
    var params = "itemNum="+itemNumber;
	addHTTP.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    addHTTP.setRequestHeader("Content-length", params.length);
	addHTTP.onreadystatechange = getAddToCartResponse;
	addHTTP.send(params);    
}

function init() {
    getAvailableProducts();
    updateCartInSession();
}

window.onload = init;