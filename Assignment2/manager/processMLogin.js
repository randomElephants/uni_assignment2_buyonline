/**
Author: Claire O'Donoghue 2074575
Target: mlogin.html
Purpose: validation & enacting of the manager login
Created: 15/10/2016
Last Updated: -
Credits: -
*/

"use strict";

function processLogin() {
	alert("login!");
}

function init() {
	var submit = document.getElementById("submit");
	submit.onclick = processLogin();
}

window.onload = init;
