<?php
$page_title = "Admin Dashboard";
require_once 'includes/functions.php';

// Check if user is logged in and is admin
require_admin();

$success_message = '';
$error_message = '';

// Handle form submissions
if ($_POST) {
    $action = $_POST['action'];
    
    // Add new student
    if ($action == 'add_student') {
        $username = clean_input($_POST['username']);
        $password = clean_input($_POST['password']);
        $email = clean_input($_POST['email']);
        $full_name = clean_input($_POST['full_name']);
        
        if (add_user($username, $password, $email, $full_name, 'student')) {
            $success_message = "Student added successfully!";
        } else {
            $error_message = "Error adding student. Username might already exist.";
        }
    }
    
    // Add new class
    if ($action == 'add_class') {
        $class_name = clean_input($_POST['class_name']);
        $description = clean_input($_POST['description']);
        $teacher_name = clean_input($_POST['teacher_name']);
        $schedule = clean_input($_POST['schedule']);
        
        if (add_class($class_name, $description, $teacher_name, $schedule)) {
            $success_message = "Class added successfully!";
        } else {
            $error_message = "Error adding class.";
        }
    }
    
    // Add new material
    if ($action == 'add_material') {
        $title = clean_input($_POST['title']);
        $description = clean_input($_POST['description']);
        $material_type = clean_input($_POST['material_type']);
        $class_id = !empty($_POST['class_id']) ? (int)$_POST['class_id'] : null;
        
        if (add_material($title, $description, $material_type, $class_id)) {
            $success_message = "Material added successfully!";
        } else {
            $error_message = "Error adding material.";
        }
    }
}

// Get data for display
$all_users = get_all_users();
$all_classes = get_all_classes();
$all_materials = get_all_materials();

require_once 'includes/header.php';
?>

<link rel="stylesheet" href="css/admin.css">

