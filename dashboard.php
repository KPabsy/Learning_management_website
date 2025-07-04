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

<style>
    body{
    background-color:rgb(9, 19, 33);
}
.dashboard-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
}

.welcome-section {
    background: linear-gradient(135deg,rgb(110, 143, 200),rgb(28, 80, 159));
    color: white;
    padding: 30px;
    border-radius: 10px;
    margin-bottom: 30px;
    text-align: center;
}

.welcome-section h1 {
    margin: 0 0 10px 0;
    font-size: 2.2rem;
    color: white;
}

.welcome-section p {
    margin: 0;
    font-size: 1.1rem;
    opacity: 0.9;
}

/* Dashboard Grid Layout */
.dashboard-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
    gap: 20px;
    margin-bottom: 30px;
}

.dashboard-card {
    background: white;
    border-radius: 8px;
    padding: 25px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    border: 1px solid #e1e8ed;
}

.dashboard-card h2 {
    color: #2c3e50;
    margin: 0 0 20px 0;
    font-size: 1.4rem;
    border-bottom: 2px solid #3498db;
    padding-bottom: 10px;
}

/* Classes Section */
.classes-list {
    display: flex;
    flex-direction: column;
    gap: 15px;
}

.class-item {
    background: #f8f9fa;
    padding: 20px;
    border-radius: 6px;
    border-left: 4px solid #3498db;
}

.class-item h3 {
    margin: 0 0 10px 0;
    color: #2c3e50;
    font-size: 1.2rem;
}

.class-description {
    color: #666;
    margin: 0 0 15px 0;
    line-height: 1.5;
}

.class-details {
    display: flex;
    flex-direction: column;
    gap: 5px;
}

.class-details span {
    font-size: 0.9rem;
    color: #555;
}

.teacher {
    font-weight: bold;
}

.schedule {
    color: #27ae60;
    font-weight: bold;
}

/* Quick Links Section */
.quick-links {
    display: flex;
    flex-direction: column;
    gap: 15px;
}

.quick-link {
    display: flex;
    align-items: center;
    padding: 15px;
    background: #f8f9fa;
    border-radius: 6px;
    text-decoration: none;
    color: #2c3e50;
    transition: all 0.3s ease;
    border: 1px solid #e1e8ed;
}

.quick-link:hover {
    background: #e9ecef;
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.logout-link:hover {
    background: #f8d7da;
    border-color: #f5c6cb;
}

.link-icon {
    font-size: 2rem;
    margin-right: 15px;
    min-width: 50px;
    text-align: center;
}

.link-text h3 {
    margin: 0 0 5px 0;
    font-size: 1.1rem;
    color: #2c3e50;
}

.link-text p {
    margin: 0;
    font-size: 0.9rem;
    color: #666;
}

/* Materials Section */
.materials-list {
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.material-item {
    background: #f8f9fa;
    padding: 15px;
    border-radius: 6px;
    border-left: 3px solid gray;
}

.material-info h4 {
    margin: 0 0 8px 0;
    color: #2c3e50;
    font-size: 1rem;
}

.material-info p {
    margin: 0 0 10px 0;
    color: #666;
    font-size: 0.9rem;
    line-height: 1.4;
}

.material-type {
    background: #3498db;
    color: white;
    padding: 3px 8px;
    border-radius: 3px;
    font-size: 0.8rem;
    margin-right: 10px;
}

.material-class {
    background:rgb(53, 85, 114);
    color: white;
    padding: 3px 8px;
    border-radius: 3px;
    font-size: 0.8rem;
}

.view-all {
    text-align: center;
    margin-top: 15px;
}

/* Testimonials Section */
.testimonials-list {
    display: flex;
    flex-direction: column;
    gap: 15px;
}

.testimonial-item {
    background: #f8f9fa;
    padding: 15px;
    border-radius: 6px;
    border-left: 3px solid teal;
}

.testimonial-message {
    margin: 0 0 10px 0;
    color: #555;
    font-style: italic;
    line-height: 1.5;
}

.testimonial-author {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.testimonial-author strong {
    color: #2c3e50;
    font-size: 0.9rem;
}

.rating {
    display: flex;
    gap: 2px;
}

.star {
    color: #ddd;
    font-size: 1rem;
}

.star.filled {
    color: #f39c12;
}

/* User Info Section */
.user-info-section {
    margin-top: 30px;
}

.user-card {
    background: white;
    border-radius: 8px;
    padding: 25px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    border: 1px solid #e1e8ed;
}

.user-card h3 {
    color: #2c3e50;
    margin: 0 0 20px 0;
    font-size: 1.3rem;
    border-bottom: 2px solid #3498db;
    padding-bottom: 10px;
}

.user-details {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 15px;
}

.user-details p {
    margin: 0;
    padding: 10px;
    background: #f8f9fa;
    border-radius: 4px;
    color: #555;
}

.user-details strong {
    color: #2c3e50;
}

/* No Data Message */
.no-data {
    text-align: center;
    color: #666;
    font-style: italic;
    padding: 20px;
    background: #f8f9fa;
    border-radius: 6px;
}

/* Responsive Design */
@media (max-width: 768px) {
    .dashboard-container {
        padding: 10px;
    }
    
    .welcome-section {
        padding: 20px;
    }
    
    .welcome-section h1 {
        font-size: 1.8rem;
    }
    
    .dashboard-grid {
        grid-template-columns: 1fr;
        gap: 15px;
    }
    
    .dashboard-card {
        padding: 20px;
    }
    
    .class-details {
        flex-direction: column;
    }
    
    .user-details {
        grid-template-columns: 1fr;
    }
    
    .testimonial-author {
        flex-direction: column;
        align-items: flex-start;
        gap: 5px;
    }
}

@media (max-width: 480px) {
    .welcome-section {
        padding: 15px;
    }
    
    .welcome-section h1 {
        font-size: 1.5rem;
    }
    
    .dashboard-card {
        padding: 15px;
    }
    
    .quick-link {
        padding: 12px;
    }
    
    .link-icon {
        font-size: 1.5rem;
        margin-right: 10px;
        min-width: 40px;
    }
}

/* Animation for cards */
.dashboard-card {
    animation: fadeInUp 0.5s ease-out;
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

</style>
