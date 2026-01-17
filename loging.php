<?php
include 'db.php';
session_start();
if($_SERVER['REQUEST_METHOD']=='POST'){
    $email=$_POST['email'];
    $password=$_POST['password'];

    $sql="SELECT * FROM users WHERE email='$email'";

    $result= mysqli_query($conn,$sql);
    if($result ->num_rows >0){
       $row= mysqli_fetch_assoc($result);
       if($row['password']==$password){
              $_SESSION['user_id']=$row['id'];
              $_SESSION['user_name']=$row['name'];
              $_SESSION['user_role']=$row['role'];

              if($row['role']=='admin'){
                header("Location: admin/admindashboard.php");
                exit();
              }else{
                header("Location: dashboard.php");
                exit();
              }
              
         }
         else{
              echo "Invalid email or password";
         }
    }
    else{
        echo "Invalid email or password";
    }
}   
?>
<!DOCTYPE html>
<html lang="en">
<?php include 'heading.php' ?>
<body>
    <div class="register">
         <form action="loging.php" method="post">
        <h2>User Login</h2>
        <input type ="email" name="email" placeholder="Email">
        <input type ="password" name="password" placeholder="Password">
        <button type="submit">Sign In</button>
         </form>  
    </div>
 
</body>
</html>