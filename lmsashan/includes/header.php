<?php
// Include functions if not already included
if (!function_exists('isLoggedIn')) {
    require_once 'functions.php';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($page_title) ? $page_title . ' - ' . SITE_NAME : SITE_NAME; ?></title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f4f4f4;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }
        
        header {
            background-color: #2c3e50;
            color: white;
            padding: 1rem 0;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        
        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .logo h1 {
            font-size: 1.5rem;
            color: #3498db;
        }
        
        .logo p {
            font-size: 0.9rem;
            color: #ecf0f1;
            margin-top: 5px;
        }
        
        nav ul {
            list-style: none;
            display: flex;
            gap: 30px;
        }
        
        nav ul li a {
            color: white;
            text-decoration: none;
            padding: 10px 15px;
            border-radius: 5px;
            transition: background-color 0.3s;
        }
        
        nav ul li a:hover {
            background-color: #34495e;
        }
        
        nav ul li a.active {
            background-color: #3498db;
        }
        
        .user-info {
            color: #ecf0f1;
            font-size: 0.9rem;
        }
        
        .user-info a {
            color: #e74c3c;
            text-decoration: none;
            margin-left: 10px;
        }
        
        .user-info a:hover {
            text-decoration: underline;
        }
        
        main {
            min-height: calc(100vh - 200px);
            padding: 30px 0;
        }
        
        .page-header {
            background-color: white;
            padding: 20px;
            margin-bottom: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        
        .page-header h2 {
            color: #2c3e50;
            font-size: 2rem;
            margin-bottom: 10px;
        }
        
        .page-header p {
            color: #7f8c8d;
            font-size: 1.1rem;
        }
    </style>
</head>
<body>
    <header>
        <div class="container">
            <div class="header-content">
                <div class="logo">
                    <h1>Ashan Sudusinghe</h1>
                    <p>Mathematics Tutor</p>
                </div>
                
                <nav>
                    <ul>
                        <?php if (isLoggedIn()): ?>
                            <li><a href="dashboard.php" <?php echo (basename($_SERVER['PHP_SELF']) == 'dashboard.php') ? 'class="active"' : ''; ?>>Dashboard</a></li>
                            <?php if (isAdmin()): ?>
                                <li><a href="admin.php" <?php echo (basename($_SERVER['PHP_SELF']) == 'admin.php') ? 'class="active"' : ''; ?>>Admin Panel</a></li>
                            <?php endif; ?>
                            <li><a href="resources.php" <?php echo (basename($_SERVER['PHP_SELF']) == 'resources.php') ? 'class="active"' : ''; ?>>Resources</a></li>
                            <li><a href="about.php" <?php echo (basename($_SERVER['PHP_SELF']) == 'about.php') ? 'class="active"' : ''; ?>>About</a></li>
                        <?php else: ?>
                            <li><a href="about.php" <?php echo (basename($_SERVER['PHP_SELF']) == 'about.php') ? 'class="active"' : ''; ?>>About</a></li>
                            <li><a href="login.php" <?php echo (basename($_SERVER['PHP_SELF']) == 'login.php') ? 'class="active"' : ''; ?>>Login</a></li>
                        <?php endif; ?>
                    </ul>
                </nav>
                
                <?php if (isLoggedIn()): ?>
                    <div class="user-info">
                        Welcome, <?php echo htmlspecialchars($_SESSION['fullname']); ?>
                        <a href="?logout=1">Logout</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </header>
    
    <main>
        <div class="container">
            <?php
            // Handle logout
            if (isset($_GET['logout'])) {
                logout();
            }
            ?>
