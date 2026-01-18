<?php
session_start();
include '../db.php';

$sql="SELECT * FROM books";
$result=mysqli_query($conn,$sql);
if(!$result){
    die("Error retrieving books: " . mysqli_error($conn));
}else

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Books</title>
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="admin_style.css">
</head>
<body>
    <div class="books-container">
        <div style="max-width: 1200px; margin: 0 auto 20px; padding: 0 24px;">
            <a href="admindashboard.php" style="display: inline-block; padding: 10px 20px; background: linear-gradient(135deg, #1e293b 0%, #334155 100%); color: #ffffff; text-decoration: none; border-radius: 6px; font-weight: 600; transition: all 0.2s ease;">← Back to Dashboard</a>
        </div>
        <h1>Library Books</h1>
        <div class="books-grid">
           <?php 
                while($row= mysqli_fetch_assoc($result)) { 
           ?>
            <div class="book-card">
                <div class="book-image">
                    <?php if(!empty($row['image'])): ?>
                        <img src="../images/<?php echo htmlspecialchars($row['image']); ?>" alt="<?php echo htmlspecialchars($row['title']); ?>">
                    <?php else: ?>
                        <div class="no-image">No Image</div>
                    <?php endif; ?>
                </div>
                <div class="book-info">
                    <h3><?php echo htmlspecialchars($row['title']); ?></h3>
                    <p class="author"><strong>Author:</strong> <?php echo htmlspecialchars($row['author']); ?></p>
                    <p class="isbn"><strong>ISBN:</strong> <?php echo htmlspecialchars($row['isbn']); ?></p>
                    <p class="quantity"><strong>Quantity:</strong> <span class="qty-badge"><?php echo htmlspecialchars($row['quantity']); ?></span></p>
                </div>
            </div>
        <?php }?>
        </div>
    </div>
</body>
</html>