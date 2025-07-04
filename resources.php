<?php
$page_title = "Study Resources";
require_once 'includes/functions.php';

// Check if user is logged in
require_login();

// Get all materials and classes for display
$all_materials = get_all_materials();
$all_classes = get_all_classes();

// Filter materials by class if specified
$selected_class = isset($_GET['class']) ? (int)$_GET['class'] : 0;
$filtered_materials = $all_materials;

if ($selected_class > 0) {
    $filtered_materials = array_filter($all_materials, function($material) use ($selected_class) {
        return $material['class_id'] == $selected_class;
    });
}

require_once 'includes/header.php';
?>

<div class="resources-container">
    <div class="resources-header">
        <h1>Study Resources</h1>
        <p>Access learning materials and resources for your mathematics studies</p>
    </div>
    
    <!-- Filter Section -->
    <div class="filter-section">
        <div class="filter-card">
            <h3>Filter by Class</h3>
            <div class="filter-buttons">
                <a href="resources.php" class="filter-btn <?php echo $selected_class == 0 ? 'active' : ''; ?>">
                    All Materials
                </a>
                <?php foreach ($all_classes as $class): ?>
                    <a href="resources.php?class=<?php echo $class['id']; ?>" 
                       class="filter-btn <?php echo $selected_class == $class['id'] ? 'active' : ''; ?>">
                        <?php echo htmlspecialchars($class['class_name']); ?>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    
    <!-- Materials Section -->
    <div class="materials-section">
        <?php if (!empty($filtered_materials)): ?>
            <div class="materials-count">
                <p>Showing <?php echo count($filtered_materials); ?> material(s)</p>
            </div>
            
            <div class="materials-grid">
                <?php foreach ($filtered_materials as $material): ?>
                    <div class="material-card">
                        <div class="material-header">
                            <div class="material-type-badge <?php echo $material['material_type']; ?>">
                                <?php 
                                $type_icons = [
                                    'pdf' => '📄',
                                    'video' => '🎥',
                                    'document' => '📝',
                                    'link' => '🔗'
                                ];
                                echo $type_icons[$material['material_type']] ?? '📄';
                                ?>
                                <?php echo ucfirst($material['material_type']); ?>
                            </div>
                            <?php if ($material['class_name']): ?>
                                <div class="material-class-badge">
                                    <?php echo htmlspecialchars($material['class_name']); ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <div class="material-content">
                            <h3><?php echo htmlspecialchars($material['title']); ?></h3>
                            <p class="material-description">
                                <?php echo htmlspecialchars($material['description']); ?>
                            </p>
                            
                            <div class="material-meta">
                                <span class="upload-date">
                                     Uploaded: <?php echo format_date($material['uploaded_at']); ?>
                                </span>
                            </div>
                        </div>
                        
                        <div class="material-actions">
                            <?php if ($material['material_type'] == 'link'): ?>
                                <a href="#" class="btn btn-primary" onclick="alert('Link functionality would be implemented here')">
                                     Open Link
                                </a>
                            <?php else: ?>
                                <button class="btn btn-primary" onclick="alert('Download functionality would be implemented here')">
                                     Download
                                </button>
                            <?php endif; ?>
                            
                            <button class="btn btn-secondary" onclick="viewMaterial(<?php echo $material['id']; ?>)">
                                 View Details
                            </button>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="no-materials">
                <div class="no-materials-icon"></div>
                <h3>No Materials Found</h3>
                <p>
                    <?php if ($selected_class > 0): ?>
                        No materials available for the selected class yet.
                    <?php else: ?>
                        No study materials have been uploaded yet.
                    <?php endif; ?>
                </p>
                <a href="resources.php" class="btn btn-primary">View All Materials</a>
            </div>
        <?php endif; ?>
    </div>
    
    <!-- Classes Information -->
    <div class="classes-section">
        <h2>Available Classes</h2>
        <div class="classes-grid">
            <?php foreach ($all_classes as $class): ?>
                <div class="class-summary-card">
                    <h3><?php echo htmlspecialchars($class['class_name']); ?></h3>
                    <p><?php echo htmlspecialchars($class['description']); ?></p>
                    <div class="class-details">
                        <span><strong>Teacher:</strong> <?php echo htmlspecialchars($class['teacher_name']); ?></span>
                        <span><strong>Schedule:</strong> <?php echo htmlspecialchars($class['schedule']); ?></span>
                    </div>
                    <div class="class-materials-count">
                        <?php 
                        $class_materials = array_filter($all_materials, function($material) use ($class) {
                            return $material['class_id'] == $class['id'];
                        });
                        $count = count($class_materials);
                        ?>
                        <span class="materials-count-badge">
                            <?php echo $count; ?> Material<?php echo $count != 1 ? 's' : ''; ?>
                        </span>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<!-- Material Details Modal (Simple) -->
