<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; 

session_start();
$server = "localhost";
$username = "root";
$password = "";
$database = "user_management";

$conn = mysqli_connect($server, $username, $password, $database);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// If form submitted, generate reset link
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = mysqli_real_escape_string($conn, $_POST["email"]);

    // Check if email exists in the users table
    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        // Generate a unique reset token
        date_default_timezone_set('Africa/Kampala');
        $token = bin2hex(random_bytes(50));
        $expiry = date("Y-m-d H:i:s", strtotime("+1 hour"));

        // Delete any existing reset request for this email
        $deleteQuery = "DELETE FROM password_reset_requests WHERE email='$email'";
        mysqli_query($conn, $deleteQuery);

        // Store the new token in the password_reset_requests table
        $insertQuery = "INSERT INTO password_reset_requests (email, token, expiry) VALUES ('$email', '$token', '$expiry')";
        mysqli_query($conn, $insertQuery);

        // Create the reset link
        $reset_link = "http://http://localhost/user-management-System/reset_password.php?token=$token";
        $subject = "Password Reset Request";
        $message = "Click the link to reset your password: $reset_link";

        $mail = new PHPMailer(true);
        try {
            // SMTP configuration
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com'; 
            $mail->SMTPAuth = true;
            $mail->Username = 'youremail@gmail.com';
            $mail->Password = 'password';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;
            


            // Email settings
            $mail->setFrom('youremail@gmail.com', 'Group D User management');
            $mail->addAddress($email);
            $mail->Subject = $subject;
            $mail->Body = $message;

            $mail->send();
            echo "Password reset link sent! Check your email.";
        } catch (Exception $e) {
            echo "Error sending email: " . $mail->ErrorInfo;
        }
    } else {
        echo "No account found with that email.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Forgot Password</title>
</head>
<body>
    <h2>Reset Password</h2>
    <form action="forgot_password.php" method="post">
        <label>Email:</label>
        <input type="email" name="email" required>
        <button type="submit">Submit</button>
    </form>
</body>
</html>
