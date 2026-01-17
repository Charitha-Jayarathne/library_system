<?php
session_start();
if(isset($_SESSION['userid'])){
    if($_SESSION['user_role']=='admin'){
        // Allow access to admin dashboard
        
    }else{
        header("Location: ../dashboard.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h2>Admin Dashboard welcome, <?php echo $_SESSION['user_name']; ?></h2>
</body>
</html>