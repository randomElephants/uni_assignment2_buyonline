<?php
//TODO: remove this if not used (Shouldn't need with xpath)
	function loadGoodsArray() {
		$goodsDoc = new DOMDocument();
		if ($goodsDoc->load("../../data/goods.xml")) {
			//Work of processing the goods document
			$goods = $goodsDoc->getElementsByTagName("good");
			$goodsArray = array();
			
			foreach($goods as $good) {
				$num = $good->getElementsByTagName( "itemNum" );
				$num = $num->item(0)->nodeValue;
				
				$name = $good->getElementsByTagName( "name" );
				$name = $name->item(0)->nodeValue;
				
				$price = $good->getElementsByTagName( "unitPrice" );
				$price = $price->item(0)->nodeValue;
				
				$desc = $good->getElementsByTagName( "description" );
				if ($desc->length != 0) {
					$desc = $desc->item(0)->nodeValue;
				} else {
					$desc = "";
				}
				
				$available = $good->getAttribute("available");
				$hold = $good->getAttribute("hold");
				$sold = $good->getAttribute("sold");
				
				$temp = array();
				$temp["num"] = $num;
				$temp["name"] = $name;
				$temp["price"] = $price;
				$temp["desc"] = $desc;
				$temp["available"] = $available;
				$temp["hold"] = $hold;
				$temp["sold"] = $sold;
				$goodsArray[] = $temp;
			}
			
			$noOfXMLGood = $goods->length;
			$noOofArrayGood = count($goodsArray);
			
			if ($noOfXMLGood == $noOofArrayGood){
				return $goodsArray;
			} else {
				return false;
			}
		}
	}

?>