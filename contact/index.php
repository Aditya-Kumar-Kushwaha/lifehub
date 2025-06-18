<?php
session_start();
require_once "../include/db.php";
$user_id = $_SESSION['user_id'] ?? null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Contact Us - LifeHub</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    /* for footer */
    html,
    body {
      height: 100%;
      background-color: #f9f9f9;
    }

    body {
      display: flex;
      flex-direction: column;
    }

    .main-content {
      flex: 1;
    }

    /* for this page */

    .contact-wrapper {
      max-width: 700px;
      margin: 50px auto;
      background: #fff;
      padding: 30px;
      border-radius: 15px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }

    .contact-wrapper h2 {
      text-align: center;
      margin-bottom: 30px;
      color: #343a40;
    }

    .social-links {
      display: flex;
      justify-content: center;
      flex-wrap: wrap;
      gap: 15px;
      margin-top: 40px;
    }

    .social-links a {
      padding: 10px 20px;
      border-radius: 30px;
      color: white;
      text-decoration: none;
      font-weight: 500;
      transition: 0.3s ease;
    }

    .social-links a.phone { background: #28a745; }
    .social-links a.email { background: #007bff; }
    .social-links a.linkedin { background: #0e76a8; }
    .social-links a.instagram { background: #e1306c; }
    .social-links a.whatsapp { background: #25d366; }

    .social-links a:hover {
      opacity: 0.85;
    }
    
  </style>
</head>
<body>

<?php include "../include/header.html"; ?>

<div class="container main-content mt-5">
  <div class="contact-wrapper">
    <h2>📬 Contact Us</h2>

    <!-- Contact Form -->
    <form action="submit_contact.php" method="POST">
      <input type="hidden" name="user_id" value="<?= $user_id ?>">

      <div class="mb-3">
        <label>Your Name</label>
        <input type="text" name="name" class="form-control" placeholder="Enter your name" required>
      </div>

      <div class="mb-3">
        <label>Your Email</label>
        <input type="email" name="email" class="form-control" placeholder="Enter your email" required>
      </div>

      <div class="mb-3">
        <label>Your Message</label>
        <textarea name="message" rows="5" class="form-control" placeholder="Write your message..." required></textarea>
      </div>

      <button type="submit" class="btn btn-primary w-100">Send Message</button>
    </form>

    <!-- Social Contact Links -->
    <div class="social-links mt-4">
      <a href="tel:+917726910115" class="phone" target="_blank">📞 Call</a>
      <a href="mailto:adityakumarkushwaha7761@gmail.com" class="email" target="_blank">📧 Email</a>
      <a href="https://linkedin.com/in/aditya-kumar-kushwaha-545289345" class="linkedin" target="_blank">💼 LinkedIn</a>
      <a href="https://instagram.com/yourprofile" class="instagram" target="_blank">📸 Instagram</a>
      <a href="https://wa.me/917726910115" class="whatsapp" target="_blank">💬 WhatsApp</a>
    </div>
  </div>
</div>

<?php include "../include/footer.html"; ?>

</body>
</html>
