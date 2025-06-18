<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit();
}
require_once "../include/db.php";
$user_id = $_SESSION['user_id'];

// Fetch goals
$stmt = $conn->prepare("SELECT * FROM goals WHERE user_id = ? ORDER BY created_at DESC");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$goals = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Goals - LifeHub</title>
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
    <h2 class="text-center mb-4">🎯 My Goals</h2>

    <!-- Add Goal Form -->
    <form action="add_goal.php" method="POST" class="mb-4">
        <div class="mb-2">
            <input type="text" name="title" class="form-control" placeholder="Goal Title" required>
        </div>
        <div class="mb-2">
            <textarea name="description" class="form-control" placeholder="Goal Description"></textarea>
        </div>
        <div class="mb-2">
            <input type="date" name="target_date" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary">Add Goal</button>
    </form>

    <?php if (empty($goals)): ?>
        <p class="text-center text-muted">No goals yet. Start setting your dreams! 🌟</p>
    <?php else: ?>
        <?php foreach ($goals as $goal): ?>
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title"><?= htmlspecialchars($goal['title']) ?></h5>
                    <p class="card-text"><?= nl2br(htmlspecialchars($goal['description'])) ?></p>
                    <small class="text-muted">🎯 Target: <?= $goal['target_date'] ?: 'No Deadline' ?></small>
                    <div class="mt-2">
                        <?php if ($goal['is_completed']): ?>
                            <span class="badge bg-success">Completed</span>
                        <?php endif; ?>
                        <form action="delete_goal.php" method="POST" class="d-inline "
                              onsubmit="return confirm('Are you sure you want to delete this goal?');">
                            <input type="hidden" name="goal_id" value="<?= $goal['id'] ?>">
                            <button class="btn btn-sm btn-danger">🗑 Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<?php include "../include/footer.html"; ?>
</body>
</html>
