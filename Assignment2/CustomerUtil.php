<?php
//Remove this if not used (shouldn't be needed with xpath)
function loadCustomerArray() {
	$customerDoc = new DOMDocument();
	if ($customerDoc->load("../../data/customer.xml")) {
	
		//Work of processing the customer list
		$customers = $customerDoc->getElementsByTagName("customer");
		$customerArray = array();
	
		foreach($customers as $cust) {
			$id = $cust->getElementsByTagName( "customerId" );
			$id = $id->item(0)->nodeValue;
	
			$fName = $cust->getElementsByTagName( "firstName" );
			$fName = $fName->item(0)->nodeValue;
	
			$lName = $cust->getElementsByTagName( "lastName" );
			$lName = $lName->item(0)->nodeValue;
	
			$password = $cust->getElementsByTagName( "password" );
			$password = $password->item(0)->nodeValue;
	
			$email = $cust->getElementsByTagName( "email" );
			$email = $email->item(0)->nodeValue;
	
			$phone = $cust->getElementsByTagName( "phone" );
			$phone = $phone->item(0)->nodeValue;
	
			$customer = array();
			$customer["id"] = $id;
			$customer['fName'] = $fName;
			$customer['lName'] = $lName;
			$customer['password'] = $password;
			$customer['email']= $email;
			$customer['phone'] = $phone;
			$customerArray[] = $customer;	
		}
		
		$noOfXMLCust = $customers->length;
		$noOofArrayCust = count($customerArray);
		
		if ($noOfXMLCust == $noOofArrayCust){
			return $customerArray;
		} else {
			return false;
		}
	}
}