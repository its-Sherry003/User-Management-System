<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LOGIN FORM</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            width: 350px;
            text-align: center;
        }
        h2 {
            margin-bottom: 20px;
            color: #333;
        }
        label {
            display: block;
            text-align: left;
            margin: 10px 0 5px;
            font-weight: bold;
        }
        input {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }
        button {
            width: 100%;
            padding: 10px;
            background: #28a745;
            border: none;
            color: white;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 10px;
        }
        
        button:hover {
            background: #218838;
        }
        .register-btn {
            background: #007bff;
        }
        
        .register-btn:hover {
            background: #0056b3;
        }
        .login-btn {
            background:rgb(167, 40, 101);
        }
        .remember-me {
            text-align: left;
            margin: 10px 0;
        }
        .forgot-password {
            display: block;
            margin-top: 10px;
            color: #007bff;
            text-decoration: none;
        }
        .forgot-password:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>LOGIN</h2>
        <?php
        if (isset($_GET['error'])) {
            echo "<p class='error-message'>Invalid email or password.</p>";
        }
        $saved_email = isset($_COOKIE['email']) ? $_COOKIE['email'] : '';
        $saved_password = isset($_COOKIE['password']) ? $_COOKIE['password'] : '';
        ?>
        
        <form action="Login.php" method="post" enctype="multipart/form-data">
            <label for="email">Email:</label>
            <input type="text" name="email" value="<?php echo $saved_email; ?>" required>
            
            <label for="password">Password:</label>
            <input type="password" name="password" value="<?php echo $saved_password; ?>" required>
            
            <div class="remember-me">
                <input type="checkbox" name="remember_me" id="remember_me">
                <label for="remember_me">Remember Me</label>
            </div>
            
            <button type="submit" name="submit" class="login-btn">Login</button>
        </form>
        
        <a href="forgot_password.php" class="forgot-password">Forgot Password?</a>
        
        <form action="Login.php" method="post">
            <button type="submit" name="register" class="register-btn">Register</button>
        </form>
    </div>
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
    //redirect to registration page when register button is clicked
    if(isset($_POST["register"])){
        header("Location: Registration.php");
        exit();
    }
    //get email and password from form
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
