<?php
session_start();
require 'config.php';

// Featured products for home page
$featured = $conn->query("SELECT * FROM products ORDER BY id DESC LIMIT 6");
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Simple E-Commerce (Bootstrap)</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/custom.css">
  </head>
  <body>
    <?php include 'components/navbar.php'; ?>



    <!-- HERO SECTION -->
<section class="hero-section text-center py-5">


  <div class="container">
    <h1 class="display-5 fw-bold">Shop Smart, Shop Online</h1>

    <p class="lead text-muted">
      Best products at best prices – PHP & MySQL based E-Commerce Website
    </p>

    <a href="products.php" class="btn btn-primary btn-lg mt-3">
      Explore Products
    </a>

    <!-- SEARCH BAR -->
    <form action="products.php" method="get" class="mt-4">
      <div class="row justify-content-center">
        <div class="col-md-6">
          <div class="input-group">
            <input
              type="text"
              name="search"
              class="form-control form-control-lg"
              placeholder="Search products like laptop, shoes, watch..."
              required
            >
            <button class="btn btn-primary btn-lg" type="submit">
              Search
            </button>
          </div>
        </div>
      </div>
    </form>

  </div>
</section>

<!-- FEATURES SECTION -->
<section class="container py-5">
  <div class="row text-center">
    <div class="col-md-4">
      <h4>🛒 Easy Shopping</h4>
      <p>Simple cart and checkout system using PHP sessions.</p>
    </div>
    <div class="col-md-4">
      <h4>🔐 Secure Login</h4>
      <p>User authentication with MySQL database.</p>
    </div>
    <div class="col-md-4">
      <h4>⚡ Fast Order</h4>
      <p>Quick order placement and confirmation.</p>
    </div>
  </div>
</section>

<section class="container py-5">
  <h2 class="text-center mb-4">Featured Products</h2>

  <div class="row g-4">
    <?php while($p = $featured->fetch_assoc()): ?>
      <div class="col-md-4">
        <div class="card h-100 shadow-sm">
          <?php if(!empty($p['image'])): ?>
            <img src="<?php echo htmlspecialchars($p['image']); ?>"
                 class="card-img-top"
                 style="height:220px;object-fit:cover;">
          <?php endif; ?>

          <div class="card-body">
            <h5 class="card-title"><?php echo htmlspecialchars($p['name']); ?></h5>
            <p class="text-muted small"><?php echo htmlspecialchars($p['category']); ?></p>
            <p class="fw-bold">₹<?php echo number_format($p['price']); ?></p>
            <a href="products.php" class="btn btn-primary btn-sm">View Product</a>
          </div>
        </div>
      </div>
    <?php endwhile; ?>
  </div>
</section>


<!-- CATEGORIES -->
<section class="bg-light py-5">
  <div class="container">
    <h2 class="text-center mb-4">Shop by Category</h2>

    <div class="row text-center">
      <div class="col-md-3">
        <a href="products.php?cat=Electronics" class="text-decoration-none">
          <div class="card shadow-sm p-4">
            <h5>📱 Electronics</h5>
          </div>
        </a>
      </div>

      <div class="col-md-3">
        <a href="products.php?cat=Fashion" class="text-decoration-none">
          <div class="card shadow-sm p-4">
            <h5>👕 Fashion</h5>
          </div>
        </a>
      </div>

      <div class="col-md-3">
        <a href="products.php?cat=Books" class="text-decoration-none">
          <div class="card shadow-sm p-4">
            <h5>📚 Books</h5>
          </div>
        </a>
      </div>

      <div class="col-md-3">
        <a href="products.php?cat=Accessories" class="text-decoration-none">
          <div class="card shadow-sm p-4">
            <h5>🎒 Accessories</h5>
          </div>
        </a>
      </div>
    </div>
  </div>
</section>



<section class="container py-5">
  <h2 class="text-center mb-3">Why Choose This Project?</h2>
  <p class="text-center text-muted">
    This project demonstrates real-world implementation of PHP, MySQL,
    session handling, authentication, cart management and responsive UI using Bootstrap.
  </p>
</section>

    <div class="container py-5">
      <div class="text-center">
        <h1 class="mb-3">Welcome to Simple E-Commerce</h1>
        <p class="lead">A small project built with PHP, MySQL and Bootstrap (Option B - Modern Design)</p>
        <a class="btn btn-primary" href="products.php">Browse Products</a>
      </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>