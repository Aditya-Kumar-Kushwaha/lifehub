<?php
session_start();
require_once "../include/db.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $user_id = $_POST['user_id'] ?? null;
    $name = htmlspecialchars(trim($_POST['name']));
    $email = htmlspecialchars(trim($_POST['email']));
    $message = htmlspecialchars(trim($_POST['message']));

    $stmt = $conn->prepare("INSERT INTO contact_messages (user_id, name, email, message) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("isss", $user_id, $name, $email, $message);
    $stmt->execute();
    $stmt->close();

    header("Location: thank_you.php");
    exit();
} else {
    header("Location: index.php");
    exit();
}
