<?php
session_start();
if (!isset($_SESSION['user_id'])) {
  header("Location: ../auth/login.php");
  exit();
}
require_once "../include/db.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $title = trim($_POST['title']);
  $description = trim($_POST['description']);
  $frequency = $_POST['frequency'];
  $user_id = $_SESSION['user_id'];

  if (!empty($title)) {
    $stmt = $conn->prepare("INSERT INTO habits (user_id, title, description, frequency) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("isss", $user_id, $title, $description, $frequency);
    $stmt->execute();
    $stmt->close();
  }
}

header("Location: index.php");
exit();
