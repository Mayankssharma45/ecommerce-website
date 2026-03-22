<?php
session_start();

// Initialize cart if not exists
if(!isset($_SESSION['cart'])){
    $_SESSION['cart'] = [];
}

// Handle remove item
if(isset($_GET['remove'])){
    $id = $_GET['remove'];
    unset($_SESSION['cart'][$id]);
    header("Location: cart.php");
    exit;
}

// Handle update cart quantities
if(isset($_POST['update_cart'])){
    foreach($_POST['quantity'] as $id => $qty){
        if(isset($_SESSION['cart'][$id])){
            $_SESSION['cart'][$id]['quantity'] = max(1, intval($qty));
        }
    }
    header("Location: cart.php");
    exit;
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Your Cart - E-Shop</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<?php include 'components/navbar.php'; ?>

<div class="container py-5">
    <h2 class="mb-4">Your Shopping Cart</h2>

    <?php if(empty($_SESSION['cart'])): ?>
        <div class="alert alert-info">Your cart is empty.</div>

    <?php else: ?>
        <form method="post" action="cart.php">
        <table class="table table-bordered align-middle text-center">
            <thead class="table-dark">
                <tr>
                    <th>Product</th>
                    <th width="120">Price</th>
                    <th width="100">Qty</th>
                    <th width="100">Total</th>
                    <th width="100">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $grandTotal = 0;
                foreach($_SESSION['cart'] as $id => $item):
                    if(!is_array($item)) continue;
                    $totalPrice = $item['price'] * $item['quantity'];
                    $grandTotal += $totalPrice;
                ?>
                <tr>
                    <td><?php echo htmlspecialchars($item['name']); ?></td>
                    <td>₹<?php echo number_format($item['price']); ?></td>
                    <td>
                        <input type="number" name="quantity[<?php echo $id; ?>]" value="<?php echo $item['quantity']; ?>" min="1" class="form-control form-control-sm">
                    </td>
                    <td>₹<?php echo number_format($totalPrice); ?></td>
                    <td>
                        <a href="cart.php?remove=<?php echo $id; ?>" class="btn btn-danger btn-sm">Remove</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div class="d-flex justify-content-between align-items-center mt-4">
            <div>
                <button type="submit" name="update_cart" class="btn btn-primary">Update Cart</button>
            </div>
            <h4>Total: ₹<?php echo number_format($grandTotal); ?></h4>
        </div>
        </form>

        <div class="mt-4 text-end">
    <a href="checkout.php" class="btn btn-success btn-lg">Checkout / Pay Now</a>
</div>

    <?php endif; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
