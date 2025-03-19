<?php
if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(isset($_POST["logout"])){
        header("Location: Logout.php");
        exit();
    }
    if(isset($_POST["delete"])){
        header("Location: delete_account.php");
        exit();
    }
}
?>
<!DOCTYPE html><?php
session_start();
if(!isset($_SESSION["user_id"])) {
    header("Location: Login.php");
    exit();
}

if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(isset($_POST["logout"])){
        header("Location: Logout.php");
        exit();
    }
    if(isset($_POST["delete"])){
        header("Location: delete_account.php");
        exit();
    }
    if(isset($_POST["edit_details"])){
        header("Location: edit_details.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home page</title>
</head>
<body>
    <div class="container">
        <div class="profile-section">
            <h1 class="welcome-text">Welcome, <?php echo htmlspecialchars($_SESSION["username"]); ?>!</h1>
            <?php if(isset($_SESSION["profile_picture"])): ?>
                <img src="uploads/<?php echo htmlspecialchars($_SESSION["profile_picture"]); ?>" 
                     alt="Profile Picture" 
                     class="profile-picture">
            <?php else: ?>
                <img src="uploads/default-profile.jpg" 
                     alt="Default Profile Picture" 
                     class="profile-picture">
            <?php endif; ?>
        </div>

        <form action="Dashboard.php" method="post">
            <div class="button-group">
                <button type="submit" name="edit_details" class="edit_details">Edit Details</button>
                <button type="submit" name="logout" class="logout-btn">Logout</button>
                <button type="submit" name="delete" class="delete-btn">Delete Account</button>
            </div>
        </form>
    </div>
</body>
</html>