<?php
session_start();
require_once "include/db.php";

$error = "";

// Check if already logged in
if (isset($_SESSION["user_id"])) {
  header("Location: index.php");
  exit();
}

// Handle login form
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $email = trim($_POST["email"]);
  $password = trim($_POST["password"]);

  // 👇 Fetch everything including is_verified
  $query = "SELECT id, name, password, is_verified FROM users WHERE email = ?";
  $stmt = $conn->prepare($query);
  $stmt->bind_param("s", $email);
  $stmt->execute();
  $stmt->store_result();

  if ($stmt->num_rows == 1) {
    $stmt->bind_result($user_id, $name, $hashedPassword, $is_verified);
    $stmt->fetch();

    // ✅ Step 1: Check if email is verified
    if ($is_verified != 1) {
      $error = "Please verify your email before logging in.";
    }
    // ✅ Step 2: Check password
    elseif (password_verify($password, $hashedPassword)) {
      $_SESSION["user_id"] = $user_id;
      $_SESSION["name"] = $name;
      header("Location: index.php");
      exit();
    } else {
      $error = "Galat password. Kripya dobara try karein.";
    }
  } else {
    $error = "Koi user is email se exist nahi karta.";
  }

  $stmt->close();
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <title>Login - LifeHub</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="css/style.css" />
</head>

<body>
  <div class="wrapper d-flex flex-column min-vh-100">
    <?php include "include/header.html"; ?>

    <main class="flex-fill">
      <div class="container my-5">
        <h2 class="text-center mb-4">Login to LifeHub</h2>

        <?php if ($error): ?>
          <div class="alert alert-danger text-center"><?= $error ?></div>
        <?php endif; ?>

        <form action="" method="POST" class="mx-auto" style="max-width: 450px;">
          <div class="mb-3">
            <label for="email" class="form-label">Email Address</label>
            <input type="email" class="form-control" id="email" name="email" required />
          </div>

          <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password" required />
          </div>

          <button type="submit" class="btn btn-success w-100">Login</button>
          <p class="text-center mt-3">Don't have an account? <a href="register.php">Register here</a></p>
        </form>
      </div>
    </main>

    <?php include "include/footer.html"; ?>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
