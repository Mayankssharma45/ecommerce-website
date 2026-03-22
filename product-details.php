<?php
session_start();
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $id = $_GET['id'];  // URL se id
    $quantity = $_POST['quantity']; // Form se quantity

    $result = $conn->query("SELECT * FROM products WHERE id = $id");

    if ($result->num_rows > 0) {
        $p = $result->fetch_assoc();

        $_SESSION['cart'][$id] = [
            'name' => $p['name'],
            'price' => $p['price'],
            'quantity' => $quantity
        ];
    }

    header("Location: cart.php");
    exit;
}

// Normal page load → show product details

if (!isset($_GET['id'])) {
    header("Location: products.php");
    exit;
}

$id = (int)$_GET['id'];

$stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$res = $stmt->get_result();
$p = $res->fetch_assoc();

if (!$p) {
    echo "Product not found!";
    exit;
}


?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo htmlspecialchars($p['name']); ?> - E-Shop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/custom.css">
  </head>
  <body>
    <?php include 'components/navbar.php'; ?>
    <div class="container py-4">
      <div class="row g-3">
        <div class="col-md-6">
          <?php if(!empty($p['image'])): ?>
            <img src="<?php echo htmlspecialchars($p['image']); ?>" class="img-fluid rounded" alt="">
          <?php else: ?>
            <div class="placeholder rounded bg-light border p-5 text-center">No image</div>
          <?php endif; ?>
        </div>
        <div class="col-md-6">
          <h2><?php echo htmlspecialchars($p['name']); ?></h2>
          <p class="text-muted"><?php echo htmlspecialchars($p['category']); ?></p>
          <p><?php echo nl2br(htmlspecialchars($p['description'])); ?></p>
          <h4 class="fw-bold">₹<?php echo number_format($p['price']); ?></h4>

          <form method="post" action="product-details.php?id=<?php echo $p['id']; ?>">
            <div class="mb-3">
              <label class="form-label">Quantity</label>
              <input type="number" name="quantity" value="1" min="1" class="form-control" style="width:120px;">
            </div>
            <button class="btn btn-success" type="submit">Add to Cart</button>
          </form>
        </div>
      </div>
      <p class="mt-4"><a href="products.php">&larr; Back to products</a></p>
    </div>
  </body>
</html>






