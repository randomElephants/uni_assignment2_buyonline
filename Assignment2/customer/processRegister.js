/**
Author: Claire O'Donoghue 2074575
Target: register.html
Purpose: validation of the registration form
Created: 01/10/2016
Last Updated: -
Credits: -
*/

"use strict";

var xHRObject = false;
if (window.XMLHttpRequest)
{
xHRObject = new XMLHttpRequest();
}
else if (window.ActiveXObject)
{
xHRObject = new ActiveXObject("Microsoft.XMLHTTP");
}

function getResponse() {
    if ((xHRObject.readyState == 4) &&(xHRObject.status == 200)) {
        var serverResponse = xHRObject.responseText;
        var response;
        
        var regex = /^[0-9]{1}$/
        
        if (!(regex.test(serverResponse))) {
        	response = "Welcome to BuyOnline, " + serverResponse + ". You are now registered and logged in.";
        	document.getElementById("customerRegistrationForm").style.display = "none";
        	var nav = document.getElementById("nav");
        	var logoutLink = document.createElement("a");
        	logoutLink.href="Logout.php";
        	logoutLink.title="Logout";
        	logoutLink.innerHTML = "Logout";
        	nav.appendChild(logoutLink);
        } else {
        	//One of the error codes
        	if (serverResponse == "3") {
        		response = "Sorry, that email address is already registered. Try logging in!";
        	} else {
        		response = "Sorry, something went wrong with your registration. Please try again later! (Code: " + serverResponse + ")";
        	}
        }
        
        document.getElementById("result").innerHTML = response;
    }
}

//At this point, the email has not been checked for uniqueness!!
function addCustomer(fName, lName, email, phone, password) {
	var parameters = "fName="+encodeURIComponent(fName)+"&lName="+encodeURIComponent(lName)+"&email="+encodeURIComponent(email)+"&phone="+encodeURIComponent(phone)+"&password="+encodeURIComponent(password); 
	xHRObject.open("POST", "AddCustomer.php", true);
	xHRObject.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xHRObject.setRequestHeader("Content-length", parameters.length);
    xHRObject.onreadystatechange = getResponse;
    xHRObject.send(parameters);   
}

//Email regex sourced from http://regexlib.com/Search.aspx?k=email
function isRegistrationValid(errors, fName, lName, email, phone, password, confirmPassword) {
		
	var phoneRegex = /^\(?[0-9]{2}\)?[ ]?[0-9]{4} ?[0-9]{4}$/;
	var emailRegex = /^([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/
		
	if (fName == "") {
		errors.push("First name is required.");
	}
	
	if (lName == "") {
		errors.push("Last name is required.");
	}
	
	if (email == "") {
		errors.push("Email is required.");
	} else if (!(emailRegex.test(email))) {
		errors.push("Your email must be a valid email format.");
	}
	
	if ((password == "") || (confirmPassword == "")) {
		errors.push("Both password fields are required.");
	} else if (!(password === confirmPassword)) {
		errors.push("The two passwords do not match.");
	}
	
	if (phone != "") {
		if (!(phoneRegex.test(phone))) {
			errors.push("Your phone number is not a valid format.");
		}
	}
	
	if (errors.length > 0) {
		return false;
	} else {
		return true;
	}	
}

//TODO: fill out form again if not valid!!
function customerRegistration() {
	
	var errors = new Array();
	
	var fName = document.getElementById("fName").value;
	var lName = document.getElementById("lName").value;
	var email = document.getElementById("email").value;
	var phone = document.getElementById("phone").value;
	var password = document.getElementById("password").value;
	var confirmPassword = document.getElementById("confirmPassword").value;
		
	if (isRegistrationValid(errors, fName, lName, email, phone, password, confirmPassword)) {
		addCustomer(fName, lName, email, phone, password);
		document.getElementById("customerRegistrationForm").reset();
	} else {
		var errmessage = "";
		for (var i=0; i<errors.length; i++) {
			errmessage += errors[i] + " ";
		}
		
		document.getElementById("password").value = "";
		document.getElementById("confirmPassword").value= "";
		
		alert(errmessage);
	}	
}

//Function called when page loads to set up buttons etc.
function init() {
		
	var submit = document.getElementById("registerSubmit");
	submit.onclick = customerRegistration;
	
}

window.onload = init;