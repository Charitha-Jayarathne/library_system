<?php
include 'db.php';
session_start();

if(isset($_SESSION['user_id'])){
    $user_id=$_SESSION['user_id'];
}
else{
    header("Location: loging.php");
    exit();
}

$page_title = "Dashboard - Library System";
include 'header.php';
?>

<style>
    .dashboard-container {
        min-height: calc(100vh - 400px);
        padding: 40px 24px;
    }
    
    .dashboard-content {
        max-width: 1200px;
        margin: 0 auto;
    }
    
    .welcome-section {
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        color: #ffffff;
        padding: 40px;
        border-radius: 12px;
        margin-bottom: 40px;
        box-shadow: 0 8px 16px rgba(59, 130, 246, 0.3);
        text-align: center;
    }
    
    .welcome-section h2 {
        margin: 0 0 10px;
        font-size: 32px;
        font-weight: 700;
    }
    
    .welcome-section p {
        margin: 0;
        font-size: 16px;
        opacity: 0.9;
    }
    
    .quick-actions {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 24px;
        margin-bottom: 40px;
    }
    
    .action-card {
        background: #ffffff;
        border-radius: 12px;
        padding: 32px;
        box-shadow: 0 4px 12px rgba(2, 8, 20, 0.08);
        border: 1px solid #eef2f7;
        text-decoration: none;
        display: block;
        transition: all 0.3s ease;
        text-align: center;
    }
    
    .action-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 24px rgba(2, 8, 20, 0.12);
        border-color: #3b82f6;
    }
    
    .action-icon {
        font-size: 48px;
        margin-bottom: 16px;
    }
    
    .action-card h3 {
        margin: 0 0 8px;
        font-size: 20px;
        font-weight: 700;
        color: #1e293b;
    }
    
    .action-card p {
        margin: 0;
        font-size: 14px;
        color: #64748b;
        line-height: 1.6;
    }
    
    @media (max-width: 768px) {
        .dashboard-container {
            padding: 20px 16px;
        }
        
        .welcome-section {
            padding: 24px;
        }
        
        .welcome-section h2 {
            font-size: 24px;
        }
    }
</style>

<div class="dashboard-container">
    <div class="dashboard-content">
        <!-- Welcome Section -->
        <div class="welcome-section">
            <h2>Welcome, <?php echo htmlspecialchars($_SESSION['user_name']); ?>! 👋</h2>
            <p>Explore our collection and manage your borrowed books</p>
        </div>
        
        <!-- Quick Actions -->
        <div class="quick-actions">
            <a href="borrow.php" class="action-card">
                <div class="action-icon">📖</div>
                <h3>Borrow Books</h3>
                <p>Browse and borrow books from our collection</p>
            </a>
            <a href="return.php" class="action-card">
                <div class="action-icon">↩️</div>
                <h3>Return Books</h3>
                <p>Return your borrowed books easily</p>
            </a>
            <a href="dashboard.php" class="action-card">
                <div class="action-icon">📋</div>
                <h3>My Books</h3>
                <p>View all your borrowed books history</p>
            </a>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>