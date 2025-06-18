<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit();
}
require_once "../include/db.php";

$goal_id = $_POST['goal_id'];
$user_id = $_SESSION['user_id'];

// Check ownership and delete
$stmt = $conn->prepare("DELETE FROM goals WHERE id = ? AND user_id = ?");
$stmt->bind_param("ii", $goal_id, $user_id);
$stmt->execute();
$stmt->close();

header("Location: index.php");
exit();
