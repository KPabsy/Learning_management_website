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
        $user = get_user_by_username($username);
        
        if ($user && verify_password($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['full_name'] = $user['full_name'];
            $_SESSION['role'] = $user['role'];
            
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

<div class="login-content">
    <div class="login-box">
        <div class="login-header">
            <h2>Login to Your Account</h2>
            <p>Welcome to LMS</p>
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
    </div>
</div>

<!-- Tutor image at bottom-left -->
<img src="resources/02.png" alt="Tutor Image" class="bottom-left-img">

<script src="js/main.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('.login-form');
    const username = document.getElementById('username');
    const password = document.getElementById('password');
    
    form.addEventListener('submit', function(e) {
        let isValid = true;
        
        if (username.value.trim() === '') {
            username.style.borderColor = '#e74c3c';
            isValid = false;
        } else {
            username.style.borderColor = '#ddd';
        }
        
        if (password.value.trim() === '') {
            password.style.borderColor = '#e74c3c';
            isValid = false;
        } else {
            password.style.borderColor = '#ddd';
        }
        
        if (!isValid) {
            e.preventDefault();
            alert('Please fill in all required fields.');
        }
    });
});
</script>

<?php require_once 'includes/footer.php'; ?>

<style>
body {
    background: linear-gradient(135deg, rgb(10, 73, 129) 0%, #764ba2 100%);
    min-height: 100vh;
    display: flex;
    flex-direction: column;
    margin: 0;
}

main {
    flex: 1;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 20px;
}

.login-content {
    display: flex;
    justify-content: center;
    align-items: center;
    flex: 1;
    padding: 20px;
}

.login-box {
    background: white;
    border-radius: 10px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
    overflow: hidden;
    animation: slideIn 0.5s ease-out;
    max-width: 450px;
    width: 100%;
}

@keyframes slideIn {
    from {
        opacity: 0;
        transform: translateY(-30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.login-header {
    background: #2c3e50;
    color: white;
    padding: 30px;
    text-align: center;
}

.login-header h2 {
    margin: 0 0 10px 0;
    font-size: 1.8rem;
}

.login-header p {
    margin: 0;
    opacity: 0.9;
    font-size: 0.9rem;
}

.login-form {
    padding: 30px;
}

.form-group {
    margin-bottom: 20px;
}

.form-group label {
    display: block;
    margin-bottom: 8px;
    font-weight: bold;
    color: #2c3e50;
}

.form-group input {
    width: 100%;
    padding: 12px;
    border: 2px solid #ddd;
    border-radius: 6px;
    font-size: 16px;
    transition: border-color 0.3s, box-shadow 0.3s;
}

.form-group input:focus {
    outline: none;
    border-color: #3498db;
    box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.1);
}

.btn-login {
    width: 100%;
    padding: 12px;
    background: #3498db;
    color: white;
    border: none;
    border-radius: 6px;
    font-size: 16px;
    font-weight: bold;
    cursor: pointer;
    transition: background-color 0.3s, transform 0.2s;
}

.btn-login:hover {
    background: #2980b9;
    transform: translateY(-2px);
}

.btn-login:active {
    transform: translateY(0);
}

.message {
    margin: 0 30px 20px 30px;
    padding: 12px;
    border-radius: 6px;
    font-size: 0.9rem;
}

.message.error {
    background: #f8d7da;
    color: #721c24;
    border: 1px solid #f5c6cb;
}

.message.success {
    background: #d4edda;
    color: #155724;
    border: 1px solid #c3e6cb;
}

.bottom-left-img {
    padding-bottom: 66px;    
    position: absolute;
    bottom: 0px;
    left: 10px;
    width: 300px;
    z-index: 1;
}

/* Responsive design */
@media (max-width: 768px) {
    .login-header {
        padding: 20px;
    }
    .login-header h2 {
        font-size: 1.5rem;
    }
    .login-form {
        padding: 20px;
    }
}

@media (max-width: 480px) {
    .login-header {
        padding: 15px;
    }
    .login-form {
        padding: 15px;
    }
    .form-group input {
        padding: 10px;
        font-size: 14px;
    }
    .btn-login {
        padding: 10px;
        font-size: 14px;
    }
}
</style>
