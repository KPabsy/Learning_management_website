<?php
// Include config file
require_once 'config.php';

// Simple function to clean input data
function clean_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Check if user is logged in
function is_logged_in() {
    return isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
}

// Check if user is admin
function is_admin() {
    return isset($_SESSION['role']) && $_SESSION['role'] == 'admin';
}

// Redirect to login if not logged in
function require_login() {
    if (!is_logged_in()) {
        header('Location: login.php');
        exit();
    }
}

// Redirect to login if not admin
function require_admin() {
    if (!is_admin()) {
        header('Location: login.php');
        exit();
    }
}

// Simple password hashing
// Simple password verification (NO HASHING)
function verify_password($password, $stored_password) {
    return $password === $stored_password;
}

// Simple password storage (NO HASHING)
function hash_password($password) {
    return $password; // Return plain text password
}


// Verify password


// Get user by username
function get_user_by_username($username) {
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}

// Get all classes
function get_all_classes() {
    global $conn;
    $result = $conn->query("SELECT * FROM classes ORDER BY created_at DESC");
    return $result->fetch_all(MYSQLI_ASSOC);
}

// Get all materials
function get_all_materials() {
    global $conn;
    $result = $conn->query("SELECT m.*, c.class_name FROM materials m LEFT JOIN classes c ON m.class_id = c.id ORDER BY m.uploaded_at DESC");
    return $result->fetch_all(MYSQLI_ASSOC);
}

// Get approved testimonials
function get_approved_testimonials() {
    global $conn;
    $result = $conn->query("SELECT * FROM testimonials WHERE is_approved = 1 ORDER BY created_at DESC");
    return $result->fetch_all(MYSQLI_ASSOC);
}

// Add new user
function add_user($username, $password, $email, $full_name, $role = 'student') {
    global $conn;
    $hashed_password = hash_password($password);
    $stmt = $conn->prepare("INSERT INTO users (username, password, email, full_name, role) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $username, $hashed_password, $email, $full_name, $role);
    return $stmt->execute();
}

// Add new class
function add_class($class_name, $description, $teacher_name, $schedule) {
    global $conn;
    $stmt = $conn->prepare("INSERT INTO classes (class_name, description, teacher_name, schedule) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $class_name, $description, $teacher_name, $schedule);
    return $stmt->execute();
}

// Add new material
function add_material($title, $description, $material_type, $class_id, $file_path = null) {
    global $conn;
    $stmt = $conn->prepare("INSERT INTO materials (title, description, material_type, class_id, file_path) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssis", $title, $description, $material_type, $class_id, $file_path);
    return $stmt->execute();
}

// Get all users
function get_all_users() {
    global $conn;
    $result = $conn->query("SELECT id, username, email, full_name, role, created_at FROM users ORDER BY created_at DESC");
    return $result->fetch_all(MYSQLI_ASSOC);
}

// Simple success message display
function show_message($message, $type = 'success') {
    return "<div class='message {$type}'>{$message}</div>";
}

// Format date for display
function format_date($date) {
    return date('F j, Y', strtotime($date));
}

// Format datetime for display
function format_datetime($datetime) {
    return date('F j, Y g:i A', strtotime($datetime));
}
?>
