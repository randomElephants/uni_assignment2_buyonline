/**
Author: Claire O'Donoghue 2074575
Target: mlogin.html
Purpose: validation & enacting of the manager login
Created: 15/10/2016
Last Updated: -
Credits: -
*/

"use strict";

var http = false;
if (window.XMLHttpRequest) {
	http = new XMLHttpRequest();
} else if (window.ActiveXObject) { 
	http = new ActiveXObject("Microsoft.XMLHTTP");
}

function addManagerNavigation() {
	var nav = document.getElementById("nav");
	
	var listingLink = document.createElement("a");
	listingLink.href="listing.html";
	listingLink.title="Add a product listing";
	listingLink.innerHTML = "Listing";
	
	var processingLink = document.createElement("a");
	processingLink.href="processing.html";
	processingLink.title="Process sold items";
	processingLink.innerHTML = "Processing";
	
	var logoutLink = document.createElement("a");
	logoutLink.href="logout.html";
	logoutLink.title="Logout";
	logoutLink.innerHTML = "Logout";
	
	nav.appendChild(listingLink);
	nav.appendChild (document.createTextNode (" "));
	nav.appendChild(processingLink);
	nav.appendChild (document.createTextNode (" "));
	nav.appendChild(logoutLink);
}

function getResponse() {
	if ((http.readyState == 4) && (http.status == 200)) {
		var serverResponse = http.responseText;
		
		switch (serverResponse) {
		case "0":
			//Success case
			document.getElementById("response").innerHTML = "Welcome to BuyOnline Management Site";
		    document.getElementById("managerLoginForm").style.display = 'none';
		    addManagerNavigation();
		    break;
		case "1":

		case "2":
		case "3":
			//Treat all error cases the same for the user (for security), but return code for developer
			document.getElementById("response").innerHTML = "You have entered the incorrect ID or password. Please try again";
			document.getElementById("password").value = "";
			break;
		default:
			//Shouldn't happen
			document.getElementById("response").innerHTML = "You have entered the incorrect ID or password. Please try again";
		
		}		
	}
}

function processLogin() {
	//TODO: add a regex for basic checks on id? e.g. no commas!
	var username = document.getElementById("managerId").value;
	var password = document.getElementById("password").value;
	
	if ((username == "") || (password == "")) {
		alert("Username and password are both required!");
	} else {
		//Change to POST
		var params = "password="+password+"&username="+username;
		http.open("POST", "ManagerLogin.php?", true);
	    http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	    http.setRequestHeader("Content-length", params.length);
	    http.onreadystatechange = getResponse;
	    http.send(params); 
	}
}

function init() {
	var submit = document.getElementById("submit");
	submit.onclick = processLogin;	
}

window.onload = init;
