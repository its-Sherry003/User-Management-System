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
<!DOCTYPE html>
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