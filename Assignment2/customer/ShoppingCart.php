<?php
class ShoppingCart {
    
    private $contents;
    
    public function __construct(){
        $this->contents = array();
    }
    
    public function addItemToCart($itemNum, $itemPrice) {        
        if (isset($this->contents[$itemNum])) {
            $item = $this->contents[$itemNum];
            $item["quantity"] = $item["quantity"] + 1;
            $this->contents[$itemNum] = $item;
        } else {
            $newItem = array();
            $newItem["number"] = $itemNum;
            $newItem["price"] = $itemPrice;
            $newItem["quantity"] = 1;

            $this->contents[$itemNum] = $newItem;
        }        
    }
    
    //Specification says to remove all, not just one
    public function removeItemFromCart($itemNum) {
        unset($this->contents[$itemNum]);    		
    }
    
    public function getQuantity($itemNumber) {
    	$item = $this->contents[$itemNumber];
    	return $item["quantity"];
    }
    
    public function emptyCart() {
    	$this->contents = array();
    }
    
   public function getContentsList() {
   		$list = array();
   		foreach ($this->contents as $item) {
   			$temp = array();
   			$temp['number'] = $item["number"];
   			$temp["quantity"] = $item["quantity"];
   			$list[] = $temp;
   		}
   		
   		return $list;
   }
    
    private function isCartEmpty() {
        if ((count($this->contents)) <= 0) {
            return true;
        } else {
            return false;
        }
    }
    
    public function getPriceSum() {
        $sum = 0;
        
        foreach ($this->contents as $item) {
            $sum = ($sum + $item["price"]*$item["quantity"]);
        }
        
        return $sum;
    }
    
    //Generates a HTML table as a string - a bit hacky, but will work!
    public function generateTable() {       
        if ($this->isCartEmpty()) {          
            return "";
        } else {
            $tableString = "<table border='1'><thead><tr><th>ItemNumber</th><th>Price</th><th>Quantity</th><th>Remove</th></thead><tbody>";
            
            foreach ($this->contents as $item) {                
                $tableString = $tableString . "<tr><td>" . $item["number"] . "</td><td>$". $item["price"] . "</td><td>". $item["quantity"] ."</td><td><input class='removeItemButton' type='button' value='Remove'/></td></tr>";
            }
            $tableString = $tableString . "<tr><td colspan=3>Total:</td><td>$" . $this->getPriceSum() . "</td></tr>";
            $tableString = $tableString . "</tbody><tfoot id='cartFooter'></tfoot></table>";
            return $tableString;
        }
    }
}
?>