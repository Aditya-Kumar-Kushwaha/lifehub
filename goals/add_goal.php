<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit();
}
require_once "../include/db.php";

$title = $_POST['title'];
$description = $_POST['description'] ?? '';
$target_date = $_POST['target_date'] ?? null;
$user_id = $_SESSION['user_id'];

$stmt = $conn->prepare("INSERT INTO goals (user_id, title, description, target_date) VALUES (?, ?, ?, ?)");
$stmt->bind_param("isss", $user_id, $title, $description, $target_date);
$stmt->execute();
$stmt->close();

header("Location: index.php");
exit();
