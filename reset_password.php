<?php
session_start();
$server = "localhost";
$username = "root";
$password = "";
$database = "user_management";

$conn = mysqli_connect($server, $username, $password, $database);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if reset token is valid
if (!isset($_GET["token"])) {
    die("Invalid request.");
}

$token = mysqli_real_escape_string($conn, $_GET["token"]);

// Get email linked to the token and check expiry
$query = "SELECT email FROM password_reset_requests WHERE token='$token' AND expiry > NOW()";
$result = mysqli_query($conn, $query);

if (!$result || mysqli_num_rows($result) === 0) {
    die("Invalid or expired token.");
}

$row = mysqli_fetch_assoc($result);
$email = $row["email"];

// If form is submitted, update password
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_password = password_hash($_POST["password"], PASSWORD_DEFAULT);

    // Update password in users table
    $updateQuery = "UPDATE users SET password='$new_password' WHERE email='$email'";
    mysqli_query($conn, $updateQuery);

    // Delete used reset token
    $deleteQuery = "DELETE FROM password_reset_requests WHERE token='$token'";
    mysqli_query($conn, $deleteQuery);

    echo "Password reset successful! <a href='Login.php'>Login</a>";
    header("Location: Login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Reset Password</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
        }
        h2 {
            text-align: center;
            margin-top: 20px;
        }
        form {
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        label {
            display: block;
            margin-bottom: 10px;
            font-weight: bold;
        }
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button[type="submit"] {
            background-color: #4CAF50;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button[type="submit"]:hover {
            background-color: #45a049;
        }
        .error-message {
            color: red;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <h2>Enter New Password</h2>
    <form action="reset_password.php?token=<?= htmlspecialchars($_GET['token']) ?>" method="post">
        <label>New Password:</label>
        <input type="password" name="password" required>
        <button type="submit">Reset Password</button>
    </form>
</body>
</html>
