<?php
// Include required files
require_once 'includes/config.php';
require_once 'includes/functions.php';

// Check if user is already logged in
if (isLoggedIn()) {
    // Redirect based on user type
    if (isAdmin()) {
        header("Location: admin.php");
        exit();
    } else {
        header("Location: dashboard.php");
        exit();
    }
}

// If not logged in, show welcome page with login option
$page_title = "Welcome";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo SITE_NAME; ?> - Mathematics Tutoring</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        /* Index page specific styles */
        body {
            margin: 0;
            padding: 0;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            font-family: Arial, sans-serif;
        }
        
        .welcome-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        
        .welcome-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            padding: 50px;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            text-align: center;
            max-width: 600px;
            width: 100%;
            animation: slideUp 0.8s ease-out;
        }
        
        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .logo-section {
            margin-bottom: 30px;
        }
        
        .logo-icon {
            font-size: 4rem;
            margin-bottom: 20px;
            color: #3498db;
        }
        
        .welcome-title {
            color: #2c3e50;
            font-size: 2.5rem;
            margin-bottom: 10px;
            font-weight: bold;
        }
        
        .welcome-subtitle {
            color: #3498db;
            font-size: 1.5rem;
            margin-bottom: 20px;
            font-weight: normal;
        }
        
        .welcome-description {
            color: #7f8c8d;
            font-size: 1.1rem;
            line-height: 1.6;
            margin-bottom: 40px;
        }
        
        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 20px;
            margin-bottom: 40px;
        }
        
        .feature-item {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            border: 2px solid #e1e8ed;
            transition: all 0.3s ease;
        }
        
        .feature-item:hover {
            border-color: #3498db;
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(52, 152, 219, 0.2);
        }
        
        .feature-icon {
            font-size: 2.5rem;
            margin-bottom: 10px;
        }
        
        .feature-title {
            color: #2c3e50;
            font-size: 1rem;
            font-weight: 600;
            margin-bottom: 8px;
        }
        
        .feature-desc {
            color: #7f8c8d;
            font-size: 0.9rem;
        }
        
        .action-buttons {
            display: flex;
            gap: 20px;
            justify-content: center;
            flex-wrap: wrap;
            margin-bottom: 30px;
        }
        
        .btn {
            padding: 15px 30px;
            border: none;
            border-radius: 8px;
            font-size: 1.1rem;
            font-weight: 600;
            text-decoration: none;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-block;
        }
        
        .btn-primary {
            background: #3498db;
            color: white;
        }
        
        .btn-primary:hover {
            background: #2980b9;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(52, 152, 219, 0.3);
        }
        
        .btn-secondary {
            background: #95a5a6;
            color: white;
        }
        
        .btn-secondary:hover {
            background: #7f8c8d;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(149, 165, 166, 0.3);
        }
        
        .contact-info {
            background: #ecf0f1;
            padding: 20px;
            border-radius: 10px;
            margin-top: 20px;
        }
        
        .contact-title {
            color: #2c3e50;
            font-size: 1.2rem;
            margin-bottom: 15px;
            font-weight: 600;
        }
        
        .contact-details {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
        }
        
        .contact-item {
            color: #555;
            font-size: 0.95rem;
        }
        
        .contact-item strong {
            color: #2c3e50;
        }
        
        .footer-note {
            margin-top: 20px;
            color: #95a5a6;
            font-size: 0.9rem;
        }
        
        /* Responsive design */
        @media (max-width: 768px) {
            .welcome-card {
                padding: 30px;
                margin: 10px;
            }
            
            .welcome-title {
                font-size: 2rem;
            }
            
            .welcome-subtitle {
                font-size: 1.2rem;
            }
            
            .features-grid {
                grid-template-columns: repeat(2, 1fr);
            }
            
            .action-buttons {
                flex-direction: column;
                align-items: center;
            }
            
            .btn {
                width: 100%;
                max-width: 250px;
            }
            
            .contact-details {
                grid-template-columns: 1fr;
                text-align: center;
            }
        }
        
        @media (max-width: 480px) {
            .welcome-card {
                padding: 25px;
            }
            
            .logo-icon {
                font-size: 3rem;
            }
            
            .welcome-title {
                font-size: 1.8rem;
            }
            
            .features-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="welcome-container">
        <div class="welcome-card">
            <!-- Logo and Title Section -->
            <div class="logo-section">
                <div class="logo-icon">🎓</div>
                <h1 class="welcome-title">Ashan Sudusinghe</h1>
                <h2 class="welcome-subtitle">Mathematics Tutor</h2>
                <p class="welcome-description">
                    Welcome to our Learning Management System! Excel in mathematics with personalized tutoring, 
                    comprehensive study materials, and expert guidance for A/L, O/L, and Cambridge curricula.
                </p>
            </div>
            
            <!-- Features Section -->
            <div class="features-grid">
                <div class="feature-item">
                    <div class="feature-icon">👨‍🏫</div>
                    <div class="feature-title">Expert Tutoring</div>
                    <div class="feature-desc">8+ years experience</div>
                </div>
                
                <div class="feature-item">
                    <div class="feature-icon">📚</div>
                    <div class="feature-title">Study Materials</div>
                    <div class="feature-desc">Comprehensive resources</div>
                </div>
                
                <div class="feature-item">
                    <div class="feature-icon">📅</div>
                    <div class="feature-title">Flexible Schedule</div>
                    <div class="feature-desc">Convenient class times</div>
                </div>
                
                <div class="feature-item">
                    <div class="feature-icon">🎯</div>
                    <div class="feature-title">Exam Focused</div>
                    <div class="feature-desc">Results-oriented approach</div>
                </div>
            </div>
            
            <!-- Action Buttons -->
            <div class="action-buttons">
                <a href="login.php" class="btn btn-primary">Student Login</a>
                <a href="about.php" class="btn btn-secondary">Learn More</a>
            </div>
            
            <!-- Contact Information -->
            <div class="contact-info">
                <div class="contact-title">📞 Contact Information</div>
                <div class="contact-details">
                    <div class="contact-item">
                        <strong>Phone:</strong> +94 77 123 4567
                    </div>
                    <div class="contact-item">
                        <strong>Email:</strong> ashan.math@gmail.com
                    </div>
                    <div class="contact-item">
                        <strong>Location:</strong> Colombo, Sri Lanka
                    </div>
                    <div class="contact-item">
                        <strong>Hours:</strong> Mon-Sun, 9:00 AM - 8:00 PM
                    </div>
                </div>
            </div>
            
            <!-- Footer Note -->
            <div class="footer-note">
                <p>&copy; <?php echo date('Y'); ?> Ashan Sudusinghe Mathematics Tutor. All rights reserved.</p>
                <p>Learning Management System - Designed for Excellence in Mathematics Education</p>
            </div>
        </div>
    </div>
    
    <script>
        // Simple JavaScript for enhanced user experience
        document.addEventListener('DOMContentLoaded', function() {
            // Add hover effects to feature items
            const featureItems = document.querySelectorAll('.feature-item');
            featureItems.forEach(item => {
                item.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-5px) scale(1.02)';
                });
                
                item.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0) scale(1)';
                });
            });
            
            // Add click tracking for buttons
            const buttons = document.querySelectorAll('.btn');
            buttons.forEach(button => {
                button.addEventListener('click', function() {
                    console.log('Button clicked: ' + this.textContent);
                });
            });
            
            // Add welcome animation delay for better effect
            const welcomeCard = document.querySelector('.welcome-card');
            welcomeCard.style.opacity = '0';
            welcomeCard.style.transform = 'translateY(30px)';
            
            setTimeout(() => {
                welcomeCard.style.transition = 'all 0.8s ease-out';
                welcomeCard.style.opacity = '1';
                welcomeCard.style.transform = 'translateY(0)';
            }, 200);
        });
        
        // Auto-redirect logged in users (backup check)
        <?php if (isLoggedIn()): ?>
            setTimeout(function() {
                <?php if (isAdmin()): ?>
                    window.location.href = 'admin.php';
                <?php else: ?>
                    window.location.href = 'dashboard.php';
                <?php endif; ?>
            }, 100);
        <?php endif; ?>
    </script>
</body>
</html>
