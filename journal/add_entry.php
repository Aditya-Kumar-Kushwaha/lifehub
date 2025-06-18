<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

require_once "../include/db.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $title = htmlspecialchars($_POST['title']);
    $content = htmlspecialchars($_POST['content']);
    $created_at = date("Y-m-d H:i:s");

    if (!empty($title) && !empty($content)) {
        $stmt = $conn->prepare("INSERT INTO journal_entries (user_id, title, content, created_at) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("isss", $user_id, $title, $content, $created_at);

        if ($stmt->execute()) {
            // Success: Redirect back to index.php
            header("Location: index.php?success=1");
            exit();
        } else {
            echo "Error inserting entry: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Please fill in both title and content.";
    }
} else {
    // Direct access without POST
    header("Location: index.php");
    exit();
}
?>
