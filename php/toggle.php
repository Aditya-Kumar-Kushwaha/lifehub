<?php
require_once "../include/db.php";
$task_id = $_POST['task_id'];

$conn->query("UPDATE tasks SET is_done = NOT is_done WHERE id = $task_id");
header("Location: planner.php");
