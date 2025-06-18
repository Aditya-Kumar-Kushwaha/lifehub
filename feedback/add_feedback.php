<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

require_once "../include/db.php";

$user_id = $_SESSION['user_id'];

// fetch user name
$stmt = $conn->prepare("SELECT name FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($user_name);
$stmt->fetch();
$stmt->close();

// save feedback
$message = htmlspecialchars($_POST['message']);
$stmt = $conn->prepare("INSERT INTO feedback (user_id, user_name, message) VALUES (?, ?, ?)");
$stmt->bind_param("iss", $user_id, $user_name, $message);
$stmt->execute();
$stmt->close();

header("Location: feedback_thankyou.php");
exit();
?>
