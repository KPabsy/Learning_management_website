<?php
// Include configuration and functions
require_once 'includes/config.php';
require_once 'includes/functions.php';

// Redirect if already logged in
if (isLoggedIn()) {
    if (isAdmin()) {
        header("Location: admin.php");
    } else {
        header("Location: dashboard.php");
    }
    exit();
}

$error_message = '';
$success_message = '';

// Handle login form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = cleanInput($_POST['username']);
    $password = cleanInput($_POST['password']);
    
    // Basic validation
    if (empty($username) || empty($password)) {
        $error_message = "Please enter both username and password.";
    } else {
        // Attempt authentication
        if (authenticateUser($username, $password)) {
            // Redirect based on user type
            if (isAdmin()) {
                header("Location: admin.php");
            } else {
                header("Location: dashboard.php");
            }
            exit();
        } else {
            $error_message = "Invalid username or password. Please try again.";
        }
    }
}

$page_title = "Login";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title . ' - ' . SITE_NAME; ?></title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/login.css">
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <div class="login-header">
                <h1>Ashan Sudusinghe</h1>
                <h2>Mathematics Tutor</h2>
                <p>Student Learning Management System</p>
            </div>
            
            <?php if (!empty($error_message)): ?>
                <div class="alert alert-error">
                    <?php echo htmlspecialchars($error_message); ?>
                </div>
            <?php endif; ?>
            
            <?php if (!empty($success_message)): ?>
                <div class="alert alert-success">
                    <?php echo htmlspecialchars($success_message); ?>
                </div>
            <?php endif; ?>
            
            <form method="POST" action="login.php" class="login-form" id="loginForm">
                <div class="form-group">
                    <label for="username" class="form-label">Username</label>
                    <input 
                        type="text" 
                        id="username" 
                        name="username" 
                        class="form-control" 
                        required
                        value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>"
                        placeholder="Enter your username"
                    >
                </div>
                
                <div class="form-group">
                    <label for="password" class="form-label">Password</label>
                    <div class="password-input-group">
                        <input 
                            type="password" 
                            id="password" 
                            name="password" 
                            class="form-control" 
                            required
                            placeholder="Enter your password"
                        >
                        <button type="button" class="password-toggle" onclick="togglePassword()">👁️</button>
                    </div>
                </div>
                
                <button type="submit" class="btn btn-login">Login</button>
            </form>
            
            <div class="login-info">
                <h3>Demo Login Credentials</h3>
                <div class="demo-credentials">
                    <div class="credential-box">
                        <strong>Admin Login:</strong><br>
                        Username: admin<br>
                        Password: admin123
                    </div>
                    <div class="credential-box">
                        <strong>Student Login:</strong><br>
                        Username: student1<br>
                        Password: student123
                    </div>
                </div>
            </div>
            
            <div class="login-footer">
                <p>Need help? Contact: <strong>+94 77 123 4567</strong></p>
                <p>Email: <strong>ashan.math@gmail.com</strong></p>
                <p><a href="about.php">Learn more about our tutoring services</a></p>
            </div>
        </div>
    </div>
    
    <script src="js/main.js"></script>
    <script>
        // Toggle password visibility
        function togglePassword() {
            const passwordField = document.getElementById('password');
            const toggleButton = document.querySelector('.password-toggle');
            
            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                toggleButton.textContent = '🙈';
            } else {
                passwordField.type = 'password';
                toggleButton.textContent = '👁️';
            }
        }
        
        // Form validation
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            const username = document.getElementById('username').value.trim();
            const password = document.getElementById('password').value.trim();
            
            if (username === '' || password === '') {
                e.preventDefault();
                alert('Please fill in all fields.');
                return false;
            }
            
            if (username.length < 3) {
                e.preventDefault();
                alert('Username must be at least 3 characters long.');
                return false;
            }
            
            if (password.length < 6) {
                e.preventDefault();
                alert('Password must be at least 6 characters long.');
                return false;
            }
        });
        
        // Auto-fill demo credentials
        function fillDemoCredentials(type) {
            if (type === 'admin') {
                document.getElementById('username').value = 'admin';
                document.getElementById('password').value = 'admin123';
            } else {
                document.getElementById('username').value = 'student1';
                document.getElementById('password').value = 'student123';
            }
        }
        
        // Add click events to demo credential boxes
        document.querySelectorAll('.credential-box').forEach((box, index) => {
            box.style.cursor = 'pointer';
            box.addEventListener('click', function() {
                if (index === 0) {
                    fillDemoCredentials('admin');
                } else {
                    fillDemoCredentials('student');
                }
            });
        });
    </script>
</body>
</html>
