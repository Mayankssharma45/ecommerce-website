<?php
session_start();
unset($_SESSION['cart']); // Clear the cart

// Get order ID from URL, or 0 if not set
$order_id = $_GET['order_id'] ?? 0;
?>
<!DOCTYPE html>
<html>
<head>
    <title>Order Successful</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container py-5 text-center">
    <h1 class="text-success">Order Placed Successfully!</h1>
    <p>Your Order ID: <b><?php echo $order_id; ?></b></p>
    <a href="products.php" class="btn btn-primary mt-3">Continue Shopping</a>
</div>

</body>
</html>
