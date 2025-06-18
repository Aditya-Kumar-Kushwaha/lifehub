<?php
session_start();
require_once "include/db.php";
require_once "include/PHPMailer.php";
require_once "include/SMTP.php";
require_once "include/Exception.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$success = "";
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $name = htmlspecialchars(trim($_POST["name"]));
  $email = htmlspecialchars(trim($_POST["email"]));
  $password = password_hash($_POST["password"], PASSWORD_DEFAULT);
  $verification_token = bin2hex(random_bytes(32));

  // Check if email already exists
  $check = $conn->prepare("SELECT * FROM users WHERE email = ?");
  $check->bind_param("s", $email);
  $check->execute();
  $result = $check->get_result();

  if ($result->num_rows > 0) {
    $error = "This email is already registered.";
  } else {
    // Insert into users table
    $stmt = $conn->prepare("INSERT INTO users (name, email, password, verification_token, is_verified) VALUES (?, ?, ?, ?, 0)");
    $stmt->bind_param("ssss", $name, $email, $password, $verification_token);

    if ($stmt->execute()) {
      // Send verification email
      $verify_link = "http://localhost/verify.php?email=" . urlencode($email) . "&verification_token=$verification_token";

      $mail = new PHPMailer(true);
      try {
        $mail->isSMTP();
        $mail->Host = 'smtp-relay.brevo.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'abc@gmail.com'; // ✅ Your Brevo email
        $mail->Password = '12345'; // ✅ Your Brevo SMTP key
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom('adityakumarkushwaha7761@gmail.com', 'LifeHub');
        $mail->addAddress($email, $name);

        $mail->isHTML(true);
        $mail->Subject = 'Verify Your LifeHub Account';
        $mail->Body = "
          Hi <strong>$name</strong>,<br><br>
          Thank you for registering at <strong>LifeHub</strong>.<br>
          Click the link below to verify your account:<br><br>
          <a href='$verify_link'>$verify_link</a><br><br>
          Regards,<br>LifeHub Team
        ";

        $mail->send();
        $success = "Registration successful! Please check your email to verify your account.";
      } catch (Exception $e) {
        $error = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
      }
    } else {
      $error = "Something went wrong. Please try again.";
    }
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <title>Register - LifeHub</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="css/style.css" />
</head>

<body>
  <div class="wrapper d-flex flex-column min-vh-100">

    <!-- Header -->
    <?php include "include/header.html"; ?>

    <!-- Main Content -->
    <main class="flex-fill">
      <div class="container my-5">
        <h2 class="text-center mb-4">Create Your LifeHub Account</h2>

        <?php if ($success): ?>
          <div class="alert alert-success text-center"><?= $success ?></div>
        <?php endif; ?>

        <?php if ($error): ?>
          <div class="alert alert-danger text-center"><?= $error ?></div>
        <?php endif; ?>

        <form action="" method="POST" class="mx-auto" style="max-width: 450px;">
          <div class="mb-3">
            <label for="name" class="form-label">Full Name</label>
            <input type="text" class="form-control" id="name" name="name" required />
          </div>

          <div class="mb-3">
            <label for="email" class="form-label">Email Address</label>
            <input type="email" class="form-control" id="email" name="email" required />
          </div>

          <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password" required minlength="6" />
          </div>

          <button type="submit" class="btn btn-primary w-100">Register</button>
          <p class="text-center mt-3">Already have an account? <a href="login.php">Login here</a></p>
        </form>
      </div>
    </main>

    <!-- Footer -->
    <?php include "include/footer.html"; ?>

  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>


