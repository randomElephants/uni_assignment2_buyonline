<?php

require_once 'ShoppingCart.php';
session_start();

if (isset($_SESSION['cart'])) {
	
	if (isset($_GET["action"])) {
		$cart = $_SESSION["cart"];
		$action = $_GET["action"];
		$goodsDoc = new DOMDocument();
		
		if ($goodsDoc->load("../../../data/goods.xml")) {
			//Successfully loaded all params & the goods doc, proceed with the action
			
// 			$xpath = new DOMXPath($goodsDoc);
			
// 			$query = '//goodsList/good/itemNum[text()=000001]';
// 			$entries = $xpath->query($query);
			
// 			foreach($entries as $entry) {
// 				echo $entry->nodeValue;
// 			}
			
			if ($action == "confirm") {
				echo confirmPurchase($cart, $goodsDoc);
			} else if ($action == "cancel") {
				echo cancelPurchase($cart, $goodsDoc);
			} else {
				echo "Error: unknown action.";
			}
			
		} else {
			echo "Error: could not retrieve goods list";
		}
	} else {
		echo "Error: no action";
	}
} else {
	echo "Error: no cart";
}

function confirmPurchase($cart, $goodsDoc) {
	$xpath = new DOMXPath($goodsDoc);
	$productList = $cart->getContentsList();
	
	foreach ($productList as $product) {
		$query = '//goodsList/good/itemNum[text()=' . $product["number"] . ']';
		//Returns list, but really there should only be one
		$entries = $xpath->query($query);
		
		$totalCost = $cart->getPriceSum();
		
		foreach($entries as $entry) {
			$quantityInCart = $product["quantity"];
			$nodeToUpdate = $entry->parentNode;
			
			$currentHold = $nodeToUpdate->getAttribute("hold");
			$currentSold = $nodeToUpdate->getAttribute("sold");
			
			$newHold = $currentHold - $quantityInCart;
			$newSold = $currentSold + $quantityInCart;
			
			$nodeToUpdate->setAttribute("hold", $newHold);
			$nodeToUpdate->setAttribute("sold", $newSold);
		}
	}		
	//TODO: remove folder layer
	unset($_SESSION["cart"]);
	$goodsDoc->save("../../../data/goods.xml");
	echo "Your purchase has been confirmed, total to pay is $".$totalCost;
}

function cancelPurchase($cart, $goodsDoc) {
	$xpath = new DOMXPath($goodsDoc);
	$productsList = $cart->getContentsList();
	
	foreach($productsList as $product) {
		$query = '//goodsList/good/itemNum[text()=' . $product["number"] . ']';
		$entries = $xpath->query($query);
		
		//This should really only find 1 thing - otherwise there is a duplicate item number!!
		foreach ($entries as $entry) {
			$quantityInCart = $product["quantity"];
			$nodeToUpdate = $entry->parentNode;
						
			$currentAv = $nodeToUpdate->getAttribute("available");
			$currentHold = $nodeToUpdate->getAttribute("hold");
			
			$available = $currentAv + $quantityInCart;
			$hold = $currentHold - $quantityInCart;
			
			$nodeToUpdate->setAttribute("available", $available);
			$nodeToUpdate->setAttribute("hold", $hold);		
		}	
	}
	//TODO: remove folder layer
 	unset($_SESSION["cart"]);
 	$goodsDoc->save("../../../data/goods.xml");
	echo "Your purchase has been cancelled, please shop again.";
}