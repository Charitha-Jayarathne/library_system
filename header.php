<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($page_title) ? $page_title : 'Library Management System'; ?></title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            margin: 0;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen, Ubuntu, Cantarell, "Fira Sans", "Droid Sans", "Helvetica Neue", Arial, sans-serif;
            background-color: #e6fafa;
        }
        
        /* Header Styles */
        .header {
            background: linear-gradient(135deg, #1e293b 0%, #334155 100%);
            color: #ffffff;
            padding: 20px 0;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        
        .header-content {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .logo h1 {
            margin: 0;
            font-size: 28px;
            font-weight: 700;
        }
        
        .logo p {
            margin: 5px 0 0;
            font-size: 14px;
            color: #cbd5e1;
        }
        
        .nav-links {
            display: flex;
            gap: 24px;
            align-items: center;
        }
        
        .nav-links a {
            color: #ffffff;
            text-decoration: none;
            font-size: 16px;
            font-weight: 500;
            transition: all 0.2s ease;
            padding: 8px 16px;
            border-radius: 6px;
        }
        
        .nav-links a:hover {
            background: rgba(255, 255, 255, 0.1);
        }
        
        .nav-links .btn-primary {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            padding: 10px 20px;
        }
        
        .nav-links .btn-primary:hover {
            background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.4);
        }
        
        @media (max-width: 768px) {
            .header-content {
                flex-direction: column;
                gap: 20px;
            }
            
            .nav-links {
                flex-wrap: wrap;
                justify-content: center;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header class="header">
        <div class="header-content">
            <div class="logo">
                <h1>📚 Library System</h1>
                <p>Your Gateway to Knowledge</p>
            </div>
            <nav class="nav-links">
                <a href="index.php">Home</a>
                <?php if(isset($_SESSION['user_id'])): ?>
                    <a href="dashboard.php">Dashboard</a>
                    <a href="logout.php">Logout</a>
                <?php else: ?>
                    <a href="loging.php">Login</a>
                    <a href="register.php" class="btn-primary">Sign Up</a>
                <?php endif; ?>
            </nav>
        </div>
    </header>
