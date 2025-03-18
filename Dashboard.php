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
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        .profile-section {
            text-align: center;
            margin-bottom: 30px;
        }
        .profile-picture {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 15px;
            border: 3px solid #007bff;
        }
        .welcome-text {
            font-size: 24px;
            color: #333;
            margin-bottom: 20px;
        }
        .button-group {
            display: flex;
            gap: 10px;
            justify-content: center;
        }
        button {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
        }
        .logout-btn {
            background: #dc3545;
            color: white;
        }
        .logout-btn:hover {
            background: #c82333;
        }
        .delete-btn {
            background: #6c757d;
            color: white;
        }
        .delete-btn:hover {
            background: #5a6268;
        }
    </style>
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
                <button type="submit" name="logout" class="logout-btn">Logout</button>
                <button type="submit" name="delete" class="delete-btn">Delete Account</button>
            </div>
        </form>
    </div>
</body>
</html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home page</title>
</head>
<body>
    <h4>This is the Home page</h4><br><br>
    <form action = "Dashboard.php" method = "post">
    <button type = "submit" name = "logout">Logout</button><br>
    <button type = "submit" name = "delete" >Delete Account</button>
    </form>
</body>
</html>