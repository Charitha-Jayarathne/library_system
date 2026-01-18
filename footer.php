    <!-- Footer -->
    <footer class="footer">
        <div class="footer-content">
            <div class="footer-grid">
                <div class="footer-section">
                    <h4>📚 Library System</h4>
                    <p>Your trusted partner in knowledge management. Providing seamless access to books and educational resources.</p>
                </div>
                <div class="footer-section">
                    <h4>Quick Links</h4>
                    <ul>
                        <li><a href="index.php">Home</a></li>
                        <li><a href="loging.php">Login</a></li>
                        <li><a href="register.php">Register</a></li>
                        <?php if(isset($_SESSION['user_id'])): ?>
                            <li><a href="dashboard.php">Dashboard</a></li>
                        <?php endif; ?>
                    </ul>
                </div>
                <div class="footer-section">
                    <h4>Support</h4>
                    <ul>
                        <li><a href="#">Help Center</a></li>
                        <li><a href="#">FAQs</a></li>
                        <li><a href="#">Contact Us</a></li>
                        <li><a href="#">Terms of Service</a></li>
                    </ul>
                </div>
                <div class="footer-section">
                    <h4>Contact Info</h4>
                    <ul>
                        <li>📧 Email: support@library.com</li>
                        <li>📞 Phone: (555) 123-4567</li>
                        <li>📍 Address: 123 Library St.</li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; <?php echo date('Y'); ?> Library Management System. All rights reserved.</p>
            </div>
        </div>
    </footer>
    
    <style>
        /* Footer Styles */
        .footer {
            background: #1e293b;
            color: #cbd5e1;
            padding: 40px 24px 20px;
            margin-top: auto;
        }
        
        .footer-content {
            max-width: 1200px;
            margin: 0 auto;
        }
        
        .footer-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 40px;
            margin-bottom: 30px;
        }
        
        .footer-section h4 {
            color: #ffffff;
            font-size: 18px;
            font-weight: 700;
            margin: 0 0 16px;
        }
        
        .footer-section p,
        .footer-section ul {
            font-size: 14px;
            line-height: 1.8;
            margin: 0;
        }
        
        .footer-section ul {
            list-style: none;
            padding: 0;
        }
        
        .footer-section ul li {
            margin-bottom: 10px;
        }
        
        .footer-section a {
            color: #cbd5e1;
            text-decoration: none;
            transition: color 0.2s ease;
        }
        
        .footer-section a:hover {
            color: #3b82f6;
        }
        
        .footer-bottom {
            border-top: 1px solid #334155;
            padding-top: 20px;
            text-align: center;
            font-size: 14px;
        }
    </style>
</body>
</html>
