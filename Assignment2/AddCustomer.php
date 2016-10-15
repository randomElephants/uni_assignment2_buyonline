<?php

//TODO: this would be easier with Xpath?? / DOMdocument
require_once 'CustomerUtil.php';

if (isset($_POST["fName"]) && isset($_POST['lName']) && isset($_POST['email']) && isset($_POST['phone']) && isset($_POST['password'])) {
	$newCustFName = $_POST["fName"]; 
	$newCustLName = $_POST["lName"];
	$newCustEmail = $_POST["email"];
	$newCustPhone = $_POST['phone'];
	$newCustPassword = $_POST['password'];
	
	$customers = loadCustomerArray();	
	
	if ($customers) {
		//Loaded the file
		
		$duplicateEmail = false;
		foreach ($customers as $cust) {
			if ($cust['email'] == $newCustEmail) {
				$duplicateEmail = true;
			}
		}
		
		if (!$duplicateEmail) {
			//TODO: Add the new customer;
			echo "Going to add!";
		} else {
			echo "Duplicate email entered."; 
		}
		
		
	} else {
		echo "Error loading customer file.";
	}
	
} else {
	echo "No post values";
}

?>