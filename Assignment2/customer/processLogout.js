/**
Author: Claire O'Donoghue 2074575
Target: any page with "logout" button on it
Purpose: validation & enacting of the manager login
Created: 15/10/2016
Last Updated: -
Credits: -
*/

"use strict";

http = false;

var http = false;
if (window.XMLHttpRequest) {
	http = new XMLHttpRequest();
} else if (window.ActiveXObject) { 
	http = new ActiveXObject("Microsoft.XMLHTTP");
}