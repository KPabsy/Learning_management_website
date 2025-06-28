<?php
// Start session
session_start();

// Include configuration for any cleanup if needed
require_once 'includes/config.php';

// Function to log logout activity (optional)
function logLogoutActivity() {
    if (isset($_SESSION['user_id']) && isset($_SESSION['username'])) {
        $user_id = $_SESSION['user_id'];
        $username = $_SESSION['username'];
        $logout_time = date('Y-m-d H:i:s');
        
        // You can add database logging here if needed
        // For now, we'll keep it simple as requested
        
        // Optional: Log to file
        $log_message = "[{$logout_time}] User '{$username}' (ID: {$user_id}) logged out\n";
        error_log($log_message, 3, 'logs/logout.log');
    }
}

// Log the logout activity before destroying session
logLogoutActivity();

// Clear all session variables
$_SESSION = array();

// Delete the session cookie if it exists
if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time() - 3600, '/');
}

// Destroy the session
session_destroy();

// Clear any remember me cookies if they exist
if (isset($_COOKIE['remember_user'])) {
    setcookie('remember_user', '', time() - 3600, '/');
}

if (isset($_COOKIE['remember_token'])) {
    setcookie('remember_token', '', time() - 3600, '/');
}

// Prevent caching of this page
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

// Check if logout was called via AJAX
if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && 
    strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    
    // Return JSON response for AJAX requests
    header('Content-Type: application/json');
    echo json_encode([
        'success' => true,
        'message' => 'Logged out successfully',
        'redirect' => 'login.php'
    ]);
    exit();
}

// Check if there's a specific redirect parameter
$redirect_url = 'login.php';
if (isset($_GET['redirect']) && !empty($_GET['redirect'])) {
    $allowed_redirects = ['login.php', 'about.php', 'index.php'];
    $requested_redirect = $_GET['redirect'];
    
    if (in_array($requested_redirect, $allowed_redirects)) {
        $redirect_url = $requested_redirect;
    }
}

// Add success message to be displayed on login page
session_start();
$_SESSION['logout_message'] = 'You have been successfully logged out.';

// Redirect to login page or specified page
header("Location: " . $redirect_url);
exit();
?>
