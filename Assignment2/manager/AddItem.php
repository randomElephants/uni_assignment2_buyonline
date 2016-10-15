<?php
//TODO: somehow make the number
    if ((isset($_POST["name"])) && (isset($_POST["price"])) && (isset($_POST["quantity"])) && (isset($_POST["desc"]))) {
        
        $itemName = $_POST["name"];
        $itemPrice = $_POST["price"];
        $itemQuantAvail = $_POST["quantity"];
        $itemDesc = $_POST["desc"];
        
        $goodsDoc = new DOMDocument();
        
        //Create the "good" (product) element
        $newItem = $goodsDoc->createElement("good");
        
        //Set the attributes
        $newItem->setAttribute("available", $itemQuantAvail);
        $newItem->setAttribute("hold", 0);
        $newItem->setAttribute("sold", 0);
        
        //Create and append the "name"
        $newItemName = $goodsDoc->createElement("name", $itemName);
        $newItem->appendChild($newItemName);
        
        //Create and append the "unit price"
        $newItemPrice = $goodsDoc->createElement("unitPrice", $itemPrice);
        $newItem->appendChild($newItemPrice);
        
        //Create and append the "description"
        if ($itemDesc != "") {
            $newItemDesc = $goodsDoc->createElement("name", $itemDesc);
            $newItem->appendChild($newItemDesc);
        }
        
        //If this fails, it creates a warning I don't know how to suppress.
        if ($goodsDoc->load("../../data/goods.xml")) {
            //Add to existing document
            $list = $goodsDoc->getElementsByTagName("goodsList")->item(0);
            $list->appendChild($goodsDoc->importNode($newItem, true));
            //TODO: remove folder level
            $goodsDoc->save("../../../data/goods.xml");
        } else {
           //Create new document - if couldn't load file, but is was there, this will override it? Seems bad!
           $list = $goodsDoc->createElement("goodsList");
           $list->appendChild($newItem);
           $goodsDoc->appendChild($list);
           //TODO: remove folder level
           $goodsDoc->save("../../../data/goods.xml");
         }      
        echo "New item saved.";
    } else {
        echo "There was a problem adding the item.";
    }
?>