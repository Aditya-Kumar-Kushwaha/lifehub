<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>Dashboard - LifeHub</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="css/style.css" />
</head>

<body>
    <div class="wrapper d-flex flex-column min-vh-100">

        <!-- Header -->
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container">
                <a class="navbar-brand" href="index.php">LifeHub</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="ms-auto d-flex align-items-center gap-3">
                    <span class="text-white">Hi, <?= $_SESSION['name'] ?? 'User'; ?> 👋</span>
                    <a href="logout.php" class="btn btn-outline-light btn-sm">Logout</a>
                </div>


                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                        <li class="nav-item"><a class="nav-link" href="planner/index.php">Planner</a></li>
                        <li class="nav-item"><a class="nav-link" href="journal/index.php">Journal</a></li>
                        <li class="nav-item"><a class="nav-link" href="habits/index.php">Habits</a></li>
                        <li class="nav-item"><a class="nav-link" href="goals/index.php">Goals</a></li>
                        <li class="nav-item"><a class="nav-link" href="feedback/index.php">Feedback</a></li>
                        <li class="nav-item"><a class="nav-link" href="contact/index.php">Contact Us</a></li>
                    </ul>
                </div>
            </div>
        </nav>



        <main class="flex-fill d-flex flex-column align-items-center justify-content-center text-center">
            <h1 class="display-5 fw-bold text-primary mb-4">Welcome to LifeHub <?= $_SESSION['name']; ?> 👋</h1>
            <p class="lead mb-4">Organize your day, reflect on your thoughts, and build better habits – all in one
                place.</p>

            <div class="row g-4 justify-content-center w-100" style="max-width: 900px;">
                <div class="col-md-4">
                    <div class="card shadow-sm h-100">
                        <div class="card-body">
                            <h5 class="card-title">📅 Daily Planner</h5>
                            <p class="card-text">Plan your tasks and schedule your day with ease.</p>
                            <a href="planner/index.php" class="btn btn-outline-primary w-100">Open Planner</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card shadow-sm h-100">
                        <div class="card-body">
                            <h5 class="card-title">📓 Journal</h5>
                            <p class="card-text">Reflect on your thoughts and keep your memories safe.</p>
                            <a href="journal/index.php" class="btn btn-outline-success w-100">Go to Journal</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card shadow-sm h-100">
                        <div class="card-body">
                            <h5 class="card-title">🔥 Habit Tracker</h5>
                            <p class="card-text">Track your habits and build consistency every day.</p>
                            <a href="habits/index.php" class="btn btn-outline-warning w-100 text-dark">Track Habits</a>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <?php include "include/footer.html"; ?>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>