<?php
// Include DB connection
require_once "include/db.php";

// Handle form submission
$success = "";
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Sanitize input
  $name = trim($_POST["name"]);
  $email = trim($_POST["email"]);
  $password = trim($_POST["password"]);
  $hashedPassword = password_hash($password, PASSWORD_DEFAULT); // secure password

  // Check if email already exists
  $checkQuery = "SELECT * FROM users WHERE email = ?";
  $stmt = $conn->prepare($checkQuery);
  $stmt->bind_param("s", $email);
  $stmt->execute();
  $stmt->store_result();

  if ($stmt->num_rows > 0) {
    $error = "Yeh email pahle se hi register hai. Kripya dusra email use karein.";
  } else {
    // Insert user
    $insertQuery = "INSERT INTO users (name, email, password) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($insertQuery);
    $stmt->bind_param("sss", $name, $email, $hashedPassword);

    if ($stmt->execute()) {
      $success = "Aapka account successfully create ho gaya hai! Aap ab <a href='login.php'>login</a> kar sakte hain.";
    } else {
      $error = "Kuch galat ho gaya hai. Kripya phir se koshish karein.";
    }
  }

  $stmt->close();
}
?>