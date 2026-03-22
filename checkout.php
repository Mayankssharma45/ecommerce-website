<?php
session_start();
if(empty($_SESSION['cart'])){
    header("Location: cart.php");
    exit;
}

// Calculate total
$grandTotal = 0;
foreach($_SESSION['cart'] as $item){
    $grandTotal += $item['price'] * $item['quantity'];
}

// Generate a fake order ID
$order_id = rand(1000, 9999);
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Checkout - E-Shop</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container py-5 text-center">
    <h2>Total Amount: ₹<?php echo number_format($grandTotal); ?></h2>
    <p>Simulated Payment Gateway – Click below to complete payment</p>

    <!-- Pay Now Button redirects to your existing order success page -->
    <a href="order-success.php?order_id=<?php echo $order_id; ?>" class="btn btn-success btn-lg mt-3">Pay Now</a>
</div>

</body>
</html>
