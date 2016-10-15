/**
Author: Claire O'Donoghue 2074575
Target: register.html
Purpose: validation of the registration form
Created: 01/10/2016
Last Updated: 12/10/2016
Credits: -
*/

"use strict";

var http = false;
if (window.XMLHttpRequest) {
	http = new XMLHttpRequest();
} else if (window.ActiveXObject) { 
	http = new ActiveXObject("Microsoft.XMLHTTP");
}

function getGoodsData() {
	if ((http.readyState == 4) && (http.status == 200)) {
		var serverResult = http.responseText;
		document.getElementById("resultBody").innerHTML = serverResult;
	}
}

function loadProcessingTable() {
	http.open("GET", "LoadProcessingTable.php", true);
	http.onreadystatechange = getGoodsData;
	http.send(null);
}

function getProcessConfirmation() {
	
	if ((http.readyState == 4) && (http.status==200)) {
		var serverResult = http.responseText;
		
		if (serverResult == "OK") {
			loadProcessingTable();
			document.getElementById("processResult").innerHTML = "Sold items processed successfully.";
		} else if (serverResult == "NONE") {
			loadProcessingTable();
			document.getElementById("processResult").innerHTML = "There were no sold items to process.";
		} else {
			document.getElementById("processResult").innerHTML = "There was an error processing the goods sold.";
		}
	}
}

function processGoodSold() {
	http.open("GET", "ProcessSold.php", true);
	http.onreadystatechange = getProcessConfirmation;
	http.send(null);
	
}

function init() {
	
	loadProcessingTable();
	
	var submit = document.getElementById("processButton");
	submit.onclick = processGoodSold;
	
	var update = document.getElementById("updateButton");
	update.onclick = loadProcessingTable;
}

window.onload = init;