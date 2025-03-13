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

if (!isset($_SESSION["user_id"])) {
    header("Location: Login.php");
    exit();
}

$user_id = $_SESSION["user_id"];

// Get profile picture filename
$query = "SELECT profile_picture FROM users WHERE id='$user_id'";
$result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($result);
$profile_pic = "uploads/" . $user["profile_picture"];

// Delete user from database
$delete_query = "DELETE FROM users WHERE id='$user_id'";
if (mysqli_query($conn, $delete_query)) {
    // Delete profile picture
    if (file_exists($profile_pic)) {
        unlink($profile_pic);
    }
    
    session_destroy();
    echo "Account deleted successfully!";
    header("Location: Registration.php");
} else {
    echo "Error deleting account: " . mysqli_error($conn);
}
?>
