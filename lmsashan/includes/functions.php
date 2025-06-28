<?php
// Include config file
require_once 'config.php';

// User authentication function
function authenticateUser($username, $password) {
    $conn = getDBConnection();
    
    $sql = "SELECT id, username, password, fullname, usertype FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        
        // Simple password verification (in real project, use password_verify for hashed passwords)
        if ($password === $user['password']) {
            // Set session variables
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['fullname'] = $user['fullname'];
            $_SESSION['usertype'] = $user['usertype'];
            
            $stmt->close();
            $conn->close();
            return true;
        }
    }
    
    $stmt->close();
    $conn->close();
    return false;
}

// Check if user is logged in
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

// Check if user is admin
function isAdmin() {
    return isset($_SESSION['usertype']) && $_SESSION['usertype'] === 'admin';
}

// Redirect to login if not logged in
function requireLogin() {
    if (!isLoggedIn()) {
        header("Location: login.php");
        exit();
    }
}

// Redirect to login if not admin
function requireAdmin() {
    if (!isAdmin()) {
        header("Location: login.php");
        exit();
    }
}

// Get user information
function getUserInfo($user_id) {
    $conn = getDBConnection();
    
    $sql = "SELECT * FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $user = null;
    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
    }
    
    $stmt->close();
    $conn->close();
    return $user;
}

// Get upcoming classes
function getUpcomingClasses() {
    $conn = getDBConnection();
    
    $sql = "SELECT * FROM classes WHERE classdate >= CURDATE() ORDER BY classdate, classtime";
    $result = $conn->query($sql);
    
    $classes = array();
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $classes[] = $row;
        }
    }
    
    $conn->close();
    return $classes;
}

// Get all students (for admin)
function getAllStudents() {
    $conn = getDBConnection();
    
    $sql = "SELECT * FROM users WHERE usertype = 'student' ORDER BY fullname";
    $result = $conn->query($sql);
    
    $students = array();
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $students[] = $row;
        }
    }
    
    $conn->close();
    return $students;
}

// Get all study materials
function getStudyMaterials() {
    $conn = getDBConnection();
    
    $sql = "SELECT * FROM materials ORDER BY uploaddate DESC";
    $result = $conn->query($sql);
    
    $materials = array();
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $materials[] = $row;
        }
    }
    
    $conn->close();
    return $materials;
}

// Get testimonials
function getTestimonials() {
    $conn = getDBConnection();
    
    $sql = "SELECT * FROM testimonials ORDER BY createdat DESC";
    $result = $conn->query($sql);
    
    $testimonials = array();
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $testimonials[] = $row;
        }
    }
    
    $conn->close();
    return $testimonials;
}

// Add new student (for admin)
function addStudent($username, $email, $password, $fullname, $phone, $school) {
    $conn = getDBConnection();
    
    $sql = "INSERT INTO users (username, email, password, fullname, phone, school, usertype) VALUES (?, ?, ?, ?, ?, ?, 'student')";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssss", $username, $email, $password, $fullname, $phone, $school);
    
    $success = $stmt->execute();
    
    $stmt->close();
    $conn->close();
    return $success;
}

// Add new class (for admin)
function addClass($classdate, $classtime, $subjecttopic, $description) {
    $conn = getDBConnection();
    
    $sql = "INSERT INTO classes (classdate, classtime, subjecttopic, description) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $classdate, $classtime, $subjecttopic, $description);
    
    $success = $stmt->execute();
    
    $stmt->close();
    $conn->close();
    return $success;
}

// Clean input data
function cleanInput($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Format date for display
function formatDate($date) {
    return date('F j, Y', strtotime($date));
}

// Format time for display
function formatTime($time) {
    return date('g:i A', strtotime($time));
}

// Logout function
function logout() {
    session_start();
    session_unset();
    session_destroy();
    header("Location: login.php");
    exit();
}
?>
