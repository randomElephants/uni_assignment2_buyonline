<?php

session_start();

if (isset($_POST["fName"]) && isset($_POST['lName']) && isset($_POST['email']) && isset($_POST['phone']) && isset($_POST['password'])) {
	$newCustFName = $_POST["fName"]; 
	$newCustLName = $_POST["lName"];
	$newCustEmail = $_POST["email"];
	$newCustPhone = $_POST['phone'];
	$newCustPassword = $_POST['password'];
	
	$int = rand(0, 100000);
	$newCustNum = $int . substr($newCustEmail, 0, 5);
		
	$custDoc = new DOMDocument();
	
	if ($custDoc->load("../../../data/customer.xml")) {
		
		$isDuplicateEmail = isDuplicateEmail($newCustEmail, $custDoc);
		if ($isDuplicateEmail) {
			echo "3";
		} else {
			//Going to save new customer
			$newCustomerNode = createNewCustomer($custDoc, $newCustNum, $newCustFName, $newCustLName, $newCustEmail, $newCustPhone, $newCustPassword);
			$list = $custDoc->getElementsByTagName("customerList");
			
			if ($list->length != 1) {
				//Something weird going on
				echo "4";
			} else {
				$list = $list->item(0);
				$list->appendChild($newCustomerNode);
				$custDoc->appendChild($list);
				//TODO: remove folder level
				$custDoc->save("../../../data/customer.xml");
				$_SESSION["customer"] = $newCustEmail;
				echo $newCustEmail;
			}		
		}		
	} else {
		//Document not loadable - presume doesn't exist.			
		$newCustomerNode = createNewCustomer($custDoc, $newCustNum, $newCustFName, $newCustLName, $newCustEmail, $newCustPhone, $newCustPassword);
		$list = $custDoc->createElement("customerList");
		$list->appendChild($newCustomerNode);
		$custDoc->appendChild($list);
		//TODO: remove folder level
		$custDoc->save("../../../data/customer.xml");
		$_SESSION["customer"] = $newCustEmail;
		echo $newCustEmail;
	}
	
	
	
} else {
	echo "2";
}

function isDuplicateEmail($newEmail, $custDoc) {
	$xpath = new DOMXPath($custDoc);
	//$query = '//customerList/customer/email[text()=' . $newEmail . ']';
	$query = "//customerList/customer/email[text()='" . $newEmail . "']";
	$entries = $xpath->query($query);
	
	if ($entries->length > 0) {
		return true;
	} else {
		return false;
	}
}

function createNewCustomer($custDoc, $id, $fName, $lName, $email, $phone, $password) {
	//Create the new customer node
	$newCustomer = $custDoc->createElement("customer");
	
	//Create and append the ID node
	$idNode = $custDoc->createElement("customerId", $id);
	$newCustomer->appendChild($idNode);
	
	//Create and append the first name node
	$fNameNode = $custDoc->createElement("firstName", $fName);
	$newCustomer->appendChild($fNameNode);
	
	//Create and append the last name node
	$lNameNode = $custDoc->createElement("lastName", $lName);
	$newCustomer->appendChild($lNameNode);
	
	//create and append the password node
	$passwordNode = $custDoc->createElement("password", $password);
	$newCustomer->appendChild($passwordNode);
	
	//Create and append the email node
	$emailNode= $custDoc->createElement("email", $email);
	$newCustomer->appendChild($emailNode);
	
	//Create and append the phone number node
	$phoneNode = $custDoc->createElement("phone", $phone);
	$newCustomer->appendChild($phoneNode);
	
	return $newCustomer;
}

?>