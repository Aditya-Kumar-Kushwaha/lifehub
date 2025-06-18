<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit();
}
require_once "../include/db.php";
$user_id = $_SESSION['user_id'];

// Fetch user's journal entries
$stmt = $conn->prepare("SELECT * FROM journal_entries WHERE user_id = ? ORDER BY entry_date DESC");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$entries = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>My Journal - LifeHub</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        html,
        body {
            height: 100%;
            margin: 0;
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
        <h2 class="text-center mb-4">📓 My Journal</h2>

        <!-- Add Journal Entry Form -->
        <form action="add_entry.php" method="POST" class="mb-4">
            <div class="mb-2">
                <input type="text" name="title" class="form-control" placeholder="Title" required>
            </div>
            <div class="mb-2">
                <textarea name="content" rows="4" class="form-control" placeholder="Write your thoughts..." required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Add Entry</button>
        </form>

        <!-- Show journal entries -->
        <?php if (empty($entries)): ?>
            <p class="text-center text-muted">No journal entries yet. Start writing your story! ✨</p>
        <?php else: ?>
            <?php foreach ($entries as $entry): ?>
                <div class="card mb-3">
                    <div class="card-body">
                        <h5 class="card-title"><?= htmlspecialchars($entry['title']) ?></h5>
                        <p class="card-text"><?= nl2br(htmlspecialchars($entry['content'])) ?></p>
                        <small class="text-muted">📅 <?= htmlspecialchars($entry['entry_date']) ?></small>

                        <!-- Delete Button -->
                        <form action="delete_entry.php" method="POST" class="mt-2"
                            onsubmit="return confirm('Are you sure you want to delete this entry?');">
                            <input type="hidden" name="entry_id" value="<?= $entry['id'] ?>">
                            <button type="submit" class="btn btn-sm btn-danger">🗑 Delete</button>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <?php include "../include/footer.html"; ?>
</body>

</html>
