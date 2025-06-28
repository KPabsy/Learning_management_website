<?php
// Include required files
require_once 'includes/config.php';
require_once 'includes/functions.php';

// Check if user is logged in and is admin
requireAdmin();

// Get current admin information
$admin_info = getUserInfo($_SESSION['user_id']);
$all_students = getAllStudents();
$upcoming_classes = getUpcomingClasses();
$study_materials = getStudyMaterials();

// Handle form submissions
$success_message = '';
$error_message = '';

// Add Student
if (isset($_POST['add_student'])) {
    $username = cleanInput($_POST['username']);
    $email = cleanInput($_POST['email']);
    $password = cleanInput($_POST['password']);
    $fullname = cleanInput($_POST['fullname']);
    $phone = cleanInput($_POST['phone']);
    $school = cleanInput($_POST['school']);
    
    if (addStudent($username, $email, $password, $fullname, $phone, $school)) {
        $success_message = "Student added successfully!";
        $all_students = getAllStudents(); // Refresh list
    } else {
        $error_message = "Failed to add student. Username might already exist.";
    }
}

// Add Class
if (isset($_POST['add_class'])) {
    $classdate = cleanInput($_POST['classdate']);
    $classtime = cleanInput($_POST['classtime']);
    $subjecttopic = cleanInput($_POST['subjecttopic']);
    $description = cleanInput($_POST['description']);
    
    if (addClass($classdate, $classtime, $subjecttopic, $description)) {
        $success_message = "Class scheduled successfully!";
        $upcoming_classes = getUpcomingClasses(); // Refresh list
    } else {
        $error_message = "Failed to schedule class.";
    }
}

$page_title = "Admin Panel";
?>

<?php include 'includes/header.php'; ?>

<link rel="stylesheet" href="css/admin.css">

<div class="admin-header">
    <h2>Admin Panel</h2>
    <p>Manage students, classes, and system settings</p>
    <div class="admin-welcome">
        Welcome, <?php echo htmlspecialchars($admin_info['fullname']); ?> | 
        <span class="admin-role">Administrator</span>
    </div>
</div>

<?php if (!empty($success_message)): ?>
    <div class="alert alert-success">
        ✅ <?php echo htmlspecialchars($success_message); ?>
    </div>
<?php endif; ?>

<?php if (!empty($error_message)): ?>
    <div class="alert alert-error">
        ❌ <?php echo htmlspecialchars($error_message); ?>
    </div>
<?php endif; ?>

<!-- Admin Stats -->
<div class="admin-stats">
    <div class="stat-card">
        <div class="stat-icon">👥</div>
        <div class="stat-number"><?php echo count($all_students); ?></div>
        <div class="stat-label">Total Students</div>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon">📅</div>
        <div class="stat-number"><?php echo count($upcoming_classes); ?></div>
        <div class="stat-label">Scheduled Classes</div>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon">📚</div>
        <div class="stat-number"><?php echo count($study_materials); ?></div>
        <div class="stat-label">Study Materials</div>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon">⚙️</div>
        <div class="stat-number">Active</div>
        <div class="stat-label">System Status</div>
    </div>
</div>

