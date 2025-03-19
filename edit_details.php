<?php
session_start();
if (!isset($_SESSION["user_id"])) {  
    header("Location: dashboard.php");
    exit();
}

$server = "localhost";
$username = "root";
$password = "";
$database = "user_management";

$conn = mysqli_connect($server, $username, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Fetch user details before showing the form
$user_id = $_SESSION["user_id"];
$sql_fetch = "SELECT username, email FROM users WHERE id='$user_id'";
$result = mysqli_query($conn, $sql_fetch);
$user = mysqli_fetch_assoc($result);

// Handle form submission
if (isset($_POST["edit_details"])) {
    $username = mysqli_real_escape_string($conn, $_POST["username"]);
    $email = mysqli_real_escape_string($conn, $_POST["email"]);
    $password = !empty($_POST["password"]) ? password_hash($_POST["password"], PASSWORD_BCRYPT) : null;

    // Update query (excluding password if left empty)
    if ($password) {
        $sql = "UPDATE users SET username='$username', email='$email', password='$password' WHERE id='$user_id'";
    } else {
        $sql = "UPDATE users SET username='$username', email='$email' WHERE id='$user_id'";
    }

    if (mysqli_query($conn, $sql)) {
        // Update session values
        $_SESSION["username"] = $username;
        $_SESSION["email"] = $email;

        header("Location: dashboard.php");
        exit();
    } else {
        echo "Error updating details: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Details</title>
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
        h2 {
            margin-bottom: 20px;
            color: #333;
        }
        form {
            background: #fff;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            width: 350px;
            text-align: center;
        }
        .container {
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            width: 350px;
            text-align: center;
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
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }
        button {
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            margin-top: 20px;
        }
        button:hover {
            background-color: #0056b3;  
        }
        .error-message {
            color: red;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <div class="container">
    <h2>Edit Details</h2>
    <form action="edit_details.php" method="POST">
        <label>Email:</label>
        <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required><br>
        
        <label>Username:</label>
        <input type="text" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required><br>
        
        <label>Password (leave blank to keep current password):</label>
        <input type="password" name="password"><br>
        
        <button type="submit" name="edit_details">Save</button>
    </form>
    </div>
</body>
</html>
