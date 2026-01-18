<?php
session_start();
include '../db.php';
$message = "";
$message_type = "";

if($_SERVER['REQUEST_METHOD']=='POST'){
    $title = $_POST['title'];
    $author = $_POST['author'];
    $isbn = $_POST['isbn'];
    $image = $_FILES['image']['name'];
    $quantity = $_POST['quantity'];

    $sql = "INSERT INTO books (title, author, isbn, image, quantity) VALUES ('$title', '$author', '$isbn', '$image', '$quantity')";
    $result = mysqli_query($conn, $sql);

    if(!$result){
        $message = "Error: " . mysqli_error($conn);
        $message_type = "error";
    } else {
        $image_location = $_FILES['image']['tmp_name'];
        $upload_location="../images/";
        move_uploaded_file($image_location, $upload_location . $image);
        $message = "Book added successfully!";
        $message_type = "success";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Book</title>
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="admin_style.css">
</head>
<body>
    <div class="add-book-container">
        <div style="width: 100%; max-width: 500px; margin-bottom: 20px;">
            <a href="admindashboard.php" style="display: inline-block; padding: 10px 20px; background: linear-gradient(135deg, #1e293b 0%, #334155 100%); color: #ffffff; text-decoration: none; border-radius: 6px; font-weight: 600; transition: all 0.2s ease;">← Back to Dashboard</a>
        </div>
        <form action="add_book.php" method="POST" enctype="multipart/form-data" class="add-book-form">
            <h2>Add New Book</h2>
            <?php if($message): ?>
                <div class="message <?php echo $message_type; ?>">
                    <?php echo $message; ?>
                </div>
            <?php endif; ?>
            <div class="form-group">
                <label for="title">Book Title:</label>
                <input type="text" id="title" name="title" required>
            </div>
            <div class="form-group">
                <label for="author">Author:</label>
                <input type="text" id="author" name="author" required>
            </div>
            <div class="form-group">
                <label for="isbn">ISBN:</label>
                <input type="text" id="isbn" name="isbn" required>
            </div>
            <div class="form-group">
                <label for="image">Book Image:</label>
                <input type="file" id="image" name="image" accept="image/*">
            </div>
            <div class="form-group">
                <label for="quantity">Quantity:</label>
                <input type="text" id="quantity" name="quantity" required>
            </div>
            <input type="submit" value="Add Book" class="btn-submit">
        </form>
    </div>
</body>
</html>