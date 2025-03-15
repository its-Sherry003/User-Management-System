<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LOGIN FORM</title>
</head>
<body>
    <h2>LOGIN FORM</h2><br>

    <?php
    // Display error message if it exists
    if (isset($_GET['error'])) {
        echo "<p style='color:red;'>Invalid email or password.</p><br>";
    }
    $saved_email = isset($_COOKIE['email']) ? $_COOKIE['email'] : '';
    $saved_password = isset($_COOKIE['password']) ? $_COOKIE['password'] : '';
    ?>
    
    <form action = "Login.php" method = "post" enctype = "multipart/form-data">
    <label for="email">Email: </label>
        <input type="text" name="email" value="<?php echo $saved_email; ?>"><br><br>   
        <label for="password">Password: </label>
        <input type="password" name="password" value="<?php echo $saved_password; ?>"><br><br>
        <input type="checkbox" name="remember_me"> Remember Me<br><br>
        <button type="submit" name ="submit" >Login</button><br><br>
        <a href="forgot_password.php">Forgot Password?</a><br><br>
    </form>
</body>
</html>

<?php
session_start();
$server = "localhost";
    $username = "root";
    $password = "";
    $database = "user_management";
    
    $conn = mysqli_connect($server,$username,$password);
    mysqli_select_db($conn,$database);
    
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Check if form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = mysqli_real_escape_string($conn, $_POST["email"]);
    $password = $_POST["password"];
    $remember_me = isset($_POST["remember_me"]);

    // Get user from database
    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);

        // Verify password
        if (password_verify($password, $user["password"])) {
            $_SESSION["user_id"] = $user["id"];
            $_SESSION["username"] = $user["username"];
            $_SESSION["email"] = $user["email"];
            $_SESSION["profile_picture"] = $user["profile_picture"];

            if ($remember_me) {
                setcookie("email", $email, time() + (86400 * 30), "/"); // 30 days
                setcookie("password", $password, time() + (86400 * 30), "/"); 
            }

            header("Location: dashboard.php");
            exit();
        } else {
            // Redirect back with error message
            header("Location: Login.php?error=true");
            exit();
        }
    } else {
        // Redirect back with error message if no user is found
        header("Location: Login.php?error=true");
        exit();
    }
}
?>

