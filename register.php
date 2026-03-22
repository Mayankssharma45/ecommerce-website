<?php
session_start();
require 'config.php';
$errors = [];
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if(!$name) $errors[] = "Name is required.";
    if(!$email || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Valid email is required.";
    if(!$password || strlen($password) < 5) $errors[] = "Password must be at least 5 characters.";

    if(empty($errors)){
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->bind_param('s',$email);
        $stmt->execute();
        $stmt->store_result();
        if($stmt->num_rows > 0){
            $errors[] = "Email already registered.";
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $ins = $conn->prepare("INSERT INTO users (name,email,password) VALUES (?,?,?)");
            $ins->bind_param('sss',$name,$email,$hash);
            if($ins->execute()){
                $_SESSION['success'] = "Registration successful. Please login.";
                header('Location: login.php');
                exit;
            } else {
                $errors[] = "Database error: couldn't register.";
            }
        }
    }
}
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register - E-Shop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/custom.css">
  </head>
  <body>
    <?php include 'components/navbar.php'; ?>
    <div class="container py-5">
      <div class="row justify-content-center">
        <div class="col-md-6">
          <div class="card shadow-sm">
            <div class="card-body">
              <h4 class="card-title mb-3">Create Account</h4>
              <?php
if (!empty($errors)) {
    foreach ($errors as $e) {
        echo '<div class="alert alert-danger">'.htmlspecialchars($e).'</div>';
    }
}
?>

              <form method="post" action="register.php" novalidate>
                <div class="mb-3">
                  <label class="form-label">Name</label>
                  <input type="text" name="name" class="form-control" required>
                </div>
                <div class="mb-3">
                  <label class="form-label">Email</label>
                  <input type="email" name="email" class="form-control" required>
                </div>
                <div class="mb-3">
                  <label class="form-label">Password</label>
                  <input type="password" name="password" class="form-control" required minlength="5">
                </div>
                <button class="btn btn-primary w-100" type="submit">Register</button>
              </form>
              <p class="mt-3 mb-0">Already registered? <a href="login.php">Login here</a></p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>
