<?php
// Include required files
require_once 'includes/config.php';
require_once 'includes/functions.php';

// Check if user is logged in
requireLogin();

// Get current user information
$user_info = getUserInfo($_SESSION['user_id']);
$upcoming_classes = getUpcomingClasses();
$study_materials = getStudyMaterials();

// Limit materials to latest 5 for dashboard
$recent_materials = array_slice($study_materials, 0, 5);

$page_title = "Student Dashboard";
?>

<?php include 'includes/header.php'; ?>

<link rel="stylesheet" href="css/dashboard.css">

<div class="page-header">
    <h2>Welcome back, <?php echo htmlspecialchars($user_info['fullname']); ?>!</h2>
    <p>Here's your learning overview and upcoming classes</p>
</div>

<!-- Dashboard Stats -->
<div class="dashboard-stats">
    <div class="stat-card">
        <div class="stat-icon">📚</div>
        <div class="stat-number"><?php echo count($upcoming_classes); ?></div>
        <div class="stat-label">Upcoming Classes</div>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon">📖</div>
        <div class="stat-number"><?php echo count($study_materials); ?></div>
        <div class="stat-label">Study Materials</div>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon">🎓</div>
        <div class="stat-number"><?php echo htmlspecialchars($user_info['school']); ?></div>
        <div class="stat-label">Your School</div>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon">📞</div>
        <div class="stat-number"><?php echo htmlspecialchars($user_info['phone']); ?></div>
        <div class="stat-label">Contact Number</div>
    </div>
</div>

<!-- Main Dashboard Content -->
<div class="dashboard-content">
    <!-- Upcoming Classes Section -->
    <div class="dashboard-section">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">📅 Upcoming Classes</h3>
                <p class="card-subtitle">Your scheduled mathematics classes</p>
            </div>
            
            <div class="classes-container">
                <?php if (empty($upcoming_classes)): ?>
                    <div class="no-content">
                        <div class="no-content-icon">📅</div>
                        <h4>No Upcoming Classes</h4>
                        <p>There are no classes scheduled at the moment. Check back later or contact your tutor.</p>
                    </div>
                <?php else: ?>
                    <?php foreach ($upcoming_classes as $class): ?>
                        <div class="class-item">
                            <div class="class-date">
                                <div class="date-day"><?php echo date('d', strtotime($class['classdate'])); ?></div>
                                <div class="date-month"><?php echo date('M', strtotime($class['classdate'])); ?></div>
                            </div>
                            <div class="class-details">
                                <h4 class="class-topic"><?php echo htmlspecialchars($class['subjecttopic']); ?></h4>
                                <p class="class-time">⏰ <?php echo formatTime($class['classtime']); ?></p>
                                <p class="class-description"><?php echo htmlspecialchars($class['description']); ?></p>
                            </div>
                            <div class="class-status">
                                <span class="status-badge upcoming">Upcoming</span>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
            
            <?php if (!empty($upcoming_classes)): ?>
                <div class="card-footer">
                    <p class="footer-note">💡 <strong>Tip:</strong> Join classes 5 minutes early and have your materials ready!</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
    
    <!-- Recent Study Materials Section -->
    <div class="dashboard-section">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">📚 Recent Study Materials</h3>
                <p class="card-subtitle">Latest materials uploaded by your tutor</p>
            </div>
            
            <div class="materials-container">
                <?php if (empty($recent_materials)): ?>
                    <div class="no-content">
                        <div class="no-content-icon">📚</div>
                        <h4>No Study Materials</h4>
                        <p>No study materials have been uploaded yet. Check back later.</p>
                    </div>
                <?php else: ?>
                    <?php foreach ($recent_materials as $material): ?>
                        <div class="material-item">
                            <div class="material-icon">
                                <?php
                                $extension = pathinfo($material['filename'], PATHINFO_EXTENSION);
                                switch (strtolower($extension)) {
                                    case 'pdf':
                                        echo '📄';
                                        break;
                                    case 'doc':
                                    case 'docx':
                                        echo '📝';
                                        break;
                                    case 'jpg':
                                    case 'jpeg':
                                    case 'png':
                                        echo '🖼️';
                                        break;
                                    default:
                                        echo '📎';
                                }
                                ?>
                            </div>
                            <div class="material-info">
                                <h4 class="material-title"><?php echo htmlspecialchars($material['title']); ?></h4>
                                <p class="material-subject"><?php echo htmlspecialchars($material['subjecttopic']); ?></p>
                                <p class="material-date">Uploaded: <?php echo formatDate($material['uploaddate']); ?></p>
                            </div>
                            <div class="material-actions">
                                <a href="<?php echo htmlspecialchars($material['filepath']); ?>" 
                                   class="btn btn-download" 
                                   target="_blank">
                                   📥 Download
                                </a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
            
            <?php if (!empty($study_materials)): ?>
                <div class="card-footer">
                    <a href="resources.php" class="btn btn-secondary">View All Materials</a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Quick Actions Section -->
