<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Thank You - LifeHub</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        html, body {
            height: 100%;
            margin: 0;
        }

        body {
            display: flex;
            flex-direction: column;
            background-color: #f8f9fa;
        }

        .main-content {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 30px;
        }

        .thank-you-card {
            background: #ffffff;
            border-radius: 15px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
            padding: 40px;
            text-align: center;
            max-width: 500px;
            width: 100%;
        }

        .thank-you-card h2 {
            font-size: 2rem;
            color: #28a745;
            margin-bottom: 20px;
        }

        .thank-you-card p {
            font-size: 1.1rem;
            color: #555;
        }

        .thank-you-card a.btn {
            margin-top: 25px;
        }
    </style>
</head>

<body>
    <?php include "../include/header.html"; ?>

    <div class="container main-content">
        <div class="thank-you-card">
            <h2>🎉 Thank You!</h2>
            <p>Your message has been received.<br>We’ll get back to you as soon as possible.</p>
            <a href="../index.php" class="btn btn-primary">Back to Dashboard</a>
        </div>
    </div>

    <?php include "../include/footer.html"; ?>
</body>

</html>