<div id="material-modal" class="modal" style="display: none;">
    <div class="modal-content">
        <div class="modal-header">
            <h3 id="modal-title">Material Details</h3>
            <button class="modal-close" onclick="closeMaterial()">&times;</button>
        </div>
        <div class="modal-body" id="modal-body">
            <!-- Material details will be loaded here -->
        </div>
    </div>
</div>

<style>
/* Resources Page Specific Styles */
body{
    background-color:rgb(9, 19, 33);
}

.resources-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
}

.resources-header {
    background: linear-gradient(135deg,rgb(110, 143, 200),rgb(28, 80, 159));
    color: white;
    padding: 30px;
    border-radius: 10px;
    margin-bottom: 30px;
    text-align: center;
}

.resources-header h1 {
    margin: 0 0 10px 0;
    font-size: 2.2rem;
    color: white;
}

.resources-header p {
    margin: 0;
    font-size: 1.1rem;
    opacity: 0.9;
}

.filter-section {
    margin-bottom: 30px;
}

.filter-card {
    background: rgba(110, 143, 200, 0.65);
    border-radius: 8px;
    padding: 20px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

.filter-card h3 {
    margin: 0 0 15px 0;
    color:rgb(246, 246, 246);
}

.filter-buttons {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
}

.filter-btn {
    padding: 8px 16px;
    background: #f8f9fa;
    color:rgb(61, 65, 68);
    text-decoration: none;
    border-radius: 20px;
    border: 1px solid #e1e8ed;
    transition: all 0.3s ease;
    font-size: 14px;
}

.filter-btn:hover {
    background: #e9ecef;
    color: #2c3e50;
}

.filter-btn.active {
    background:rgb(122, 183, 233);
    color: rgb(20, 51, 74);
    border-color:rgb(182, 188, 192);
}

.materials-section {
    margin-bottom: 30px;
}

.materials-count {
    margin-bottom: 20px;
}

.materials-count p {
    color: #666;
    font-size: 14px;
    margin: 0;
}

.materials-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
    gap: 20px;
}

.material-card {
    background: white;
    border-radius: 8px;
    padding: 20px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    border: 1px solid #e1e8ed;
    transition: transform 0.2s ease;
}

.material-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);
}

.material-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 15px;
}

.material-type-badge {
    padding: 6px 12px;
    border-radius: 15px;
    font-size: 12px;
    font-weight: bold;
    color: white;
}

.material-type-badge.pdf {
    background: #3498db;
}

.material-type-badge.video {
    background: #9b59b6;
}

.material-type-badge.document {
    background: #3498db;
}

.material-type-badge.link {
    background: #f39c12;
}

.material-class-badge {
    background:rgb(72, 134, 170);
    color: white;
    padding: 4px 8px;
    border-radius: 10px;
    font-size: 11px;
    font-weight: bold;
}

.material-content h3 {
    margin: 0 0 10px 0;
    color: #2c3e50;
    font-size: 1.2rem;
}

.material-description {
    color: #666;
    line-height: 1.5;
    margin-bottom: 15px;
}

.material-meta {
    margin-bottom: 15px;
}

