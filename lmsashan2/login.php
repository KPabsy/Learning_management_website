<?php
$page_title = "Login";
require_once 'includes/functions.php';

// Redirect if already logged in
if (is_logged_in()) {
    if (is_admin()) {
        header('Location: admin.php');
    } else {
        header('Location: dashboard.php');
    }
    exit();
}

$error_message = '';
$success_message = '';

// Handle login form submission
if ($_POST) {
    $username = clean_input($_POST['username']);
    $password = clean_input($_POST['password']);
    
    if (empty($username) || empty($password)) {
        $error_message = "Please enter both username and password.";
    } else {
        // Get user from database
        $user = get_user_by_username($username);
        
        if ($user && verify_password($password, $user['password'])) {
            // Set session variables
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['full_name'] = $user['full_name'];
            $_SESSION['role'] = $user['role'];
            
            // Redirect based on role
            if ($user['role'] == 'admin') {
                header('Location: admin.php');
            } else {
                header('Location: dashboard.php');
            }
            exit();
        } else {
            $error_message = "Invalid username or password.";
        }
    }
}

require_once 'includes/header.php';
?>

<link rel="stylesheet" href="css/login.css">

<div class="login-container">
    <div class="login-box">
        <div class="login-header">
            <h2>Login to Your Account</h2>
            <p>Welcome to Ashan Sudusinghe Mathematics Tutor</p>
        </div>
        
        <?php if ($error_message): ?>
            <div class="message error"><?php echo $error_message; ?></div>
        <?php endif; ?>
        
        <?php if ($success_message): ?>
            <div class="message success"><?php echo $success_message; ?></div>
        <?php endif; ?>
        
        <form method="POST" action="login.php" class="login-form">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required 
                       value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>">
            </div>
            
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            
            <button type="submit" class="btn btn-login">Login</button>
        </form>
        
        <div class="login-info">
            <h3>Demo Accounts</h3>
            <div class="demo-accounts">
                <div class="demo-account">
                    <strong>Admin Account:</strong><br>
                    Username: admin<br>
                    Password: admin123
                </div>
                <div class="demo-account">
                    <strong>Student Account:</strong><br>
                    Username: student1<br>
                    Password: student123
                </div>
            </div>
        </div>
        
        <div class="login-footer">
            <p>Need help? Contact Ashan Sudusinghe</p>
            <p>Email: ashan@mathtutor.com | Phone: +94 77 123 4567</p>
        </div>
    </div>
</div>

<script src="js/main.js"></script>
<script>
// Simple form validation
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('.login-form');
    const username = document.getElementById('username');
    const password = document.getElementById('password');
    
    form.addEventListener('submit', function(e) {
        let isValid = true;
        
        // Check username
        if (username.value.trim() === '') {
            username.style.borderColor = '#e74c3c';
            isValid = false;
        } else {
            username.style.borderColor = '#ddd';
        }
        
        // Check password
        if (password.value.trim() === '') {
            password.style.borderColor = '#e74c3c';
            isValid = false;
        } else {
            password.style.borderColor = '#ddd';
        }
        
        if (!isValid) {
            e.preventDefault();
            showMessage('Please fill in all required fields.', 'error');
        }
    });
});
</script>

<?php require_once 'includes/footer.php'; ?>
