<?php
// Database configuration
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'lms_math2');

// Site configuration
define('SITE_NAME', 'C MATHS ASHAN SUDUSINGHA');
define('SITE_URL', 'http://localhost/lms_math2');

// Create database connection
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Start session
session_start();

// Set timezone
date_default_timezone_set('Asia/Colombo');
?>