.upload-date {
    color: #999;
    font-size: 12px;
}

.material-actions {
    display: flex;
    gap: 10px;
}

.btn {
    padding: 8px 16px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 12px;
    text-decoration: none;
    display: inline-block;
    transition: all 0.3s ease;
}

.btn-primary {
    background:rgb(18, 71, 106);
    color: white;
}

.btn-primary:hover {
    background:rgb(48, 65, 77);
}

.btn-secondary {
    background:rgb(31, 114, 155);
    color: white;
}

.btn-secondary:hover {
    background: #7f8c8d;
}

.no-materials {
    text-align: center;
    padding: 60px 20px;
    background: white;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

.no-materials-icon {
    font-size: 4rem;
    margin-bottom: 20px;
}

.no-materials h3 {
    color: #2c3e50;
    margin-bottom: 10px;
}

.no-materials p {
    color: #666;
    margin-bottom: 20px;
}

.classes-section {
    background: white;
    border-radius: 8px;
    padding: 30px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

.classes-section h2 {
    color: #2c3e50;
    margin-bottom: 20px;
    text-align: center;
}

.classes-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 20px;
}

.class-summary-card {
    background:rgb(240, 241, 244);
    padding: 20px;
    border-radius: 8px;
    border-left: 4px solidrgb(50, 132, 187);
}

.class-summary-card h3 {
    margin: 0 0 10px 0;
    color: #2c3e50;
}

.class-summary-card p {
    color: #666;
    margin-bottom: 15px;
    line-height: 1.5;
}

.class-details {
    display: flex;
    flex-direction: column;
    gap: 5px;
    margin-bottom: 15px;
}

.class-details span {
    font-size: 0.9rem;
    color: #555;
}

.class-materials-count {
    text-align: right;
}

.materials-count-badge {
    background:rgb(56, 90, 113);
    color: white;
    padding: 4px 8px;
    border-radius: 10px;
    font-size: 11px;
    font-weight: bold;
}

/* Simple Modal */
.modal {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    z-index: 1000;
}

.modal-content {
    background: white;
    margin: 50px auto;
    padding: 0;
    border-radius: 8px;
    max-width: 500px;
    max-height: 80vh;
    overflow-y: auto;
}

.modal-header {
    padding: 20px;
    border-bottom: 1px solid #e1e8ed;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.modal-header h3 {
    margin: 0;
    color: #2c3e50;
}

.modal-close {
    background: none;
    border: none;
    font-size: 24px;
    cursor: pointer;
    color: #666;
}

.modal-body {
    padding: 20px;
}

/* Responsive Design */
@media (max-width: 768px) {
    .resources-container {
        padding: 10px;
    }
    
    .resources-header {
        padding: 20px;
    }
    
    .resources-header h1 {
        font-size: 1.8rem;
    }
    
    .materials-grid,
    .classes-grid {
        grid-template-columns: 1fr;
    }
    
    .filter-buttons {
        flex-direction: column;
    }
    
    .material-actions {
        flex-direction: column;
    }
    
    .material-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 10px;
    }
}
</style>

<script>
// Simple material details viewer
function viewMaterial(materialId) {
    // In a real implementation, this would fetch material details via AJAX
    const modal = document.getElementById('material-modal');
    const modalTitle = document.getElementById('modal-title');
    const modalBody = document.getElementById('modal-body');
    
    modalTitle.textContent = 'Material Details';
    modalBody.innerHTML = `
        <p><strong>Material ID:</strong> ${materialId}</p>
        <p><strong>Note:</strong> Detailed material information would be displayed here.</p>
        <p>This is a simplified implementation for demonstration purposes.</p>
    `;
    
    modal.style.display = 'block';
}

function closeMaterial() {
    document.getElementById('material-modal').style.display = 'none';
}

// Close modal when clicking outside
window.onclick = function(event) {
    const modal = document.getElementById('material-modal');
    if (event.target == modal) {
        modal.style.display = 'none';
    }
}
</script>

<?php require_once 'includes/footer.php'; ?>
