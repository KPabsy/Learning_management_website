<?php
// Include required files
require_once 'includes/config.php';
require_once 'includes/functions.php';

// Check if user is logged in
requireLogin();

// Get current user information
$user_info = getUserInfo($_SESSION['user_id']);

// Get all study materials
$study_materials = getStudyMaterials();

// Search functionality
$search_term = '';
$filtered_materials = $study_materials;

if (isset($_GET['search']) && !empty($_GET['search'])) {
    $search_term = cleanInput($_GET['search']);
    $filtered_materials = array_filter($study_materials, function($material) use ($search_term) {
        return stripos($material['title'], $search_term) !== false || 
               stripos($material['subjecttopic'], $search_term) !== false;
    });
}

// Filter by subject
$selected_subject = '';
if (isset($_GET['subject']) && !empty($_GET['subject'])) {
    $selected_subject = cleanInput($_GET['subject']);
    $filtered_materials = array_filter($filtered_materials, function($material) use ($selected_subject) {
        return stripos($material['subjecttopic'], $selected_subject) !== false;
    });
}

// Get unique subjects for filter
$subjects = array_unique(array_column($study_materials, 'subjecttopic'));
sort($subjects);

$page_title = "Study Materials";
?>

<?php include 'includes/header.php'; ?>

<div class="page-header">
    <h2>📚 Study Materials</h2>
    <p>Access your mathematics study resources and materials</p>
</div>

<!-- Search and Filter Section -->
<div class="search-filter-section">
    <div class="card">
        <div class="search-filter-content">
            <form method="GET" class="search-form">
                <div class="search-group">
                    <input type="text" 
                           name="search" 
                           class="search-input" 
                           placeholder="Search materials by title or topic..."
                           value="<?php echo htmlspecialchars($search_term); ?>">
                    <button type="submit" class="search-btn">🔍 Search</button>
                </div>
                
                <div class="filter-group">
                    <select name="subject" class="filter-select" onchange="this.form.submit()">
                        <option value="">All Subjects</option>
                        <?php foreach ($subjects as $subject): ?>
                            <option value="<?php echo htmlspecialchars($subject); ?>" 
                                    <?php echo ($selected_subject === $subject) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($subject); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <?php if (!empty($search_term) || !empty($selected_subject)): ?>
                    <a href="resources.php" class="clear-filters">Clear Filters</a>
                <?php endif; ?>
            </form>
        </div>
    </div>
</div>

<!-- Materials Stats -->
<div class="materials-stats">
    <div class="stat-item">
        <span class="stat-number"><?php echo count($study_materials); ?></span>
        <span class="stat-label">Total Materials</span>
    </div>
    <div class="stat-item">
        <span class="stat-number"><?php echo count($filtered_materials); ?></span>
        <span class="stat-label">Showing Results</span>
    </div>
    <div class="stat-item">
        <span class="stat-number"><?php echo count($subjects); ?></span>
        <span class="stat-label">Subject Topics</span>
    </div>
</div>

