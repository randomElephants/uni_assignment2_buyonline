/**
Author: Claire O'Donoghue 2074575
Target: listing.html
Purpose: validation of the registration form
Created: 12/10/2016
Last Updated: -
Credits: -
*/

"use strict";

var http = false;
if (window.XMLHttpRequest) {
    http = new XMLHttpRequest();
} else if (window.ActiveXObject){ 
    http = new ActiveXObject("Microsoft.XMLHTTP");
}

function getServerResponse ()
{
	if ((http.readyState == 4) &&(http.status == 200))
	{
        var serverResponse = http.responseText;
        document.getElementById("processResult").innerHTML = serverResponse;
        var form = document.getElementById("addListingForm");
        form.reset();
	}
}

function sendNewItemToServer(name, price, quantity, desc){
	http.open("POST", "AddItem.php", true);
    var params = "name="+name+"&price="+price+"&quantity="+quantity+"&desc="+desc;
	http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    http.setRequestHeader("Content-length", params.length);
	http.onreadystatechange = getServerResponse;
	http.send(params);
}

//Possibly should also check for duplicate names?
function isListingFormValid(name, price, quantity, errors) {
    if (name == "") {
        errors.push("An item name is required.");
    }
    
    if (price == "") {
        errors.push("An item price is required.");
    } else if (isNaN(price)){
        errors.push("The item price must be a number.");
    } else if (price <= 0){
        errors.push("The item price must be greater than 0.");
    }
    
    if (quantity == "") {
    errors.push("An item quantity is required.");
    } else if (isNaN(quantity)){
        errors.push("The item quantity must be a number.");
    } else if (quantity <= 0){
        errors.push("The item quantity must be greater than 0.");
    }
	
    if (errors.length<= 0){
    return true;
    } else {
        return false;
    }
}

//Refill form if invalid?
function processListingForm() {
	
	var itemName = document.getElementById("name").value;
	var itemPrice = document.getElementById("price").value;
	var itemQuantAvailable = document.getElementById("quantity").value;
	var itemDesc = document.getElementById("description").value;
	
	var errors = new Array();
	var message = "";
	
	if (isListingFormValid(itemName, itemPrice, itemQuantAvailable, errors)) {
		sendNewItemToServer(itemName, itemPrice, itemQuantAvailable, itemDesc);
	}
	
	if (errors.length > 0) {
		for (var i=0; i< errors.length; i++) {
			message = message + errors[i] + " ";
		}
		alert(message);	
	}
}

function init() {
	var submitButton = document.getElementById("submit");
	submitButton.onclick = processListingForm;
}

window.onload = init;