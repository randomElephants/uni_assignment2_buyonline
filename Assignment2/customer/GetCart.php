<?php
    require_once "ShoppingCart.php";
    
    session_start();

    $cart;
    
    if (isset($_SESSION["cart"])) {
        $cart = $_SESSION["cart"];
    } else {
        $cart = new ShoppingCart();
    }
    
    echo $cart->generateTable();
?>