<?php
session_start();
$person;

if (isset($_SESSION["customer"])) {
	$person = $_SESSION["customer"];
	unset($_SESSION["customer"]);

} else if (isset($_SESSION["manager"])) {
	//Logout the manager;
	$person = $_SESSION["manager"];
	unset($_SESSION["manager"]);	
} else {
	$person = "";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
<meta name="description" content="BuyOnline logout page" />
<meta name="author" content="Claire O'Donoghue"  />
<title>Logged Out - BuyOnline</title>
</head>
<body>
<nav>
    <a title="BuyOnline Home Page" href="buyonline.html">Home</a>
</nav>
<h1>Logged Out - BuyOnline</h1>

<p>Thanks for using Buy Online, <?php echo $person?></p>
</body>
</html>