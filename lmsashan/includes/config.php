<?php
// Database configuration
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'lmsashanmath');

// Site configuration
define('SITE_NAME', 'Ashan Sudusinghe Mathematics Tutor');
define('SITE_URL', 'http://localhost/lmsashan');

// Start session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Database connection function
function getDBConnection() {
    try {
        $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        
        return $conn;
    } catch (Exception $e) {
        die("Database connection error: " . $e->getMessage());
    }
}

// Test database connection
$conn = getDBConnection();
if ($conn) {
    // Connection successful
    $conn->close();
}
?>
