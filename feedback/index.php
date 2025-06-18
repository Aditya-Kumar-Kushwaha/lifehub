<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}
require_once "../include/db.php";
$user_id = $_SESSION['user_id'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Feedback - LifeHub</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        html,
        body {
            height: 100%;
        }

        body {
            display: flex;
            flex-direction: column;
        }

        .main-content {
            flex: 1;
        }
    </style>
</head>

<body>
    <?php include "../include/header.html"; ?>

    <div class="container main-content mt-5">
        <h2 class="text-center mb-4">💬 Feedback</h2>
        <form action="add_feedback.php" method="POST">
            <div class="mb-3">
                <textarea name="message" class="form-control" rows="5" placeholder="Write your feedback..."
                    required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Submit Feedback</button>
        </form>
    </div>

    <?php include "../include/footer.html"; ?>
</body>

</html>