<!-- Materials Grid -->
<div class="materials-section">
    <?php if (empty($filtered_materials)): ?>
        <div class="no-materials">
            <div class="card">
                <div class="no-content">
                    <div class="no-content-icon">📚</div>
                    <?php if (!empty($search_term) || !empty($selected_subject)): ?>
                        <h3>No Materials Found</h3>
                        <p>No study materials match your search criteria.</p>
                        <a href="resources.php" class="btn btn-secondary">View All Materials</a>
                    <?php else: ?>
                        <h3>No Study Materials Available</h3>
                        <p>Your tutor hasn't uploaded any study materials yet. Check back later!</p>
                        <a href="dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    <?php else: ?>
        <div class="materials-grid">
            <?php foreach ($filtered_materials as $material): ?>
                <div class="material-card">
                    <div class="material-header">
                        <div class="material-icon">
                            <?php
                            $extension = pathinfo($material['filename'], PATHINFO_EXTENSION);
                            switch (strtolower($extension)) {
                                case 'pdf':
                                    echo '📄';
                                    $file_type = 'PDF Document';
                                    break;
                                case 'doc':
                                case 'docx':
                                    echo '📝';
                                    $file_type = 'Word Document';
                                    break;
                                case 'ppt':
                                case 'pptx':
                                    echo '📊';
                                    $file_type = 'Presentation';
                                    break;
                                case 'jpg':
                                case 'jpeg':
                                case 'png':
                                    echo '🖼️';
                                    $file_type = 'Image';
                                    break;
                                case 'txt':
                                    echo '📃';
                                    $file_type = 'Text File';
                                    break;
                                default:
                                    echo '📎';
                                    $file_type = 'File';
                            }
                            ?>
                        </div>
                        <div class="file-type"><?php echo $file_type; ?></div>
                    </div>
                    
                    <div class="material-content">
                        <h3 class="material-title"><?php echo htmlspecialchars($material['title']); ?></h3>
                        <p class="material-subject"><?php echo htmlspecialchars($material['subjecttopic']); ?></p>
                        <p class="material-filename"><?php echo htmlspecialchars($material['filename']); ?></p>
                        <p class="material-date">
                            📅 Uploaded: <?php echo formatDate($material['uploaddate']); ?>
                        </p>
                    </div>
                    
                    <div class="material-actions">
                        <a href="<?php echo htmlspecialchars($material['filepath']); ?>" 
                           class="btn btn-primary" 
                           target="_blank">
                           📥 Download
                        </a>
                        <a href="<?php echo htmlspecialchars($material['filepath']); ?>" 
                           class="btn btn-secondary" 
                           target="_blank">
                           👁️ View
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<!-- Study Tips Section -->
<div class="study-tips-section">
    <div class="card">
        <h3>📖 Study Tips</h3>
        <div class="tips-grid">
            <div class="tip-item">
                <h4>📝 Effective Note-Taking</h4>
                <p>Download materials and create your own summary notes. Write key formulas and concepts in your own words.</p>
            </div>
            
            <div class="tip-item">
                <h4>🔄 Regular Practice</h4>
                <p>Practice problems from downloaded worksheets daily. Consistency is key to mastering mathematics.</p>
            </div>
            
            <div class="tip-item">
                <h4>❓ Ask Questions</h4>
                <p>If you don't understand any material, note down your questions for the next class session.</p>
            </div>
            
            <div class="tip-item">
                <h4>📱 Stay Organized</h4>
                <p>Create folders on your device to organize materials by subject and topic for easy access.</p>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="quick-actions-section">
    <div class="card">
        <h3>🚀 Quick Actions</h3>
        <div class="actions-grid">
            <a href="dashboard.php" class="action-card">
                <div class="action-icon">🏠</div>
                <h4>Dashboard</h4>
                <p>Return to your main dashboard</p>
            </a>
            
            <a href="about.php" class="action-card">
                <div class="action-icon">👨‍🏫</div>
                <h4>About Tutor</h4>
                <p>Learn more about your tutor</p>
            </a>
            
            <a href="mailto:ashan.math@gmail.com" class="action-card">
                <div class="action-icon">📧</div>
                <h4>Contact Tutor</h4>
                <p>Send email for questions</p>
            </a>
            
            <a href="tel:+94771234567" class="action-card">
                <div class="action-icon">📞</div>
                <h4>Call Tutor</h4>
                <p>Direct phone contact</p>
            </a>
        </div>
    </div>
</div>

<style>
/* Resources Page Specific Styles */
.search-filter-section {
    margin-bottom: 30px;
}

.search-filter-content {
    padding: 20px;
}

.search-form {
    display: flex;
    gap: 20px;
    align-items: center;
    flex-wrap: wrap;
}

.search-group {
    display: flex;
    gap: 10px;
    flex: 1;
    min-width: 300px;
}

.search-input {
    flex: 1;
    padding: 12px;
    border: 2px solid #ddd;
    border-radius: 6px;
    font-size: 1rem;
}

.search-input:focus {
    outline: none;
    border-color: #3498db;
}

.search-btn {
    padding: 12px 20px;
    background: #3498db;
    color: white;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    font-size: 1rem;
}

.search-btn:hover {
    background: #2980b9;
}

.filter-group {
    min-width: 200px;
}

.filter-select {
    width: 100%;
    padding: 12px;
    border: 2px solid #ddd;
    border-radius: 6px;
    font-size: 1rem;
    background: white;
}

.clear-filters {
    color: #e74c3c;
    text-decoration: none;
    font-weight: 500;
    padding: 12px;
}

