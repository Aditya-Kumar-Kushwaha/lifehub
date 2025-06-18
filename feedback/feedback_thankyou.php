<?php include "../include/header.html"; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Thank You - Feedback</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f6f9;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .thankyou-container {
            min-height: 80vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .thankyou-card {
            background: white;
            padding: 40px 30px;
            border-radius: 20px;
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.1);
            text-align: center;
            max-width: 500px;
            width: 100%;
        }

        .thankyou-card h2 {
            color: #333;
            font-weight: bold;
        }

        .thankyou-card p {
            color: #666;
            margin: 15px 0 30px;
        }

        .thankyou-card .btn-custom {
            background-color: #007bff;
            color: white;
            padding: 10px 25px;
            border-radius: 30px;
            font-weight: 500;
            transition: 0.3s ease;
            text-decoration: none;
        }

        .thankyou-card .btn-custom:hover {
            background-color: #0056b3;
            text-decoration: none;
        }
    </style>
</head>
<body>

<div class="thankyou-container">
    <div class="thankyou-card">
        <h2>🎉 Thank You for Your Feedback!</h2>
        <p>Your thoughts help us make LifeHub more valuable for everyone. We appreciate your time! 💖</p>
        <a href="../index.php" class="btn btn-custom">Go Back to Dashboard</a>
    </div>
</div>

<?php include "../include/footer.html"; ?>
</body>
</html>
