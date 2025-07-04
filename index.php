<?php
// Start session and include necessary functions
require_once 'includes/functions.php';

// Check if user is logged in and redirect accordingly
if (is_logged_in()) {
    // User is logged in, redirect based on role
    if (is_admin()) {
        // Admin user - redirect to admin dashboard
        header('Location: admin.php');
        exit();
    } else {
        // Regular student - redirect to student dashboard
        header('Location: dashboard.php');
        exit();
    }
} else {
    // User is not logged in - redirect to login page
    header('Location: login.php');
    exit();
}
?>
