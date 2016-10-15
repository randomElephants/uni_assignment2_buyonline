<?php
    require_once "ShoppingCart.php";
    session_start();
    
    function addItemToCart($num, $price) {
        $cart;
        
        if (isset($_SESSION["cart"])) {
            $cart = $_SESSION["cart"];
        } else {
            $cart = new ShoppingCart();
        }        
        
        $cart->addItemToCart($num, $price);
        $_SESSION["cart"] = $cart;
    }

    if(isset($_POST["itemNum"])) {
        $itemNum = $_POST["itemNum"];
        $goodsDoc = new DOMDocument();

        //TODO: remove one level of folder when testing finished
        if ($goodsDoc->load("../../../data/goods.xml")) {
            $list = $goodsDoc->getElementsByTagName("goodsList")->item(0);
            
            //Replace this with XPATH???(using php domxpath query??)
            $itemNumsNodes = $goodsDoc->getElementsByTagName("itemNum");
            $itemNodeToBuy = false;
            
            foreach ($itemNumsNodes as $numNode) {
                if ($numNode->nodeValue == $itemNum) {
                    $itemNodeToBuy = $numNode->parentNode;
                }
            }
            
            if ($itemNodeToBuy != null) {
                
                $quantityAvailable = $itemNodeToBuy->getAttribute("available");
                
                if ($quantityAvailable < 1) {
                    echo 1;
                } else {
                    $currentHold = $itemNodeToBuy->getAttribute("hold");
                    
                    $newAv = $quantityAvailable - 1;
                    $newHold = $currentHold + 1;
                	
                 	$itemNodeToBuy->setAttribute("available", $newAv);
                    $itemNodeToBuy->setAttribute("hold", $newHold);                                   
                    
                    //IF all is good...
                    $goodsDoc->save("../../../data/goods.xml");
                    
                    $itemPrice = $itemNodeToBuy->getElementsByTagName("unitPrice");
                    $itemPrice = $itemPrice->item(0);
                    $itemPrice = $itemPrice->nodeValue;
                    
                    addItemToCart($itemNum, $itemPrice);
                    echo 0;
                }
                
            } else {
                echo 2;
            }
          
        } else {
            echo 3;
        }
    } else {
        echo 4;
    }
?>