<?php
session_start();

if (!isset($_SESSION['user_id'])) {
  header("Location: login.php");
  exit();
}

$user_id = $_SESSION['user_id'];


// DB connection
require_once "../include/db.php";

// Insert Task
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_task'])) {
  $title = trim($_POST['title']);
  $description = trim($_POST['description']);
  $due_date = $_POST['due_date'];

  if (!empty($title)) {
    $stmt = $conn->prepare("INSERT INTO tasks (user_id, title, description, due_date) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("isss", $user_id, $title, $description, $due_date);
    $stmt->execute();
    $stmt->close();
  }
}

// Toggle Done
if (isset($_POST['toggle_done'])) {
  $task_id = $_POST['task_id'];
  $user_id = $_SESSION['user_id']; // ADD THIS
  $stmt = $conn->prepare("UPDATE tasks SET is_done = NOT is_done WHERE id = ? AND user_id = ?");
  $stmt->bind_param("ii", $task_id, $user_id); // FIXED
  $stmt->execute();
  $stmt->close();
}


// Delete Task
if (isset($_POST['delete_task'])) {
  $task_id = $_POST['task_id'];
  $user_id = $_SESSION['user_id']; // ADD THIS
  $stmt = $conn->prepare("DELETE FROM tasks WHERE id = ? AND user_id = ?");
  $stmt->bind_param("ii", $task_id, $user_id); // FIXED
  $stmt->execute();
  $stmt->close();
}


// Fetch tasks
// Secure way to fetch only current user's tasks
$tasks = [];
$stmt = $conn->prepare("SELECT * FROM tasks WHERE user_id = ? ORDER BY created_at DESC");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$tasks = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Planner - LifeHub</title>
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

  <div class="container main-content my-5">
    <h2 class="text-center mb-4"> 📅 Daily Planner</h2>

    <!-- Task Form -->
    <form action="" method="POST" class="row g-3 mb-4">
      <div class="col-md-4">
        <input type="text" name="title" class="form-control" placeholder="Task Title" required>
      </div>
      <div class="col-md-4">
        <input type="text" name="description" class="form-control" placeholder="Description">
      </div>
      <div class="col-md-3">
        <input type="date" name="due_date" class="form-control">
      </div>
      <div class="col-md-1">
        <button type="submit" name="add_task" class="btn btn-primary w-100">Add</button>
      </div>
    </form>

    <!-- if not task added this msg will show -->
    <?php if (empty($tasks)): ?>
      <p class="text-center text-muted">No tasks yet. Add your first one! ✨</p>
    <?php endif; ?>


    <!-- Task List -->
    <ul class="list-group">
      <?php foreach ($tasks as $task): ?>
        <li class="list-group-item d-flex justify-content-between align-items-center">
          <div>
            <strong><?= htmlspecialchars($task["title"]) ?></strong>
            <?php if ($task["description"]): ?>
              <small class="text-muted">(<?= htmlspecialchars($task["description"]) ?>)</small>
            <?php endif; ?>
            <?php if ($task["due_date"]): ?>
              <br><small class="text-info">Due: <?= $task["due_date"] ?></small>
            <?php endif; ?>
            <br>
            <span class="badge bg-<?= $task["is_done"] ? 'success' : 'secondary' ?>">
              <?= $task["is_done"] ? 'Done' : 'Pending' ?>
            </span>
          </div>

          <div class="btn-group" role="group">
            <!-- Toggle Done -->
            <form method="POST" class="d-inline">
              <input type="hidden" name="task_id" value="<?= $task['id'] ?>">
              <button type="submit" name="toggle_done"
                class="btn btn-sm btn-outline-<?= $task["is_done"] ? 'secondary' : 'success' ?>">
                <?= $task["is_done"] ? 'Undo' : 'Done' ?>
              </button>
            </form>

            <!-- Delete -->
            <form method="POST" class="d-inline ms-2">
              <input type="hidden" name="task_id" value="<?= $task['id'] ?>">
              <button type="submit" name="delete_task" class="btn btn-sm btn-outline-danger">Delete</button>
            </form>
          </div>
        </li>
      <?php endforeach; ?>
    </ul>
  </div>

  <?php include "../include/footer.html"; ?>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>