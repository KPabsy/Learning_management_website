<?php
// Include functions if not already included
if (!function_exists('is_logged_in')) {
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
        }
        
        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }        
        
        .logo h1 {
            font-size: 1.5rem;
        }
        
        nav ul {
            list-style: none;
            display: flex;
            gap: 20px;
        }
        
        nav a {
            color: white;
            text-decoration: none;
            padding: 8px 15px;
            border-radius: 4px;
            transition: background-color 0.3s;
        }
        
        nav a:hover {
            background-color: #34495e;
        }
        
        .user-info {
            color: #ecf0f1;
            font-size: 0.9rem;
        }
        
        main {
            min-height: 70vh;
            padding: 20px 0;
        }
        
        .message {
            padding: 10px;
            margin: 10px 0;
            border-radius: 4px;
        }
        
        .message.success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        
        .message.error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .logoimg{
            padding-right: 80px;
        }
    </style>
</head>
<body>
    <header>
        <div class="container">
            <div class="header-content">
                
                <div class="logo">
                    <h1><?php echo SITE_NAME; ?></h1>
                </div>
                
                <nav>
                    <ul>
                        <?php if (is_logged_in()): ?>
                            <li><a href="dashboard.php">Dashboard</a></li>
                            <li><a href="resources.php">Resources</a></li>
                            <li><a href="about.php">About</a></li>
                            <?php if (is_admin()): ?>
                                <li><a href="admin.php">Admin</a></li>
                            <?php endif; ?>
                            <li><a href="logout.php">Logout</a></li>
                        <?php else: ?>
                            <li><a href="login.php">Login</a></li>
                            <li><a href="about.php">About</a></li>
                        <?php endif; ?>
                    </ul>
                </nav>
                
                <?php if (is_logged_in()): ?>
                    <div class="user-info">
                        Welcome, <?php echo htmlspecialchars($_SESSION['full_name']); ?>
                        (<?php echo ucfirst($_SESSION['role']); ?>)
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </header>
    
    <main>
        <div class="container">
