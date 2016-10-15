<?php
session_start();
if ((isset($_POST["username"])) && (isset($_POST["password"]))) {
	
	$username = $_POST["username"];
	$enteredPW = $_POST["password"];
	
	//TODO: remove layer of folder
	$filename = "../../../data/manager.txt";
	$lines = file($filename, FILE_IGNORE_NEW_LINES);
	$managers = array();
	
	foreach ($lines as $line) {
		$commaPos = strpos($line, ",");
		$id = substr($line, 0, $commaPos);
		$password = substr($line, $commaPos+2);
		$managers[$id] = $password;
	}
	
	if (isset($managers[$username])) {
		$correctPassword = $managers[$username];
		
		if ($correctPassword == $enteredPW) {
			$_SESSION["manager"] = $username;
			echo "0";
		} else {
			echo "1";
		}
		
	} else {
		echo "2";
	}
	
} else {
	echo "3";
}