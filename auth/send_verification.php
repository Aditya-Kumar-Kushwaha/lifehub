// php start 
// use PHPMailer\PHPMailer\PHPMailer;
// use PHPMailer\PHPMailer\Exception;

// // PHPMailer ki files include karo
// require '../include/PHPMailer.php';
// require '../include/SMTP.php';
// require '../include/Exception.php';

// /**
//  * Email Verification Bhejne Ka Function
//  * 
//  * @param string $userEmail            - User ka email jise verification bhejna hai
//  * @param string $userName             - User ka naam (optional)
//  * @param string $verification_token   - Unique token jo verify link me jata hai
//  * @return bool|string                 - true agar success, else error string
//  */
// function sendVerificationEmail($userEmail, $userName, $verification_token)
// {
//     $mail = new PHPMailer(true);

//     try {
//         // SMTP Configuration
//         $mail->isSMTP();
//         $mail->Host = 'smtp-relay.brevo.com';
//         $mail->SMTPAuth = true;
//         $mail->Username = ''; // 🔁 Replace this
//         $mail->Password = '';          // 🔁 Replace this
//         $mail->SMTPSecure = 'tls';
//         $mail->Port = 587;

//         // Sender & Receiver
//         $mail->setFrom('adityakumarkushwaha7761@gmail.com', 'LifeHub'); // 🔁 Replace
//         $mail->addAddress($userEmail, $userName);

//         // Email Content
//         $verifyLink = "http://localhost/auth/verify.php?email=" . urlencode($userEmail) . "&verification_token=" . urlencode($verification_token);

//         $mail->isHTML(true);
//         $mail->Subject = 'Verify Your Email - LifeHub';
//         $mail->Body = "
//             Hi <strong>$userName</strong>,<br><br>
//             Thank you for registering at <strong>LifeHub</strong>.<br>
//             Please click the link below to verify your email:<br><br>
//             <a href='$verifyLink'>$verifyLink</a><br><br>
//             Regards,<br>
//             LifeHub Team
//         ";

//         $mail->send();
//         return true;

//     } catch (Exception $e) {
//         return "Email nahi bhej paye. Error: {$mail->ErrorInfo}";
//     }
// }
<!-- php close -->
