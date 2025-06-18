<?php
require_once "include/db.php";

$success = "";
$error = "";

// URL parameters check karo
if (isset($_GET['email']) && isset($_GET['verification_token'])) {
    $email = $_GET['email'];
    $token = $_GET['verification_token'];  // ✅ Use correct variable name

    // Check karo user exist karta hai ya nahi
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ? AND verification_token = ? AND is_verified = 0");
    $stmt->bind_param("ss", $email, $token);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        // User mila, to usko verify karo
        $update = $conn->prepare("UPDATE users SET is_verified = 1, verification_token = '' WHERE email = ?");
        $update->bind_param("s", $email);
        if ($update->execute()) {
            $success = "✅ Your email has been successfully verified! You can now <a href='login.php'>login</a>.";
        } else {
            $error = "❌ Failed to verify. Please try again later.";
        }
    } else {
        $error = "⚠️ Invalid or already verified token.";
    }
} else {
    $error = "⚠️ Invalid verification link.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Email Verification - LifeHub</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
  <div class="container my-5">
    <div class="text-center">
      <h2>Email Verification</h2>

      <?php if ($success): ?>
        <div class="alert alert-success mt-4"><?= $success ?></div>
      <?php endif; ?>

      <?php if ($error): ?>
        <div class="alert alert-danger mt-4"><?= $error ?></div>
      <?php endif; ?>
      
    </div>
  </div>
</body>
</html>
