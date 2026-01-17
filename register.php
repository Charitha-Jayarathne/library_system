<?php
include 'db.php';

if($_SERVER['REQUEST_METHOD']=='POST'){
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    $sql = "INSERT INTO users (name,email,password,role) VALUES ('$name','$email','$password','$role')";
    $result= mysqli_query($conn, $sql);

    if(!$result){
        echo "Error :" . mysqli_error($conn);

    }
    else{
        echo "User registered successfully";
}
}
?>
<!DOCTYPE html>
<html lang="en">
<?php include 'heading.php' ?>
<body>
    <div class="register">
         <form action="register.php" method="post">
        <h2>User Register</h2>
        <input type ="text" name="name" placeholder="Name">
        <input type ="email" name="email" placeholder="Email">
        <input type ="password" name="password" placeholder="Password">
        <input type ="text" name="role" value="user" hidden>
        <button type="submit">Sign Up</button>

         </form>  
    </div>
 
</body>
</html>