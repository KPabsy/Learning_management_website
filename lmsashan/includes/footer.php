        </div>
    </main>
    
    <footer>
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h3>Contact Information</h3>
                    <div class="contact-info">
                        <p><strong>Ashan Sudusinghe</strong></p>
                        <p>Professional Mathematics Tutor</p>
                        <p>📞 Phone: +94 77 123 4567</p>
                        <p>📧 Email: ashan.math@gmail.com</p>
                        <p>📍 Location: Colombo, Sri Lanka</p>
                    </div>
                </div>
                
                <div class="footer-section">
                    <h3>Quick Links</h3>
                    <ul class="footer-links">
                        <?php if (isLoggedIn()): ?>
                            <li><a href="dashboard.php">Dashboard</a></li>
                            <li><a href="resources.php">Study Materials</a></li>
                            <?php if (isAdmin()): ?>
                                <li><a href="admin.php">Admin Panel</a></li>
                            <?php endif; ?>
                        <?php endif; ?>
                        <li><a href="about.php">About</a></li>
                        <?php if (!isLoggedIn()): ?>
                            <li><a href="login.php">Student Login</a></li>
                        <?php endif; ?>
                    </ul>
                </div>
                
                <div class="footer-section">
                    <h3>Subjects Offered</h3>
                    <ul class="subjects-list">
                        <li>Advanced Level Mathematics</li>
                        <li>Ordinary Level Mathematics</li>
                        <li>Grade 6-11 Mathematics</li>
                        <li>Cambridge Mathematics</li>
                    </ul>
                </div>
                
                <div class="footer-section">
                    <h3>Class Schedule</h3>
                    <div class="schedule-info">
                        <p><strong>Weekdays:</strong> 4:00 PM - 8:00 PM</p>
                        <p><strong>Saturdays:</strong> 9:00 AM - 5:00 PM</p>
                        <p><strong>Sundays:</strong> 9:00 AM - 2:00 PM</p>
                        <p class="note">Individual and group classes available</p>
                    </div>
                </div>
            </div>
            
            <div class="footer-bottom">
                <div class="footer-bottom-content">
                    <p>&copy; <?php echo date('Y'); ?> Ashan Sudusinghe Mathematics Tutor. All rights reserved.</p>
                    <p class="powered-by">Learning Management System | Designed for Excellence in Mathematics Education</p>
                </div>
            </div>
        </div>
    </footer>
    
    <style>
        footer {
            background-color: #2c3e50;
            color: white;
            padding: 40px 0 20px 0;
            margin-top: 50px;
        }
        
        .footer-content {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 30px;
            margin-bottom: 30px;
        }
        
        .footer-section h3 {
            color: #3498db;
            margin-bottom: 15px;
            font-size: 1.2rem;
        }
        
        .contact-info p {
            margin-bottom: 8px;
            color: #ecf0f1;
        }
        
        .footer-links {
            list-style: none;
        }
        
        .footer-links li {
            margin-bottom: 8px;
        }
        
        .footer-links li a {
            color: #ecf0f1;
            text-decoration: none;
            transition: color 0.3s;
        }
        
        .footer-links li a:hover {
            color: #3498db;
        }
        
        .subjects-list {
            list-style: none;
        }
        
        .subjects-list li {
            margin-bottom: 8px;
            color: #ecf0f1;
            padding-left: 15px;
            position: relative;
        }
        
        .subjects-list li:before {
            content: "📚";
            position: absolute;
            left: 0;
        }
        
        .schedule-info p {
            margin-bottom: 8px;
            color: #ecf0f1;
        }
        
        .schedule-info .note {
            font-style: italic;
            color: #bdc3c7;
            margin-top: 10px;
        }
        
        .footer-bottom {
            border-top: 1px solid #34495e;
            padding-top: 20px;
        }
        
        .footer-bottom-content {
            text-align: center;
        }
        
        .footer-bottom-content p {
            color: #bdc3c7;
            margin-bottom: 5px;
        }
        
        .powered-by {
            font-size: 0.9rem;
            color: #95a5a6;
        }
        
        /* Responsive design */
        @media (max-width: 768px) {
            .header-content {
                flex-direction: column;
                gap: 20px;
            }
            
            nav ul {
                flex-wrap: wrap;
                justify-content: center;
                gap: 15px;
            }
            
            .footer-content {
                grid-template-columns: 1fr;
                text-align: center;
            }
        }
    </style>
</body>
</html>
