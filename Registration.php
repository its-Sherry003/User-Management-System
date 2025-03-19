<?php
if($_SERVER["REQUEST_METHOD"] == "POST"){

    if(isset($_POST["login"])){
        header("Location: Login.php");
        exit();
    }

    $server = "localhost";
    $username = "root";
    $password = "";
    $database = "user_management";
    
    $conn = mysqli_connect($server,$username,$password);
    mysqli_select_db($conn,$database);
    
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    
    /*$newDatabase = "CREATE DATABASE user_management";
    if(mysqli_query($conn, $newDatabase)){
        echo "Database created";
    }else{
        echo "Failed";
    }*/
    
    /*$insert = "CREATE TABLE users 
                (id INT AUTO_INCREMENT PRIMARY KEY,
                username varchar(15) NOT NULL,
                email varchar(20) NOT NULL,
                password varchar(255) NOT NULL,
                profile_picture varchar(255) NOT NULL,
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP)";
    if(mysqli_query($conn,$insert)){
        echo "Created";
    }else{
        echo "Failed";
    }*/
    //Collecting User details
    if(isset($_POST["register"])){
    $username = mysqli_real_escape_string($conn, $_POST["username"]);
    $email = mysqli_real_escape_string($conn, $_POST["email"]);
    $password = password_hash($_POST["password"], PASSWORD_BCRYPT);

    // Handle profile picture upload
    $target_dir = "uploads/";
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    $imageFileType = strtolower(pathinfo($_FILES["profile_picture"]["name"], PATHINFO_EXTENSION));
    
    if ($_FILES["profile_picture"]["size"] > 5 * 1024 * 1024) {
        die("File is too large. Max 5MB allowed.");
    }

    $allowed_types = ["jpg", "jpeg", "png"];
    if (!in_array($imageFileType, $allowed_types)) {
        die("Only JPG, JPEG, PNG files are allowed.");
    }
    // Generate a unique filename
    $profile_pic = uniqid() . "." . $imageFileType; 
    $target_file = $target_dir . $profile_pic; 

    // Move uploaded file
    if (move_uploaded_file($_FILES["profile_picture"]["tmp_name"], $target_file)) {
        // Insert into database (storing only filename)
        $sql = "INSERT INTO users (username, email, password, profile_picture)
                VALUES ('$username', '$email', '$password', '$profile_pic')";
        
        if (mysqli_query($conn, $sql)) {
            echo "Successfully Registered!";
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    } else {
        echo "Failed to upload profile picture.";
    }
}

// Close connection
    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
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
        .login-btn {
            background: #007bff;
        }
        .login-btn:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>REGISTER</h2>
        <form action="Registration.php" method="post" enctype="multipart/form-data">
            <label for="username">Username:</label>
            <input type="text" name="username" required>
            <label for="email">Email:</label>
            <input type="email" name="email" required>
            <label for="password">Password:</label>
            <input type="password" name="password" required>
            <label for="profile_picture">Profile Picture (Max: 5MB):</label>
            <input type="file" name="profile_picture" accept="image/*" required>
            <button type="submit" name="register">Register</button>
        </form>
        <form action="Registration.php" method="post">
            <button type="submit" name="login" class="login-btn">Login</button>
        </form>
    </div>
</body>
</html>
