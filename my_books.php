<?php
session_start();
include 'db.php';

$userId = $_SESSION['user_id'] ?? $_SESSION['userid'] ?? null;
$userRole = $_SESSION['user_role'] ?? $_SESSION['role'] ?? null;

if(!$userId){
    header("Location: loging.php");
    exit();
}

if($userRole === 'admin'){
    header("Location: admin/admindashboard.php");
    exit();
}

$userIdSafe = mysqli_real_escape_string($conn, $userId);

$booksSql = "SELECT t.id, t.status, t.issue_date, t.return_date, b.title, b.author, b.isbn, b.image
             FROM transactions t
             JOIN books b ON t.book_id = b.id
             WHERE t.user_id = '$userIdSafe'
             ORDER BY t.issue_date DESC";
$booksResult = mysqli_query($conn, $booksSql);
if(!$booksResult){
    die("Error retrieving your books: " . mysqli_error($conn));
}

$page_title = "My Books - Library System";
include 'header.php';
?>

<style>
    .page-container { min-height: calc(100vh - 400px); padding: 40px 24px; }
    .page-content { max-width: 1200px; margin: 0 auto; }
    .page-title { margin: 0 0 20px; font-size: 28px; font-weight: 700; color: #1e293b; }

    .books-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(260px, 1fr)); gap: 16px; }
    .book-card { background: #fff; border: 1px solid #e2e8f0; border-radius: 10px; padding: 16px; box-shadow: 0 4px 12px rgba(2, 8, 20, 0.06); display: flex; flex-direction: column; }
    .book-img { width: 100%; height: 170px; border-radius: 8px; overflow: hidden; background: #f1f5f9; display: flex; align-items: center; justify-content: center; margin-bottom: 12px; }
    .book-img img { width: 100%; height: 100%; object-fit: cover; }
    .img-placeholder { color: #94a3b8; font-weight: 600; font-size: 14px; }
    .book-card h4 { margin: 0 0 6px; font-size: 17px; color: #1e293b; }
    .book-card p { margin: 4px 0; font-size: 14px; color: #475569; }

    .badge { align-self: flex-start; padding: 4px 10px; border-radius: 999px; font-size: 12px; font-weight: 700; margin-top: 8px; color: #fff; }
    .badge.borrowed { background: linear-gradient(135deg, #22c55e, #16a34a); }
    .badge.returned { background: linear-gradient(135deg, #3b82f6, #2563eb); }
    .badge.other { background: #64748b; }

    .empty-state { background: #fff; border: 1px solid #e2e8f0; border-radius: 10px; padding: 24px; text-align: center; color: #64748b; box-shadow: 0 4px 12px rgba(2, 8, 20, 0.06); }

    @media (max-width: 768px) {
        .page-container { padding: 20px 16px; }
    }
</style>

<div class="page-container">
    <div class="page-content">
        <h2 class="page-title">My Books</h2>

        <?php if(mysqli_num_rows($booksResult) > 0): ?>
            <div class="books-grid">
                <?php while($b = mysqli_fetch_assoc($booksResult)): 
                    $status = strtolower($b['status']);
                    $badgeClass = 'other';
                    if($status === 'borrowed') $badgeClass = 'borrowed';
                    if($status === 'returned') $badgeClass = 'returned';
                ?>
                    <div class="book-card">
                        <div class="book-img">
                            <?php if(!empty($b['image'])): ?>
                                <img src="images/<?php echo htmlspecialchars($b['image']); ?>" alt="<?php echo htmlspecialchars($b['title']); ?>">
                            <?php else: ?>
                                <div class="img-placeholder">No Image</div>
                            <?php endif; ?>
                        </div>
                        <h4><?php echo htmlspecialchars($b['title']); ?></h4>
                        <p><strong>Author:</strong> <?php echo htmlspecialchars($b['author']); ?></p>
                        <p><strong>ISBN:</strong> <?php echo htmlspecialchars($b['isbn']); ?></p>
                        <p><strong>Issued:</strong> <?php echo htmlspecialchars($b['issue_date']); ?></p>
                        <?php if(!empty($b['return_date'])): ?>
                            <p><strong>Returned:</strong> <?php echo htmlspecialchars($b['return_date']); ?></p>
                        <?php endif; ?>
                        <span class="badge <?php echo $badgeClass; ?>"><?php echo ucfirst(htmlspecialchars($status)); ?></span>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php else: ?>
            <div class="empty-state">You have not borrowed any books yet.</div>
        <?php endif; ?>
    </div>
</div>

<?php include 'footer.php'; ?>
