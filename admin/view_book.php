<?php
session_start();
include '../db.php';

// Admin guard
if(!isset($_SESSION['user_id']) || ($_SESSION['user_role'] ?? '') !== 'admin'){
    header("Location: ../loging.php");
    exit();
}

$message = '';
$message_type = '';

// Handle return action
if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['return_id'])){
    $returnId = mysqli_real_escape_string($conn, $_POST['return_id']);

    // get book id for quantity update
    $txn = mysqli_query($conn, "SELECT book_id FROM transactions WHERE id='$returnId' AND status='borrowed'");
    if($txn && mysqli_num_rows($txn) === 1){
        $bookId = mysqli_fetch_assoc($txn)['book_id'];

        $updateTxn = mysqli_query($conn, "UPDATE transactions SET status='returned', return_date=CURDATE() WHERE id='$returnId'");
        $updateQty = mysqli_query($conn, "UPDATE books SET quantity = quantity + 1 WHERE id='$bookId'");

        if($updateTxn && $updateQty){
            $message = "Book marked as returned.";
            $message_type = 'success';
        } else {
            $message = "Error updating return.";
            $message_type = 'error';
        }
    } else {
        $message = "Transaction not found or already returned.";
        $message_type = 'error';
    }
}

// Fetch borrowed items with user info
$borrowed_sql = "SELECT t.id, t.issue_date, b.title, b.author, b.isbn, b.image, u.name as user_name, u.email
                 FROM transactions t
                 JOIN books b ON t.book_id = b.id
                 JOIN users u ON t.user_id = u.id
                 WHERE t.status = 'borrowed'
                 ORDER BY t.issue_date DESC";
$borrowed_result = mysqli_query($conn, $borrowed_sql);
if(!$borrowed_result){
    die("Error retrieving borrowed books: " . mysqli_error($conn));
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Books</title>
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="admin_style.css">
    <style>
        .manage-container { min-height: 100vh; background: #e6fafa; padding: 32px 20px; }
        .heading-row { max-width: 1200px; margin: 0 auto 20px; padding: 0 24px; display: flex; justify-content: space-between; align-items: center; }
        .message { padding: 12px 16px; border-radius: 8px; margin-bottom: 16px; font-weight: 600; max-width: 1200px; margin-left: auto; margin-right: auto; }
        .success { background: #dcfce7; color: #166534; border: 1px solid #86efac; }
        .error { background: #fee2e2; color: #991b1b; border: 1px solid #fca5a5; }
        .table-wrap { max-width: 1200px; margin: 0 auto; padding: 0 24px 24px; }
        table { width: 100%; border-collapse: collapse; background: #fff; border: 1px solid #e2e8f0; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #e2e8f0; font-size: 14px; color: #1e293b; }
        th { background: #f8fafc; text-transform: uppercase; letter-spacing: 0.5px; font-size: 13px; }
        .img-thumb { width: 60px; height: 60px; object-fit: cover; border-radius: 6px; background: #f1f5f9; }
        .btn-return { padding: 8px 12px; border: none; border-radius: 6px; background: linear-gradient(135deg, #22c55e, #16a34a); color: #fff; font-weight: 700; cursor: pointer; }
        .btn-return:hover { opacity: 0.95; }
        @media(max-width: 768px){ th, td { font-size: 13px; } }
    </style>
</head>
<body>
    <div class="manage-container">
        <div class="heading-row">
            <a href="admindashboard.php" style="display: inline-block; padding: 10px 20px; background: linear-gradient(135deg, #1e293b 0%, #334155 100%); color: #ffffff; text-decoration: none; border-radius: 6px; font-weight: 600; transition: all 0.2s ease;">← Back to Dashboard</a>
            <h1>Manage Books</h1>
        </div>

        <?php if($message): ?>
            <div class="message <?php echo $message_type; ?>"><?php echo $message; ?></div>
        <?php endif; ?>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Book</th>
                        <th>Author</th>
                        <th>ISBN</th>
                        <th>Borrower</th>
                        <th>Issued</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(mysqli_num_rows($borrowed_result) > 0): ?>
                        <?php while($row = mysqli_fetch_assoc($borrowed_result)): ?>
                            <tr>
                                <td>
                                    <div style="display:flex; align-items:center; gap:10px;">
                                        <?php if(!empty($row['image'])): ?>
                                            <img class="img-thumb" src="../images/<?php echo htmlspecialchars($row['image']); ?>" alt="<?php echo htmlspecialchars($row['title']); ?>">
                                        <?php else: ?>
                                            <div class="img-thumb" style="display:flex;align-items:center;justify-content:center;color:#94a3b8;">No Img</div>
                                        <?php endif; ?>
                                        <div><?php echo htmlspecialchars($row['title']); ?></div>
                                    </div>
                                </td>
                                <td><?php echo htmlspecialchars($row['author']); ?></td>
                                <td><?php echo htmlspecialchars($row['isbn']); ?></td>
                                <td>
                                    <div><?php echo htmlspecialchars($row['user_name']); ?></div>
                                    <div style="font-size:12px;color:#64748b;"><?php echo htmlspecialchars($row['email']); ?></div>
                                </td>
                                <td><?php echo htmlspecialchars($row['issue_date']); ?></td>
                                <td>
                                    <form method="post" onsubmit="return confirm('Mark as returned?');">
                                        <input type="hidden" name="return_id" value="<?php echo htmlspecialchars($row['id']); ?>">
                                        <button type="submit" class="btn-return">Return</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr><td colspan="6">No borrowed books.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>