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
    ?>
    
    <form action = "Login.php" method = "post" enctype = "multipart/form-data">
        <label for = "email">Email: </label>
        <input type = "text" name = "email"><br><br>
        <label for = "password">Password: </label>
        <input type = "password" name = "password"><br><br>
        <button type="submit" name ="submit" >Login</button><br><br>
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