<!-- Admin Tabs -->
<div class="admin-tabs">
    <div class="tab-buttons">
        <button class="tab-button active" onclick="showTab('students')">👥 Manage Students</button>
        <button class="tab-button" onclick="showTab('classes')">📅 Manage Classes</button>
        <button class="tab-button" onclick="showTab('materials')">📚 Study Materials</button>
        <button class="tab-button" onclick="showTab('settings')">⚙️ Settings</button>
    </div>
    
    <!-- Students Tab -->
    <div id="students-tab" class="tab-content active">
        <div class="admin-section">
            <div class="section-header">
                <h3>Add New Student</h3>
                <p>Register a new student to the system</p>
            </div>
            
            <form method="POST" class="admin-form" id="addStudentForm">
                <div class="form-row">
                    <div class="form-group">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" id="username" name="username" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" id="email" name="email" class="form-control" required>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" id="password" name="password" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="fullname" class="form-label">Full Name</label>
                        <input type="text" id="fullname" name="fullname" class="form-control" required>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="phone" class="form-label">Phone Number</label>
                        <input type="tel" id="phone" name="phone" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="school" class="form-label">School</label>
                        <input type="text" id="school" name="school" class="form-control" required>
                    </div>
                </div>
                
                <button type="submit" name="add_student" class="btn btn-primary">Add Student</button>
            </form>
        </div>
        
        <div class="admin-section">
            <div class="section-header">
                <h3>Current Students</h3>
                <p>List of all registered students</p>
            </div>
            
            <div class="table-container">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Username</th>
                            <th>Full Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>School</th>
                            <th>Joined</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($all_students)): ?>
                            <tr>
                                <td colspan="7" class="no-data">No students registered yet</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($all_students as $student): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($student['id']); ?></td>
                                    <td><?php echo htmlspecialchars($student['username']); ?></td>
                                    <td><?php echo htmlspecialchars($student['fullname']); ?></td>
                                    <td><?php echo htmlspecialchars($student['email']); ?></td>
                                    <td><?php echo htmlspecialchars($student['phone']); ?></td>
                                    <td><?php echo htmlspecialchars($student['school']); ?></td>
                                    <td><?php echo formatDate($student['createdat']); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <!-- Classes Tab -->
    <div id="classes-tab" class="tab-content">
        <div class="admin-section">
            <div class="section-header">
                <h3>Schedule New Class</h3>
                <p>Add a new mathematics class to the schedule</p>
            </div>
            
            <form method="POST" class="admin-form" id="addClassForm">
                <div class="form-row">
                    <div class="form-group">
                        <label for="classdate" class="form-label">Class Date</label>
                        <input type="date" id="classdate" name="classdate" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="classtime" class="form-label">Class Time</label>
                        <input type="time" id="classtime" name="classtime" class="form-control" required>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="subjecttopic" class="form-label">Subject/Topic</label>
                    <input type="text" id="subjecttopic" name="subjecttopic" class="form-control" 
                           placeholder="e.g., Algebra - Quadratic Equations" required>
                </div>
                
                <div class="form-group">
                    <label for="description" class="form-label">Description</label>
                    <textarea id="description" name="description" class="form-control" rows="3" 
                              placeholder="Brief description of what will be covered in this class"></textarea>
                </div>
                
                <button type="submit" name="add_class" class="btn btn-primary">Schedule Class</button>
            </form>
        </div>
        
        <div class="admin-section">
            <div class="section-header">
                <h3>Scheduled Classes</h3>
                <p>All upcoming mathematics classes</p>
            </div>
            
            <div class="classes-grid">
                <?php if (empty($upcoming_classes)): ?>
                    <div class="no-content">
                        <div class="no-content-icon">📅</div>
                        <h4>No Classes Scheduled</h4>
                        <p>Schedule your first class using the form above.</p>
                    </div>
                <?php else: ?>
                    <?php foreach ($upcoming_classes as $class): ?>
                        <div class="class-card">
                            <div class="class-date-badge">
                                <div class="date-day"><?php echo date('d', strtotime($class['classdate'])); ?></div>
                                <div class="date-month"><?php echo date('M', strtotime($class['classdate'])); ?></div>
                            </div>
                            <div class="class-info">
                                <h4><?php echo htmlspecialchars($class['subjecttopic']); ?></h4>
                                <p class="class-time">⏰ <?php echo formatTime($class['classtime']); ?></p>
                                <p class="class-desc"><?php echo htmlspecialchars($class['description']); ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <!-- Materials Tab -->
    <div id="materials-tab" class="tab-content">
        <div class="admin-section">
            <div class="section-header">
                <h3>Study Materials</h3>
                <p>Manage uploaded study materials and resources</p>
            </div>
            
            <div class="materials-list">
                <?php if (empty($study_materials)): ?>
                    <div class="no-content">
                        <div class="no-content-icon">📚</div>
                        <h4>No Materials Uploaded</h4>
                        <p>Upload study materials for your students.</p>
                    </div>
                <?php else: ?>
                    <?php foreach ($study_materials as $material): ?>
                        <div class="material-card">
                            <div class="material-icon">
                                <?php
                                $extension = pathinfo($material['filename'], PATHINFO_EXTENSION);
                                switch (strtolower($extension)) {
                                    case 'pdf': echo '📄'; break;
                                    case 'doc':
                                    case 'docx': echo '📝'; break;
                                    case 'jpg':
                                    case 'jpeg':
                                    case 'png': echo '🖼️'; break;
                                    default: echo '📎';
                                }
                                ?>
                            </div>
                            <div class="material-details">
                                <h4><?php echo htmlspecialchars($material['title']); ?></h4>
                                <p class="material-subject"><?php echo htmlspecialchars($material['subjecttopic']); ?></p>
                                <p class="material-date">Uploaded: <?php echo formatDate($material['uploaddate']); ?></p>
                            </div>
                            <div class="material-actions">
                                <a href="<?php echo htmlspecialchars($material['filepath']); ?>" 
                                   class="btn btn-sm btn-secondary" target="_blank">View</a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <!-- Settings Tab -->
    <div id="settings-tab" class="tab-content">
        <div class="admin-section">
            <div class="section-header">
                <h3>System Settings</h3>
                <p>Basic system information and settings</p>
            </div>
            
            <div class="settings-grid">
                <div class="setting-item">
                    <h4>Database Status</h4>
                    <p class="status-active">✅ Connected</p>
                </div>
                
                <div class="setting-item">
                    <h4>Total Users</h4>
                    <p><?php echo count($all_students) + 1; ?> (<?php echo count($all_students); ?> students + 1 admin)</p>
                </div>
                
                <div class="setting-item">
                    <h4>System Version</h4>
                    <p>LMS v1.0 - Basic</p>
                </div>
                
                <div class="setting-item">
                    <h4>Last Login</h4>
                    <p><?php echo date('F j, Y g:i A'); ?></p>
                </div>
            </div>
            
            <div class="admin-actions">
                <h4>Quick Actions</h4>
                <div class="action-buttons">
                    <a href="resources.php" class="btn btn-secondary">View Resources Page</a>
                    <a href="about.php" class="btn btn-secondary">View About Page</a>
                    <a href="dashboard.php" class="btn btn-secondary">View Student Dashboard</a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Admin panel JavaScript
