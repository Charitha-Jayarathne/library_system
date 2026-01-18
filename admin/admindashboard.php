<?php
session_start();
include '../db.php';

if(!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'admin'){
    header("Location: ../loging.php");
    exit();
}

// Get statistics
$total_books_query = mysqli_query($conn, "SELECT COUNT(*) as total FROM books");
$total_books = mysqli_fetch_assoc($total_books_query)['total'];

$total_users_query = mysqli_query($conn, "SELECT COUNT(*) as total FROM users WHERE role='user'");
$total_users = mysqli_fetch_assoc($total_users_query)['total'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="admin_style.css">
    <style>
        .admin-dashboard {
            min-height: 100vh;
            background-color: #e6fafa;
            padding: 0;
        }
        
        .admin-header {
            background: linear-gradient(135deg, #1e293b 0%, #334155 100%);
            color: #ffffff;
            padding: 20px 0;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        
        .admin-header-content {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .admin-header h1 {
            margin: 0;
            font-size: 28px;
            font-weight: 700;
        }
        
        .admin-header-right {
            display: flex;
            align-items: center;
            gap: 20px;
        }
        
        .admin-user {
            font-size: 16px;
        }
        
        .logout-btn {
            background: #ef4444;
            color: #ffffff;
            padding: 10px 20px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.2s ease;
        }
        
        .logout-btn:hover {
            background: #dc2626;
            transform: translateY(-2px);
        }
        
        .admin-content {
            max-width: 1400px;
            margin: 0 auto;
            padding: 40px 24px;
        }
        
        .welcome-section {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            color: #ffffff;
            padding: 40px;
            border-radius: 12px;
            margin-bottom: 40px;
            box-shadow: 0 8px 16px rgba(59, 130, 246, 0.3);
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
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 24px;
            margin-bottom: 40px;
        }
        
        .stat-card {
            background: #ffffff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(2, 8, 20, 0.08);
            border: 1px solid #eef2f7;
            transition: all 0.3s ease;
        }
        
        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 24px rgba(2, 8, 20, 0.12);
        }
        
        .stat-icon {
            font-size: 48px;
            margin-bottom: 16px;
        }
        
        .stat-label {
            font-size: 14px;
            color: #64748b;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 8px;
        }
        
        .stat-value {
            font-size: 36px;
            font-weight: 700;
            color: #1e293b;
        }
        
        .quick-actions {
            margin-bottom: 40px;
        }
        
        .section-title {
            font-size: 24px;
            font-weight: 700;
            color: #1e293b;
            margin: 0 0 24px;
        }
        
        .actions-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 24px;
        }
        
        .action-card {
            background: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(2, 8, 20, 0.08);
            border: 1px solid #eef2f7;
            transition: all 0.3s ease;
            text-decoration: none;
            display: block;
        }
        
        .action-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 24px rgba(2, 8, 20, 0.12);
            border-color: #3b82f6;
        }
        
        .action-card-header {
            padding: 24px;
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            border-bottom: 1px solid #e2e8f0;
        }
        
        .action-card-icon {
            font-size: 48px;
            margin-bottom: 16px;
        }
        
        .action-card-header h3 {
            margin: 0 0 8px;
            font-size: 22px;
            font-weight: 700;
            color: #1e293b;
        }
        
        .action-card-body {
            padding: 24px;
        }
        
        .action-card-body p {
            margin: 0;
            font-size: 15px;
            color: #64748b;
            line-height: 1.6;
        }
        
        .action-btn {
            display: inline-block;
            margin-top: 16px;
            padding: 10px 20px;
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            color: #ffffff;
            border-radius: 6px;
            font-weight: 600;
            font-size: 14px;
            transition: all 0.2s ease;
        }
        
        .action-btn:hover {
            transform: translateX(4px);
        }
        
        @media (max-width: 768px) {
            .admin-header-content {
                flex-direction: column;
                gap: 16px;
            }
            
            .stats-grid,
            .actions-grid {
                grid-template-columns: 1fr;
            }
            
            .welcome-section h2 {
                font-size: 24px;
            }
        }
    </style>
</head>
<body>
    <div class="admin-dashboard">
        <!-- Header -->
        <header class="admin-header">
            <div class="admin-header-content">
                <h1>🔐 Admin Dashboard</h1>
                <div class="admin-header-right">
                    <span class="admin-user">👤 <?php echo htmlspecialchars($_SESSION['user_name']); ?></span>
                    <a href="../logout.php" class="logout-btn">Logout</a>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <div class="admin-content">
            <!-- Welcome Section -->
            <div class="welcome-section">
                <h2>Welcome back, <?php echo htmlspecialchars($_SESSION['user_name']); ?>! 👋</h2>
                <p>Manage your library system from this central dashboard</p>
            </div>

            <!-- Statistics -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon">📚</div>
                    <div class="stat-label">Total Books</div>
                    <div class="stat-value"><?php echo $total_books; ?></div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon">👥</div>
                    <div class="stat-label">Total Users</div>
                    <div class="stat-value"><?php echo $total_users; ?></div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon">⚡</div>
                    <div class="stat-label">System Status</div>
                    <div class="stat-value" style="font-size: 24px; color: #22c55e;">Active</div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="quick-actions">
                <h2 class="section-title">Quick Actions</h2>
                <div class="actions-grid">
                    <!-- Add Book -->
                    <a href="add_book.php" class="action-card">
                        <div class="action-card-header">
                            <div class="action-card-icon">➕</div>
                            <h3>Add New Book</h3>
                        </div>
                        <div class="action-card-body">
                            <p>Add new books to the library collection. Include details like title, author, ISBN, and upload cover images.</p>
                            <span class="action-btn">Add Book →</span>
                        </div>
                    </a>

                    <!-- View Books -->
                    <a href="view_book.php" class="action-card">
                        <div class="action-card-header">
                            <div class="action-card-icon">📖</div>
                            <h3>View All Books</h3>
                        </div>
                        <div class="action-card-body">
                            <p>Browse the complete library collection. View book details, availability, and manage inventory.</p>
                            <span class="action-btn">View Books →</span>
                        </div>
                    </a>

                    <!-- Manage Users -->
                    <a href="manage_users.php" class="action-card">
                        <div class="action-card-header">
                            <div class="action-card-icon">👥</div>
                            <h3>Manage Users</h3>
                        </div>
                        <div class="action-card-body">
                            <p>View and manage all registered users. Monitor user activities and control access permissions.</p>
                            <span class="action-btn">Manage Users →</span>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>