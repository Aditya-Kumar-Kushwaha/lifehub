<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit();
}
require_once "../include/db.php";
$user_id = $_SESSION['user_id'];

// Fetch user's habits
$habits = [];
$stmt = $conn->prepare("SELECT * FROM habits WHERE user_id = ? ORDER BY created_at DESC");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$habits = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();

// Check today’s log for each habit
$today = date('d-m-Y');
$logs = [];
if (!empty($habits)) {
    $habit_ids = array_column($habits, 'id');
    $in_placeholders = implode(',', array_fill(0, count($habit_ids), '?'));

    $types = str_repeat('i', count($habit_ids));
    $query = "SELECT habit_id FROM habit_logs WHERE user_id = ? AND log_date = ?";
    $query .= " AND habit_id IN ($in_placeholders)";
    
    $stmt = $conn->prepare($query);
    
    // Prepare binding parameters (user_id + habit_ids)
    $bindTypes = "is" . $types; // i = user_id, s = log_date, then i*i for habit ids
    $bindValues = array_merge([$bindTypes, $user_id, $today], $habit_ids);
    
    // Reference parameters for bind_param
    $bindRefs = [];
    foreach ($bindValues as $key => $value) {
        $bindRefs[$key] = &$bindValues[$key];
    }

    call_user_func_array([$stmt, 'bind_param'], $bindRefs);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $logs[] = $row['habit_id'];
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Habit Tracker - LifeHub</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        html, body {
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
        <h2 class="text-center mb-4">💪 Habit Tracker</h2>

        <!-- Add Habit Form -->
        <form action="add_habit.php" method="POST" class="row g-3 mb-4">
            <div class="col-md-4">
                <input type="text" name="title" class="form-control" placeholder="Habit Title" required>
            </div>
            <div class="col-md-4">
                <input type="text" name="description" class="form-control" placeholder="Description">
            </div>
            <div class="col-md-3">
                <select name="frequency" class="form-select">
                    <option value="daily">Daily</option>
                    <option value="weekly">Weekly</option>
                </select>
            </div>
            <div class="col-md-1">
                <button type="submit" class="btn btn-primary w-100">Add</button>
            </div>
        </form>

        <?php if (empty($habits)): ?>
            <p class="text-center text-muted">No habits yet. Add your first one! 🌱</p>
        <?php endif; ?>

        <ul class="list-group">
            <?php foreach ($habits as $habit): ?>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <div>
                        <strong><?= htmlspecialchars($habit['title']) ?></strong>
                        <?php if ($habit['description']): ?>
                            <small class="text-muted">(<?= htmlspecialchars($habit['description']) ?>)</small>
                        <?php endif; ?>
                        <br>
                        <small class="text-info">Frequency: <?= $habit['frequency'] ?></small>
                    </div>
                    <div class="btn-group" role="group">
                        <?php if (in_array($habit['id'], $logs)): ?>
                            <button class="btn btn-sm btn-success" disabled>✓ Done Today</button>
                        <?php else: ?>
                            <form action="mark_done.php" method="POST" class="d-inline">
                                <input type="hidden" name="habit_id" value="<?= $habit['id'] ?>">
                                <button type="submit" class="btn btn-sm btn-outline-success">Mark Done</button>
                            </form>
                        <?php endif; ?>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>

    <?php include "../include/footer.html"; ?>
</body>

</html>
