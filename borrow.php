<?php
// Borrow page: list all available books and allow user to borrow
session_start();
include 'db.php';

// Normalize session keys used elsewhere in the project
$userId = $_SESSION['user_id'] ?? $_SESSION['userid'] ?? null;
$userRole = $_SESSION['user_role'] ?? $_SESSION['role'] ?? null;

if (!$userId) {
    header("Location: loging.php");
    exit();
}

// Only regular users can borrow
if ($userRole === 'admin') {
    header("Location: admin/admindashboard.php");
    exit();
}

// Handle borrow action
if (isset($_GET['book_id'])) {
    $book_id = mysqli_real_escape_string($conn, $_GET['book_id']);

    $borrowSql = "INSERT INTO transactions (user_id, book_id, issue_date, status) VALUES ('$userId', '$book_id', CURDATE(), 'borrowed')";
    $borrowResult = mysqli_query($conn, $borrowSql);

    if ($borrowResult) {
        header("Location: dashboard.php?borrow=success");
        exit();
    } else {
        $error = "Error borrowing book: " . mysqli_error($conn);
    }
}

// Fetch available books
$booksSql = "SELECT * FROM books WHERE quantity > 0 ORDER BY id DESC";
$booksResult = mysqli_query($conn, $booksSql);
if (!$booksResult) {
    die("Error retrieving books: " . mysqli_error($conn));
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Borrow Books</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; background: #e6fafa; }
        .container { max-width: 1100px; margin: 0 auto; padding: 32px 20px; }
        h1 { margin: 0 0 20px; color: #1e293b; }
        .grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(240px, 1fr)); gap: 16px; }
        .card { background: #fff; border: 1px solid #e2e8f0; border-radius: 10px; padding: 16px; box-shadow: 0 4px 12px rgba(2, 8, 20, 0.06); display: flex; flex-direction: column; }
        .img-box { width: 100%; height: 180px; border-radius: 8px; overflow: hidden; background: #f1f5f9; display: flex; align-items: center; justify-content: center; margin-bottom: 12px; }
        .img-box img { width: 100%; height: 100%; object-fit: cover; display: block; }
        .img-placeholder { color: #94a3b8; font-weight: 600; font-size: 14px; }
        .card h3 { margin: 0 0 8px; font-size: 18px; color: #1e293b; }
        .card p { margin: 4px 0; color: #475569; font-size: 14px; }
        .btn { margin-top: 12px; padding: 10px 12px; background: linear-gradient(135deg, #3b82f6, #2563eb); color: #fff; border: none; border-radius: 6px; cursor: pointer; font-weight: 600; text-align: center; text-decoration: none; }
        .btn:disabled { opacity: 0.6; cursor: not-allowed; }
        .alert { padding: 12px; border-radius: 6px; margin-bottom: 16px; }
        .alert.error { background: #fee2e2; color: #991b1b; border: 1px solid #fca5a5; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Borrow Books</h1>
        <?php if (!empty($error)): ?>
            <div class="alert error"><?php echo $error; ?></div>
        <?php endif; ?>
        <?php if (mysqli_num_rows($booksResult) > 0): ?>
            <div class="grid">
                <?php while ($book = mysqli_fetch_assoc($booksResult)): ?>
                    <div class="card">
                        <div class="img-box">
                            <?php if (!empty($book['image'])): ?>
                                <img src="images/<?php echo htmlspecialchars($book['image']); ?>" alt="<?php echo htmlspecialchars($book['title']); ?>">
                            <?php else: ?>
                                <div class="img-placeholder">No Image</div>
                            <?php endif; ?>
                        </div>
                        <h3><?php echo htmlspecialchars($book['title']); ?></h3>
                        <p><strong>Author:</strong> <?php echo htmlspecialchars($book['author']); ?></p>
                        <p><strong>ISBN:</strong> <?php echo htmlspecialchars($book['isbn']); ?></p>
                        <p><strong>Available:</strong> <?php echo htmlspecialchars($book['quantity']); ?></p>
                        <form method="get" action="borrow.php" style="margin-top:auto;">
                            <input type="hidden" name="book_id" value="<?php echo htmlspecialchars($book['id']); ?>">
                            <button type="submit" class="btn">Borrow</button>
                        </form>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php else: ?>
            <p>No books available to borrow right now.</p>
        <?php endif; ?>
    </div>
</body>
</html>