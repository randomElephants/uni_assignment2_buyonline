<?php
session_start();
if (isset($_SESSION["manager"])) {
	$manager = $_SESSION["manager"];
	
	if (($manager != null) && ($manager != "")) {
		echo $manager;
	} else {
		echo 0;
	}
} else {
	echo 0;
}