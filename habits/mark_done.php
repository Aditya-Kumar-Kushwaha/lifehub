<?php
session_start();
if (!isset($_SESSION['user_id'])) {
  header("Location: ../auth/login.php");
  exit();
}
require_once "../include/db.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['habit_id'])) {
  $habit_id = $_POST['habit_id'];
  $user_id = $_SESSION['user_id'];
  $today = date('d-m-Y');

  // Insert log entry
  $stmt = $conn->prepare("INSERT INTO habit_logs (habit_id, user_id, log_date) VALUES (?, ?, ?)");
  $stmt->bind_param("iis", $habit_id, $user_id, $today);
  $stmt->execute();
  $stmt->close();
}

header("Location: index.php");
exit();
