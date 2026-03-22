<?php
session_start();
require 'config.php';
$errors = [];
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if(!$email) $errors[] = "Email required.";
    if(!$password) $errors[] = "Password required.";

    if(empty($errors)){
        $stmt = $conn->prepare("SELECT id,name,password FROM users WHERE email = ?");
        $stmt = $conn->prepare("SELECT id, name, password FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->bind_result($id, $name, $hash);

 if ($stmt->fetch() && password_verify($password, $hash)) {

    $_SESSION['user_id']   = $id;
    $_SESSION['user_name'] = $name;

    $ip = $_SERVER['REMOTE_ADDR'];

    // 🔹 login history insert
    $log = $conn->prepare(
        "INSERT INTO login_history (user_id, ip_address) VALUES (?, ?)"
    );

    if ($log) {
        $log->bind_param("is", $id, $ip);
        $log->execute();
    }

    header("Location: index.php");
    exit;
}
 else {
    $errors[] = "Invalid credentials.";
}

                exit;
            } else {
                $errors[] = "Invalid credentials.";
            }
        } else {
            $errors[] = "Invalid credentials.";
        }
    

?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - E-Shop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/custom.css">
  </head>
  <body>
    <?php include 'components/navbar.php'; ?>
    <div class="container py-5">
      <div class="row justify-content-center">
        <div class="col-md-5">
          <div class="card shadow-sm">
            <div class="card-body">
              <h4 class="card-title mb-3">Login</h4>
              <?php if(!empty($_SESSION['success'])){ echo '<div class="alert alert-success">'.htmlspecialchars($_SESSION['success']).'</div>'; unset($_SESSION['success']); } ?>
              <?php if(!empty($errors)) { 
    foreach($errors as $e) { ?>
        <div class="alert alert-danger"><?= htmlspecialchars($e) ?></div>
<?php 
    }
} 
?>

              <form method="post" action="login.php" novalidate>
                <div class="mb-3">
                  <label class="form-label">Email</label>
                  <input type="email" name="email" class="form-control" required>
                </div>
                <div class="mb-3">
                  <label class="form-label">Password</label>
                  <input type="password" name="password" class="form-control" required>
                </div>
                <button class="btn btn-primary w-100" type="submit">Login</button>
              </form>
              <p class="mt-3 mb-0">Don't have an account? <a href="register.php">Register</a></p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>
