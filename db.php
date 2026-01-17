<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "librarydb";
$conn = new mysqli($servername, $username, $password, $database);

if(!$conn){
    echo "oops!:{$conn->cnnect_error}";
}
else{
    echo "connected successfully";
}
?>