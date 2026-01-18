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
<?php include '../heading.php' ?>

<body>
    <h2>Admin Dashboard welcome, <?php echo $_SESSION['user_name']; ?></h2>
    <a href="../logout.php">Logout</a>
    <br>
    <a href="add_book.php">Add New Book</a>
</body>
</html>