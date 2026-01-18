<?php
session_start();
include '../db.php';
        if($_SERVER['REQUEST_METHOD']=='POST'){
            $title = $_POST['title'];
            $author = $_POST['author'];
            $isbn = $_POST['isbn'];
            $image = $_FILES['image']['name'];
            $quantity = $_POST['quantity'];

            $sql = "INSERT INTO books (title, author, isbn, image, quantity) VALUES ('$title', '$author', '$isbn', '$image', '$quantity')";
            $result = mysqli_query($conn, $sql);

            if(!$result){
                echo "Error: " . mysqli_error($conn);
            } else {
                $image_location = $_FILES['image']['tmp_name'];
                $upload_location="../images/";
                move_uploaded_file($image_location, $upload_location . $image);
                echo "Book added successfully.";
            }
        }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Book</title>
</head>
<body>
    <form action="add_book.php" method="POST" enctype="multipart/form-data">
        <h2></h2>
        <label for="title">Book Title:</label>
        <input type="text"  name="title" required><br><br>
        <label for="author">Author:</label>
        <input type="text" name="author" required><br><br>
        <label for ="isbn">ISBN:</label>
        <input type="text"  name="isbn" required><br><br>
        <label for="image">Image:</label>
        <input type="file"id="image" name="image" ><br><br>
        <label for="quantity">Quantity:</label>
        <input type="text" name="quantity" ><br><br>
        <input type="submit" value="Add Book">


    </form>
</body>
</html>