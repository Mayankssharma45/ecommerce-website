<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
require 'config.php';

/* ----------- FILTER LOGIC ----------- */
$cat = isset($_GET['cat']) ? trim($_GET['cat']) : '';
$search = isset($_GET['search']) ? trim($_GET['search']) : '';

$query = "SELECT * FROM products WHERE 1=1";

if ($search !== '') {
    $s = $conn->real_escape_string($search);
    $query .= " AND (name LIKE '%$s%' OR category LIKE '%$s%' OR description LIKE '%$s%')";
}

if ($cat !== '') {
    $c = $conn->real_escape_string($cat);
    $query .= " AND category='$c'";
}

$query .= " ORDER BY id DESC";

$res = $conn->query($query);
if (!$res) {
    die("SQL Error: " . $conn->error);
}

/* ----------- CATEGORY DROPDOWN ----------- */
$catRes = $conn->query("SELECT DISTINCT category FROM products");
?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Products - E-Shop</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/custom.css">
</head>

<body>

<?php include 'components/navbar.php'; ?>

<div class="container py-4">

  <!-- HEADER + FILTER -->
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="m-0">Products</h2>

    <form method="GET" class="d-flex">
      <select name="cat" class="form-select me-2">
        <option value="">All Categories</option>
        <?php while($c = $catRes->fetch_assoc()): ?>
          <option value="<?php echo htmlspecialchars($c['category']); ?>"
            <?php if($cat === $c['category']) echo 'selected'; ?>>
            <?php echo htmlspecialchars($c['category']); ?>
          </option>
        <?php endwhile; ?>
      </select>

      <?php if($search !== ''): ?>
        <input type="hidden" name="search" value="<?php echo htmlspecialchars($search); ?>">
      <?php endif; ?>

      <button class="btn btn-outline-primary" type="submit">Filter</button>
    </form>
  </div>

  <!-- NO PRODUCTS MESSAGE -->
  <?php if ($res->num_rows === 0): ?>
    <div class="alert alert-warning text-center">
      No products found.
    </div>
  <?php endif; ?>

  <!-- PRODUCTS GRID -->
  <div class="row g-3">
    <?php while($p = $res->fetch_assoc()): ?>
      <div class="col-md-4">
        <div class="card h-100 shadow-sm">

          <?php if(!empty($p['image'])): ?>
            <img src="<?php echo htmlspecialchars($p['image']); ?>"
                 class="card-img-top"
                 style="height:220px;object-fit:cover;">
          <?php endif; ?>

          <div class="card-body d-flex flex-column">
            <h5 class="card-title">
              <?php echo htmlspecialchars($p['name']); ?>
            </h5>

            <p class="text-muted small">
              <?php echo htmlspecialchars($p['category']); ?>
            </p>

            <p class="card-text small">
              <?php echo htmlspecialchars(substr($p['description'], 0, 100)); ?>...
            </p>

            <div class="mt-auto">
              <p class="fw-bold mb-2">
                ₹<?php echo number_format($p['price']); ?>
              </p>

              <a href="product-details.php?id=<?php echo $p['id']; ?>"
                 class="btn btn-primary w-100">
                View
              </a>
            </div>
          </div>

        </div>
      </div>
    <?php endwhile; ?>
  </div>

</div>

</body>
</html>
