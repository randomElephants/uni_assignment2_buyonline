/**
Author: Claire O'Donoghue 2074575
Target: buying.html
Purpose: updating the items available table - polling every 10 seconds
Created: 12/10/2016
Last Updated: -
Credits: -
*/

"use strict";

var productsHTTP = false;
if (window.XMLHttpRequest) {
	productsHTTP = new XMLHttpRequest();
} else if (window.ActiveXObject) { 
	productsHTTP = new ActiveXObject("Microsoft.XMLHTTP");
}

function getData(){
    if ((productsHTTP.readyState == 4) && (productsHTTP.status == 200)) {
        var response = productsHTTP.responseText;
        document.getElementById("resultBody").innerHTML = response;
        var buttons = document.getElementsByClassName("addTocartButton");
        
        for (var i =0; i < buttons.length; i++) {
            buttons[i].onclick = processAddToCart;
        }
        
        setTimeout("getAvailableProducts()", 10000);
    }
}

//Try to put the anti-caching thing back in?
function getAvailableProducts(){
    productsHTTP.open("GET", "GetAvailableProducts.php", true);
    productsHTTP.onreadystatechange = getData;
    productsHTTP.send(null);
}