<div class="admin-container">
    <div class="admin-header">
        <h1>Admin Dashboard</h1>
        <p>Manage students, classes, and study materials</p>
    </div>
    
    <?php if ($success_message): ?>
        <div class="message success"><?php echo $success_message; ?></div>
    <?php endif; ?>
    
    <?php if ($error_message): ?>
        <div class="message error"><?php echo $error_message; ?></div>
    <?php endif; ?>
    
    <div class="admin-tabs">
        <button class="tab-button active" onclick="openTab('students-tab', this)">Students</button>
        <button class="tab-button" onclick="openTab('classes-tab', this)">Classes</button>
        <button class="tab-button" onclick="openTab('materials-tab', this)">Materials</button>
    </div>
    
    <!-- Students Tab -->
    <div id="students-tab" class="tab-content active">
        <div class="admin-section">
            <h2>Add New Student</h2>
            <form method="POST" class="admin-form">
                <input type="hidden" name="action" value="add_student">
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="username">Username:</label>
                        <input type="text" id="username" name="username" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="password">Password:</label>
                        <input type="password" id="password" name="password" required>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="full_name">Full Name:</label>
                        <input type="text" id="full_name" name="full_name" required>
                    </div>
                </div>
                
                <button type="submit" class="btn btn-success">Add Student</button>
            </form>
        </div>
        
        <div class="admin-section">
            <h2>All Students</h2>
            <?php if (!empty($all_users)): ?>
                <div class="table-container">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Username</th>
                                <th>Full Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Created</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($all_users as $user): ?>
                                <tr>
                                    <td><?php echo $user['id']; ?></td>
                                    <td><?php echo htmlspecialchars($user['username']); ?></td>
                                    <td><?php echo htmlspecialchars($user['full_name']); ?></td>
                                    <td><?php echo htmlspecialchars($user['email']); ?></td>
                                    <td>
                                        <span class="role-badge <?php echo $user['role']; ?>">
                                            <?php echo ucfirst($user['role']); ?>
                                        </span>
                                    </td>
                                    <td><?php echo format_date($user['created_at']); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <p class="no-data">No students found.</p>
            <?php endif; ?>
        </div>
    </div>
    
    <!-- Classes Tab -->
    <div id="classes-tab" class="tab-content">
        <div class="admin-section">
            <h2>Add New Class</h2>
            <form method="POST" class="admin-form">
                <input type="hidden" name="action" value="add_class">
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="class_name">Class Name:</label>
                        <input type="text" id="class_name" name="class_name" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="teacher_name">Teacher Name:</label>
                        <input type="text" id="teacher_name" name="teacher_name" value="Ashan Sudusinghe" required>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="description">Description:</label>
                    <textarea id="description" name="description" rows="3"></textarea>
                </div>
                
                <div class="form-group">
                    <label for="schedule">Schedule:</label>
                    <input type="text" id="schedule" name="schedule" placeholder="e.g., Monday & Wednesday 4:00 PM">
                </div>
                
                <button type="submit" class="btn btn-success">Add Class</button>
            </form>
        </div>
        
        <div class="admin-section">
            <h2>All Classes</h2>
            <?php if (!empty($all_classes)): ?>
                <div class="classes-grid">
                    <?php foreach ($all_classes as $class): ?>
                        <div class="class-card">
                            <h3><?php echo htmlspecialchars($class['class_name']); ?></h3>
                            <p class="class-description"><?php echo htmlspecialchars($class['description']); ?></p>
                            <div class="class-info">
                                <span><strong>Teacher:</strong> <?php echo htmlspecialchars($class['teacher_name']); ?></span>
                                <span><strong>Schedule:</strong> <?php echo htmlspecialchars($class['schedule']); ?></span>
                                <span><strong>Created:</strong> <?php echo format_date($class['created_at']); ?></span>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p class="no-data">No classes found.</p>
            <?php endif; ?>
        </div>
    </div>
    
    <!-- Materials Tab -->
    <div id="materials-tab" class="tab-content">
        <div class="admin-section">
            <h2>Add New Material</h2>
            <form method="POST" class="admin-form">
                <input type="hidden" name="action" value="add_material">
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="title">Material Title:</label>
                        <input type="text" id="title" name="title" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="material_type">Material Type:</label>
                        <select id="material_type" name="material_type" required>
                            <option value="">Select Type</option>
                            <option value="pdf">PDF Document</option>
                            <option value="video">Video</option>
                            <option value="document">Document</option>
                            <option value="link">Web Link</option>
                        </select>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="description">Description:</label>
                    <textarea id="description" name="description" rows="3"></textarea>
                </div>
                
                <div class="form-group">
                    <label for="class_id">Assign to Class (Optional):</label>
                    <select id="class_id" name="class_id">
                        <option value="">No specific class</option>
                        <?php foreach ($all_classes as $class): ?>
                            <option value="<?php echo $class['id']; ?>">
                                <?php echo htmlspecialchars($class['class_name']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <button type="submit" class="btn btn-success">Add Material</button>
            </form>
        </div>
        
        <div class="admin-section">
            <h2>All Materials</h2>
            <?php if (!empty($all_materials)): ?>
                <div class="table-container">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Title</th>
                                <th>Type</th>
                                <th>Class</th>
                                <th>Uploaded</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($all_materials as $material): ?>
                                <tr>
                                    <td><?php echo $material['id']; ?></td>
                                    <td><?php echo htmlspecialchars($material['title']); ?></td>
                                    <td>
                                        <span class="type-badge <?php echo $material['material_type']; ?>">
                                            <?php echo ucfirst($material['material_type']); ?>
                                        </span>
                                    </td>
                                    <td><?php echo $material['class_name'] ? htmlspecialchars($material['class_name']) : 'General'; ?></td>
                                    <td><?php echo format_date($material['uploaded_at']); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <p class="no-data">No materials found.</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<script src="js/main.js"></script>
<script src="js/validation.js"></script>
<script>
// Tab functionality
function openTab(tabName, element) {
    // Hide all tab contents
    const tabContents = document.querySelectorAll('.tab-content');
    tabContents.forEach(function(content) {
        content.classList.remove('active');
    });
    
    // Remove active class from all tab buttons
    const tabButtons = document.querySelectorAll('.tab-button');
    tabButtons.forEach(function(button) {
        button.classList.remove('active');
    });
    
    // Show selected tab content
    const selectedTab = document.getElementById(tabName);
    if (selectedTab) {
        selectedTab.classList.add('active');
    }
    
    // Add active class to clicked button
    if (element) {
        element.classList.add('active');
    }
}

// Form validation
document.addEventListener('DOMContentLoaded', function() {
    const forms = document.querySelectorAll('.admin-form');
    
    forms.forEach(function(form) {
        form.addEventListener('submit', function(e) {
            if (!validateForm(this)) {
                e.preventDefault();
                showErrorMessage('Please fill in all required fields correctly.');
            }
        });
    });
});
</script>

<?php require_once 'includes/footer.php'; ?>