<div class="quick-actions">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">🚀 Quick Actions</h3>
            <p class="card-subtitle">Navigate to important sections</p>
        </div>
        
        <div class="actions-grid">
            <a href="resources.php" class="action-item">
                <div class="action-icon">📚</div>
                <h4>Study Materials</h4>
                <p>Access all uploaded materials and resources</p>
            </a>
            
            <a href="about.php" class="action-item">
                <div class="action-icon">👨‍🏫</div>
                <h4>About Tutor</h4>
                <p>Learn more about your mathematics tutor</p>
            </a>
            
            <a href="mailto:ashan.math@gmail.com" class="action-item">
                <div class="action-icon">📧</div>
                <h4>Contact Tutor</h4>
                <p>Send an email for questions or support</p>
            </a>
            
            <a href="tel:+94771234567" class="action-item">
                <div class="action-icon">📞</div>
                <h4>Call Tutor</h4>
                <p>Direct phone contact for urgent matters</p>
            </a>
        </div>
    </div>
</div>

<!-- Student Information Section -->
<div class="student-info">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">👤 Your Information</h3>
            <p class="card-subtitle">Your registered details</p>
        </div>
        
        <div class="info-grid">
            <div class="info-item">
                <strong>Full Name:</strong>
                <span><?php echo htmlspecialchars($user_info['fullname']); ?></span>
            </div>
            <div class="info-item">
                <strong>Username:</strong>
                <span><?php echo htmlspecialchars($user_info['username']); ?></span>
            </div>
            <div class="info-item">
                <strong>Email:</strong>
                <span><?php echo htmlspecialchars($user_info['email']); ?></span>
            </div>
            <div class="info-item">
                <strong>Phone:</strong>
                <span><?php echo htmlspecialchars($user_info['phone']); ?></span>
            </div>
            <div class="info-item">
                <strong>School:</strong>
                <span><?php echo htmlspecialchars($user_info['school']); ?></span>
            </div>
            <div class="info-item">
                <strong>Member Since:</strong>
                <span><?php echo formatDate($user_info['createdat']); ?></span>
            </div>
        </div>
    </div>
</div>

<script>
// Dashboard specific JavaScript
document.addEventListener('DOMContentLoaded', function() {
    // Add current time display
    updateCurrentTime();
    setInterval(updateCurrentTime, 1000);
    
    // Add greeting based on time
    updateGreeting();
});

function updateCurrentTime() {
    const now = new Date();
    const timeString = now.toLocaleTimeString('en-US', {
        hour: '2-digit',
        minute: '2-digit',
        second: '2-digit'
    });
    
    // Add time display to page header if element exists
    let timeDisplay = document.querySelector('.current-time');
    if (!timeDisplay) {
        timeDisplay = document.createElement('div');
        timeDisplay.className = 'current-time';
        const pageHeader = document.querySelector('.page-header');
        if (pageHeader) {
            pageHeader.appendChild(timeDisplay);
        }
    }
    timeDisplay.textContent = 'Current Time: ' + timeString;
}

function updateGreeting() {
    const hour = new Date().getHours();
    let greeting = 'Good day';
    
    if (hour < 12) {
        greeting = 'Good morning';
    } else if (hour < 17) {
        greeting = 'Good afternoon';
    } else {
        greeting = 'Good evening';
    }
    
    const welcomeText = document.querySelector('.page-header h2');
    if (welcomeText) {
        const name = welcomeText.textContent.split(',')[1];
        welcomeText.textContent = `${greeting},${name}`;
    }
}
</script>

<?php include 'includes/footer.php'; ?>
