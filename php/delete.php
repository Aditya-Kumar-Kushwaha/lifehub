<?php
require_once "../include/db.php";
$task_id = $_POST['task_id'];

$conn->query("DELETE FROM tasks WHERE id = $task_id");
header("Location: planner.php");
