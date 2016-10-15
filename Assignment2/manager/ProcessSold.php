<?php
	$goodsDoc = new DOMDocument();
	if ($goodsDoc->load("../../data/goods.xml")) {
		$list = $goodsDoc->getElementsByTagName("goodsList")->item(0);
		$goods = $goodsDoc->getElementsByTagName("good");
		
		$count = 0;
		
		foreach ($goods as $good) {
			
			if ($good->getAttribute("sold") > 0) {
				$good->setAttribute("sold", 0);
				$count = $count + 1;
			}
			
			if (($good->getAttribute("hold") == 0) && ($good->getAttribute("available") == 0)) {
				$list->removeChild($good);
			}
		}
		$goodsDoc->save("../../data/goods.xml");
		
		if ($count > 1) {
			echo "OK";
		} else {
			echo "NONE";
		}
	} else {
		echo "ERROR";
	}
?>