.clear-filters:hover {
    text-decoration: underline;
}

.materials-stats {
    display: flex;
    justify-content: center;
    gap: 40px;
    margin-bottom: 30px;
    padding: 20px;
    background: #f8f9fa;
    border-radius: 8px;
}

.stat-item {
    text-align: center;
}

.stat-number {
    display: block;
    font-size: 2rem;
    font-weight: bold;
    color: #3498db;
}

.stat-label {
    color: #7f8c8d;
    font-size: 0.9rem;
}

.materials-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 25px;
    margin-bottom: 40px;
}

.material-card {
    background: white;
    border: 1px solid #e1e8ed;
    border-radius: 10px;
    padding: 25px;
    transition: all 0.3s ease;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}

.material-card:hover {
    border-color: #3498db;
    box-shadow: 0 5px 15px rgba(52, 152, 219, 0.2);
    transform: translateY(-3px);
}

.material-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 20px;
}

.material-icon {
    font-size: 3rem;
    color: #3498db;
}

.file-type {
    background: #ecf0f1;
    padding: 5px 10px;
    border-radius: 15px;
    font-size: 0.8rem;
    color: #7f8c8d;
    font-weight: 500;
}

.material-title {
    color: #2c3e50;
    font-size: 1.2rem;
    margin-bottom: 10px;
    line-height: 1.3;
}

.material-subject {
    color: #3498db;
    font-weight: 600;
    margin-bottom: 8px;
    font-size: 0.95rem;
}

.material-filename {
    color: #7f8c8d;
    font-size: 0.9rem;
    margin-bottom: 8px;
    word-break: break-word;
}

.material-date {
    color: #95a5a6;
    font-size: 0.85rem;
    margin-bottom: 20px;
}

.material-actions {
    display: flex;
    gap: 10px;
}

.material-actions .btn {
    flex: 1;
    text-align: center;
    padding: 10px;
    font-size: 0.9rem;
}

.tips-grid,
.actions-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 20px;
    margin-top: 20px;
}

.tip-item {
    background: #f8f9fa;
    padding: 20px;
    border-radius: 8px;
    border-left: 4px solid #27ae60;
}

.tip-item h4 {
    color: #2c3e50;
    margin-bottom: 10px;
    font-size: 1rem;
}

.tip-item p {
    color: #555;
    font-size: 0.9rem;
    line-height: 1.5;
}

.action-card {
    background: white;
    border: 2px solid #e1e8ed;
    border-radius: 8px;
    padding: 20px;
    text-align: center;
    text-decoration: none;
    color: inherit;
    transition: all 0.3s ease;
}

.action-card:hover {
    border-color: #3498db;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(52, 152, 219, 0.2);
    color: inherit;
    text-decoration: none;
}

.action-icon {
    font-size: 2.5rem;
    margin-bottom: 15px;
}

.action-card h4 {
    color: #2c3e50;
    margin-bottom: 8px;
}

.action-card p {
    color: #7f8c8d;
    font-size: 0.9rem;
}

.no-materials {
    margin-bottom: 40px;
}

@media (max-width: 768px) {
    .search-form {
        flex-direction: column;
        align-items: stretch;
    }
    
    .search-group {
        min-width: auto;
    }
    
    .materials-stats {
        flex-direction: column;
        gap: 20px;
    }
    
    .materials-grid {
        grid-template-columns: 1fr;
    }
    
    .material-actions {
        flex-direction: column;
    }
    
    .tips-grid,
    .actions-grid {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 480px) {
    .search-group {
        flex-direction: column;
    }
    
    .material-header {
        flex-direction: column;
        text-align: center;
        gap: 10px;
    }
}
</style>

<script>
// Resources page JavaScript
document.addEventListener('DOMContentLoaded', function() {
    // Add search functionality
    const searchInput = document.querySelector('.search-input');
    if (searchInput) {
        searchInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                this.form.submit();
            }
        });
    }
    
    // Add download tracking
    const downloadLinks = document.querySelectorAll('.material-actions .btn-primary');
    downloadLinks.forEach(link => {
        link.addEventListener('click', function() {
            const materialTitle = this.closest('.material-card').querySelector('.material-title').textContent;
            console.log('Downloaded: ' + materialTitle);
        });
    });
});
</script>

<?php include 'includes/footer.php'; ?>
