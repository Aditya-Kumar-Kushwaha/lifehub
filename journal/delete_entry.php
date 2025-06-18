<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

require_once "../include/db.php";

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['entry_id'])) {
    $user_id = $_SESSION['user_id'];
    $entry_id = $_POST['entry_id'];

    // only authorized user can delete their own entry
    $stmt = $conn->prepare("DELETE FROM journal_entries WHERE id = ? AND user_id = ?");
    $stmt->bind_param("ii", $entry_id, $user_id);

    if ($stmt->execute()) {
        header("Location: index.php?deleted=1");
        exit();
    } else {
        echo "Error deleting entry: " . $stmt->error;
    }

    $stmt->close();
} else {
    header("Location: index.php");
    exit();
}
?>
