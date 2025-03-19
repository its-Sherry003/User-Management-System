<?php
$server = "localhost";
$username = "root";
$password = "";
$database = "user_management";

$conn = mysqli_connect($server,$username,$password,$database);
mysqli_select_db($conn,$database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

/*$insert = "CREATE TABLE users 
            (id INT AUTO_INCREMENT PRIMARY KEY,
            username varchar(15) NOT NULL,
            email varchar(50) NOT NULL,
            password varchar(255) NOT NULL,
            profile_picture varchar(255) NOT NULL,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP)";
if(mysqli_query($conn,$insert)){
        echo "Created";
    }else{
        echo "Failed";
    }

    $password_reset = "CREATE TABLE password_reset_requests (
        id INT AUTO_INCREMENT PRIMARY KEY,
        email VARCHAR(255) NOT NULL,
        token VARCHAR(255) NOT NULL,
        expiry DATETIME NOT NULL
    )";
    if(mysqli_query($conn,$password_reset)){
        echo "Created";
    }else{
        echo "Failed";
    }*/

?>