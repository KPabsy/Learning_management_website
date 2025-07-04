<?php
// Start session
session_start();

// Include functions for any cleanup if needed
require_once 'includes/functions.php';

// Check if user was logged in
$was_logged_in = isset($_SESSION['user_id']);

// Destroy all session data
session_unset();
session_destroy();

// Clear session cookie
if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time() - 3600, '/');
}

// Start new session for logout message
session_start();

// Set logout message if user was logged in
if ($was_logged_in) {
    $_SESSION['logout_message'] = 'You have been successfully logged out.';
}

// Redirect to login page
header('Location: login.php');
exit();
?>
