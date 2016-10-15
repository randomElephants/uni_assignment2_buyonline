<?php
    require_once "ShoppingCart.php";
    session_start();

    if (isset($_POST["itemNum"]) && (isset($_SESSION["cart"]))) {
        $cart = $_SESSION["cart"];
        $numOfRemovedItem = $_POST["itemNum"];
        $goodsDoc = new DOMDocument();
        
        //TODO: remove a level of the folder
        if ($goodsDoc->load("../../../data/goods.xml")) {
	        
        	//Find out how many of item in cart
        	$numInCart = $cart->getQuantity($numOfRemovedItem);
        	
        	if ($numInCart <= 0) {
        		echo "Error - none in cart.";
        	} else {        	
	        	//TODO: replace with XPATH query?
	        	$itemNumsNodes = $goodsDoc->getElementsByTagName("itemNum");
	        	$itemNodeToRemove = false;
	        	
	        	foreach ($itemNumsNodes as $numNode) {
	        		if ($numNode->nodeValue == $numOfRemovedItem) {
	        			$itemNodeToRemove = $numNode->parentNode;
	        		}
	        	}
	        	
	        	if ($itemNodeToRemove) {
	                $quantityAvailable = $itemNodeToRemove->getAttribute("available");
	                $quantityOnHold = $itemNodeToRemove->getAttribute("hold");
	                
	                $quantityOnHold = $quantityOnHold - $numInCart;
	                $quantityAvailable = $quantityAvailable + $numInCart;
	                
	                if (($quantityAvailable <= 0)) {
	                	echo "Error: xml values wrong after removing item, not saved.";
	                } else {
	                	//All is good, save the doc && update cart
	                	$itemNodeToRemove->setAttribute("available", $quantityAvailable);
	                	$itemNodeToRemove->setAttribute("hold", $quantityOnHold);
	                	$goodsDoc->save("../../../data/goods.xml");
	                	
	                	$cart->removeItemFromCart($numOfRemovedItem);
	                	$_SESSION["cart"] = $cart;
	                	 
	                	echo "Item $numOfRemovedItem has been removed.";
	                }
	        		
	        	} else {
	        		echo "Error - what?";
	        	}
        	}
        } else {
        	echo "Bad! (2)";
        }
    } else {
    	echo "Bad! (1)";
    }
?>