function showTab(tabName) {
    // Hide all tab contents
    const tabContents = document.querySelectorAll('.tab-content');
    tabContents.forEach(tab => {
        tab.classList.remove('active');
    });
    
    // Remove active class from all buttons
    const tabButtons = document.querySelectorAll('.tab-button');
    tabButtons.forEach(button => {
        button.classList.remove('active');
    });
    
    // Show selected tab
    document.getElementById(tabName + '-tab').classList.add('active');
    
    // Add active class to clicked button
    event.target.classList.add('active');
}

// Form validation
document.getElementById('addStudentForm').addEventListener('submit', function(e) {
    const username = document.getElementById('username').value.trim();
    const email = document.getElementById('email').value.trim();
    const password = document.getElementById('password').value.trim();
    const fullname = document.getElementById('fullname').value.trim();
    
    if (username.length < 3) {
        alert('Username must be at least 3 characters long');
        e.preventDefault();
        return;
    }
    
    if (password.length < 6) {
        alert('Password must be at least 6 characters long');
        e.preventDefault();
        return;
    }
    
    if (fullname.length < 2) {
        alert('Full name must be at least 2 characters long');
        e.preventDefault();
        return;
    }
});

document.getElementById('addClassForm').addEventListener('submit', function(e) {
    const classDate = new Date(document.getElementById('classdate').value);
    const today = new Date();
    today.setHours(0, 0, 0, 0);
    
    if (classDate < today) {
        alert('Class date cannot be in the past');
        e.preventDefault();
        return;
    }
    
    const subjectTopic = document.getElementById('subjecttopic').value.trim();
    if (subjectTopic.length < 3) {
        alert('Subject/Topic must be at least 3 characters long');
        e.preventDefault();
        return;
    }
});

// Set minimum date for class scheduling
document.getElementById('classdate').min = new Date().toISOString().split('T')[0];
</script>

<?php include 'includes/footer.php'; ?>
