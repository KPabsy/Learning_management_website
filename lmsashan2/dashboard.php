<?php
$page_title = "Student Dashboard";
require_once 'includes/functions.php';

// Check if user is logged in
require_login();

// Get current user information
$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'];
$full_name = $_SESSION['full_name'];

// Get all classes for display
$classes = get_all_classes();

// Get all materials for display
$materials = get_all_materials();

// Get approved testimonials
$testimonials = get_approved_testimonials();

require_once 'includes/header.php';
?>

<link rel="stylesheet" href="css/dashboard.css">

<div class="dashboard-container">
    <div class="welcome-section">
        <h1>Welcome, <?php echo htmlspecialchars($full_name); ?>!</h1>
        <p>Access your mathematics learning resources and class information below.</p>
    </div>
    
    <div class="dashboard-grid">
        <!-- Classes Section -->
        <div class="dashboard-card">
            <h2>Available Classes</h2>
            <?php if (!empty($classes)): ?>
                <div class="classes-list">
                    <?php foreach ($classes as $class): ?>
                        <div class="class-item">
                            <h3><?php echo htmlspecialchars($class['class_name']); ?></h3>
                            <p class="class-description"><?php echo htmlspecialchars($class['description']); ?></p>
                            <div class="class-details">
                                <span class="teacher">Teacher: <?php echo htmlspecialchars($class['teacher_name']); ?></span>
                                <span class="schedule">Schedule: <?php echo htmlspecialchars($class['schedule']); ?></span>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p class="no-data">No classes available at the moment.</p>
            <?php endif; ?>
        </div>
        
        <!-- Quick Links Section -->
        <div class="dashboard-card">
            <h2>Quick Links</h2>
            <div class="quick-links">
                <a href="resources.php" class="quick-link">
                    <div class="link-icon">📚</div>
                    <div class="link-text">
                        <h3>Study Materials</h3>
                        <p>Access learning resources</p>
                    </div>
                </a>
                
                <a href="about.php" class="quick-link">
                    <div class="link-icon">👨‍🏫</div>
                    <div class="link-text">
                        <h3>About Teacher</h3>
                        <p>Learn about Ashan Sir</p>
                    </div>
                </a>
                
                <a href="logout.php" class="quick-link logout-link">
                    <div class="link-icon">🚪</div>
                    <div class="link-text">
                        <h3>Logout</h3>
                        <p>End your session</p>
                    </div>
                </a>
            </div>
        </div>
        
        <!-- Recent Materials Section -->
        <div class="dashboard-card">
            <h2>Recent Study Materials</h2>
            <?php if (!empty($materials)): ?>
                <div class="materials-list">
                    <?php 
                    $recent_materials = array_slice($materials, 0, 5); // Show only 5 recent materials
                    foreach ($recent_materials as $material): 
                    ?>
                        <div class="material-item">
                            <div class="material-info">
                                <h4><?php echo htmlspecialchars($material['title']); ?></h4>
                                <p><?php echo htmlspecialchars($material['description']); ?></p>
                                <span class="material-type"><?php echo ucfirst($material['material_type']); ?></span>
                                <?php if ($material['class_name']): ?>
                                    <span class="material-class">Class: <?php echo htmlspecialchars($material['class_name']); ?></span>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="view-all">
                    <a href="resources.php" class="btn">View All Materials</a>
                </div>
            <?php else: ?>
                <p class="no-data">No study materials available yet.</p>
            <?php endif; ?>
        </div>
        
        <!-- Student Testimonials Section -->
        <div class="dashboard-card">
            <h2>What Students Say</h2>
            <?php if (!empty($testimonials)): ?>
                <div class="testimonials-list">
                    <?php 
                    $recent_testimonials = array_slice($testimonials, 0, 3); // Show only 3 testimonials
                    foreach ($recent_testimonials as $testimonial): 
                    ?>
                        <div class="testimonial-item">
                            <p class="testimonial-message">"<?php echo htmlspecialchars($testimonial['message']); ?>"</p>
                            <div class="testimonial-author">
                                <strong><?php echo htmlspecialchars($testimonial['student_name']); ?></strong>
                                <div class="rating">
                                    <?php for ($i = 1; $i <= 5; $i++): ?>
                                        <span class="star <?php echo $i <= $testimonial['rating'] ? 'filled' : ''; ?>">★</span>
                                    <?php endfor; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p class="no-data">No testimonials available yet.</p>
            <?php endif; ?>
        </div>
    </div>
    
    <!-- User Info Section -->
    <div class="user-info-section">
        <div class="user-card">
            <h3>Your Account Information</h3>
            <div class="user-details">
                <p><strong>Username:</strong> <?php echo htmlspecialchars($username); ?></p>
                <p><strong>Full Name:</strong> <?php echo htmlspecialchars($full_name); ?></p>
                <p><strong>Account Type:</strong> Student</p>
                <p><strong>Login Time:</strong> <span class="current-datetime"></span></p>
            </div>
        </div>
    </div>
</div>

<script src="js/main.js"></script>
<script>
// Update current date and time
function updateDateTime() {
    const now = new Date();
    const dateTimeString = now.toLocaleString();
    const dateTimeElement = document.querySelector('.current-datetime');
    if (dateTimeElement) {
        dateTimeElement.textContent = dateTimeString;
    }
}

// Update time on page load
document.addEventListener('DOMContentLoaded', function() {
    updateDateTime();
    
    // Update time every minute
    setInterval(updateDateTime, 60000);
});
</script>

<?php require_once 'includes/footer.php'; ?>
