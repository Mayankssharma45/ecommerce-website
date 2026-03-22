<?php
session_start();
require 'config.php';

// USER LOGIN CHECK
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// CART CHECK
if (empty($_SESSION['cart'])) {
    echo "Cart is empty!";
    exit;
}

// CALCULATE TOTAL
$total = 0;
foreach ($_SESSION['cart'] as $item) {
    $qty = isset($item['quantity']) ? $item['quantity'] : 1; 
    $total += $item['price'] * $qty;
}

// INSERT INTO ORDERS TABLE
$stmt = $conn->prepare("INSERT INTO orders (user_id, total) VALUES (?, ?)");
if(!$stmt){
    die("Order Prepare Failed: " . $conn->error);
}
$stmt->bind_param("id", $user_id, $total);
$stmt->execute();

$order_id = $stmt->insert_id;

// INSERT INTO ORDER_ITEMS
$stmt2 = $conn->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
if(!$stmt2){
    die("Order Item Prepare Failed: " . $conn->error);
}

foreach ($_SESSION['cart'] as $product_id => $item) {

    $qty = isset($item['quantity']) ? $item['quantity'] : 1;
    $price = $item['price'];

    $stmt2->bind_param("iiid", $order_id, $product_id, $qty, $price);
    $stmt2->execute();
}

// CLEAR CART
unset($_SESSION['cart']);

// REDIRECT
header("Location: order-success.php?order_id=" . $order_id);
exit;
?>
