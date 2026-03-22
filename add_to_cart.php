<?php
session_start();
require 'config.php';

// Check if product id is provided
if(!isset($_POST['product_id'])){
    header("Location: products.php");
    exit;
}

$id = intval($_POST['product_id']);

// Fetch product from database
$result = $conn->query("SELECT * FROM products WHERE id = $id");
if($result->num_rows > 0){
    $p = $result->fetch_assoc();

    // Initialize cart if not exists
    if(!isset($_SESSION['cart'])){
        $_SESSION['cart'] = [];
    }

    // If product already in cart, increase quantity
    if(isset($_SESSION['cart'][$id])){
        $_SESSION['cart'][$id]['quantity'] += 1;
    } else {
        $_SESSION['cart'][$id] = [
            'name' => $p['name'],
            'price' => $p['price'],
            'quantity' => 1
        ];
    }
}

header("Location: cart.php");
exit;
?>
