<?php
$page_title = "About Ashan Sudusinghe";
require_once 'includes/functions.php';

// Get approved testimonials for display
$testimonials = get_approved_testimonials();

require_once 'includes/header.php';
?>

<div class="about-container">
    <!-- Tutor Profile Section -->
    <div class="profile-section">
        <div class="profile-header">
            <div class="profile-image">
                <div class="image-placeholder">
                    <span><img src="Resources/01.jpg" width="180px"></span>
                </div>
            </div>
            <div class="profile-info">
                <h1>Ashan Sudusingha</h1>                
                <p class="profile-tagline">සංකීර්ණ ගණිතය සරලව ඉගෙනගන්න....</p>
            </div>
        </div>
        
        <div class="profile-content">
            <div class="about-text">
                <h3>About Me</h3>
                <p>Welcome to my mathematics tutoring platform! I’m Ashan Sudusinghe, and I love helping students do well in math.</p>
                
                <p>I have many years of experience teaching math at different levels. I focus on making hard ideas easier to understand. My teaching helps students build strong basics and good problem-solving skills that they can use in school and beyond.</p>
                
                <p>I believe every student can succeed in math with the right help. My goal is to create a friendly, supportive space where students feel comfortable to ask questions and learn at their own speed.</p>
            </div>
            
            <div class="qualifications">
                <h3>Qualifications & Experience</h3>
                <ul>
                    <li>5+ years of tutoring experience</li>
                    <li>Specialized in Grade 10, 11, and A/L Mathematics</li>
                    <li>Proven track record of student success</li>
                    <li>Expert in Algebra, Geometry, and Calculus</li>
                </ul>
            </div>
        </div>
    </div>
    
    <!-- Teaching Approach Section -->
    <div class="approach-section">
        <h2>My Teaching Approach</h2>
        <div class="approach-grid">
            <div class="approach-item">
                <div class="approach-icon"></div>
                <h3>Personalized Learning</h3>
                <p>Tailored lessons to match each student's learning style and pace</p>
            </div>
            
            <div class="approach-item">
                <div class="approach-icon"></div>
                <h3>Goal-Oriented</h3>
                <p>Focus on specific academic goals and exam preparation</p>
            </div>
            
            <div class="approach-item">
                <div class="approach-icon"></div>
                <h3>Concept Clarity</h3>
                <p>Emphasis on understanding concepts rather than memorization</p>
            </div>
            
            <div class="approach-item">
                <div class="approach-icon"></div>
                <h3>Supportive Environment</h3>
                <p>Encouraging atmosphere where students feel comfortable to learn</p>
            </div>
        </div>
    </div>
    
    <!-- Class Information Section -->
    <div class="classes-info-section">
        <h2>Classes Offered</h2>
        <div class="classes-info-grid">
            <div class="class-info-card">
                <h3>Grade 10 Mathematics</h3>
                <p>Comprehensive coverage of Grade 10 syllabus including algebra, geometry, and trigonometry</p>
                <div class="class-schedule">
                    <strong>Schedule:</strong> Monday & Wednesday, 4:00 PM - 6:00 PM
                </div>
            </div>
            
            <div class="class-info-card">
                <h3>Grade 11 Mathematics</h3>
                <p>Advanced mathematical concepts preparing students for A/L examinations</p>
                <div class="class-schedule">
                    <strong>Schedule:</strong> Tuesday & Thursday, 4:00 PM - 6:00 PM
                </div>
            </div>
            
            <div class="class-info-card">
                <h3>A/L Mathematics</h3>
                <p>Intensive preparation for Advanced Level mathematics examinations</p>
                <div class="class-schedule">
                    <strong>Schedule:</strong> Saturday, 2:00 PM - 5:00 PM
                </div>
            </div>
        </div>
    </div>
    
    <!-- Testimonials Section -->
    <div class="testimonials-section">
        <h2>What Students Say</h2>
        <?php if (!empty($testimonials)): ?>
            <div class="testimonials-grid">
                <?php foreach ($testimonials as $testimonial): ?>
                    <div class="testimonial-card">
                        <div class="testimonial-content">
                            <p>"<?php echo htmlspecialchars($testimonial['message']); ?>"</p>
                        </div>
                        <div class="testimonial-footer">
                            <div class="testimonial-author">
                                <strong><?php echo htmlspecialchars($testimonial['student_name']); ?></strong>
                            </div>                            
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="no-testimonials">
                <p>No testimonials available yet. Be the first to share your experience!</p>
            </div>
        <?php endif; ?>
    </div>
    
    <!-- Contact Section -->
    <div class="contact-section">
        <h2>Get In Touch</h2>
        <div class="contact-info">
            <div class="contact-item">
                <div class="contact-icon"></div>
                <div class="contact-details">
                    <h3>Email</h3>
                    <p>ashansudusingha@gmail.com</p>
                </div>
            </div>
            
            <div class="contact-item">
                <div class="contact-icon"></div>
                <div class="contact-details">
                    <h3>Phone</h3>
                    <p>+94 76 446 3937</p>
                </div>
            </div>
            
            <div class="contact-item">
                <div class="contact-icon"></div>
                <div class="contact-details">
                    <h3>Location</h3>
                    <p>Jonik Waththa, Kiribathgoda</p>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* About Page Specific Styles */
body{
    background-color:rgb(9, 19, 33);
}

.about-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
}

.profile-section {
    background: rgba(255, 255, 255, 0.96);
    border-radius: 10px;
    padding: 30px;
    margin-bottom: 30px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

.profile-header {
    display: flex;
    align-items: center;
    gap: 30px;
    margin-bottom: 30px;
}

.profile-image {
    flex-shrink: 0;
}

.image-placeholder img {
    width: 150px;
    height: 150px;
    background: linear-gradient(135deg, #3498db, #2980b9);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 3rem;
    font-weight: bold;
}

.profile-info h1 {
    margin: 0 0 10px 0;
    color: #2c3e50;
    font-size: 2.5rem;
}

.profile-info h2 {
    margin: 0 0 15px 0;
    color: #3498db;
    font-size: 1.5rem;
    font-weight: normal;
}

.profile-tagline {
    color: #666;
    font-size: 1.1rem;
    font-style: italic;
    margin: 0;
}

.profile-content {
    display: grid;
    grid-template-columns: 2fr 1fr;
    gap: 30px;
}

.about-text h3,
.qualifications h3 {
    color: #2c3e50;
    margin-bottom: 15px;
    font-size: 1.3rem;
}

.about-text p {
    color: #555;
    line-height: 1.6;
    margin-bottom: 15px;
}

.qualifications ul {
    list-style: none;
    padding: 0;
}

.qualifications li {
    background: #f8f9fa;
    padding: 10px 15px;
    margin-bottom: 8px;
    border-radius: 5px;
    border-left: 4px solid black;
    color: #555;
}

.approach-section {
    background: white;
    border-radius: 10px;
    padding: 30px;
    margin-bottom: 30px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

.approach-section h2 {
    text-align: center;
    color: #2c3e50;
    margin-bottom: 30px;
    font-size: 2rem;
}

.approach-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 20px;
}

.approach-item {
    text-align: center;
    padding: 20px;
    background: #f8f9fa;
    border-radius: 8px;
    border: 1px solid #e1e8ed;
}

.approach-icon {
    font-size: 3rem;
    margin-bottom: 15px;
}

.approach-item h3 {
    color: #2c3e50;
    margin-bottom: 10px;
}

.approach-item p {
    color: #666;
    line-height: 1.5;
}

.classes-info-section {
    background: white;
    border-radius: 10px;
    padding: 30px;
    margin-bottom: 30px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

.classes-info-section h2 {
    text-align: center;
    color: #2c3e50;
    margin-bottom: 30px;
    font-size: 2rem;
}

.classes-info-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 20px;
}

.class-info-card {
    background: #f8f9fa;
    padding: 20px;
    border-radius: 8px;
    border-left: 4px solid black;
}

.class-info-card h3 {
    color: #2c3e50;
    margin-bottom: 10px;
}

.class-info-card p {
    color: #666;
    margin-bottom: 15px;
    line-height: 1.5;
}

.class-schedule {
    color:rgb(39, 129, 174);
    font-size: 0.9rem;
}

.testimonials-section {
    background: white;
    border-radius: 10px;
    padding: 30px;
    margin-bottom: 30px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

.testimonials-section h2 {
    text-align: center;
    color: #2c3e50;
    margin-bottom: 30px;
    font-size: 2rem;
}

.testimonials-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 20px;
}

.testimonial-card {
    background: #f8f9fa;
    padding: 20px;
    border-radius: 8px;
    border-left: 4px solid gray;
}

.testimonial-content p {
    color: #555;
    font-style: italic;
    line-height: 1.6;
    margin-bottom: 15px;
}

.testimonial-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.testimonial-author strong {
    color: #2c3e50;
}

.testimonial-rating {
    display: flex;
    gap: 2px;
}

.star {
    color: #ddd;
    font-size: 1.2rem;
}

.star.filled {
    color: #f39c12;
}

.no-testimonials {
    text-align: center;
    padding: 40px;
    color: #666;
    font-style: italic;
}

.contact-section {
    background: white;
    border-radius: 10px;
    padding: 30px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

.contact-section h2 {
    text-align: center;
    color: #2c3e50;
    margin-bottom: 30px;
    font-size: 2rem;
}

.contact-info {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 20px;
}

.contact-item {
    display: flex;
    align-items: center;
    gap: 15px;
    padding: 20px;
    background: #f8f9fa;
    border-radius: 8px;
    border-left: 4px solid teal;
}

.contact-icon {
    font-size: 2rem;
    min-width: 50px;
    text-align: center;
}

.contact-details h3 {
    margin: 0 0 5px 0;
    color: #2c3e50;
}

.contact-details p {
    margin: 0;
    color: #666;
}

/* Responsive Design */
@media (max-width: 768px) {
    .about-container {
        padding: 10px;
    }
    
    .profile-header {
        flex-direction: column;
        text-align: center;
        gap: 20px;
    }
    
    .profile-content {
        grid-template-columns: 1fr;
        gap: 20px;
    }
    
    .profile-info h1 {
        font-size: 2rem;
    }
    
    .approach-grid,
    .classes-info-grid,
    .testimonials-grid {
        grid-template-columns: 1fr;
    }
    
    .contact-item {
        flex-direction: column;
        text-align: center;
    }
}
</style>

<?php require_once 'includes/footer.php'; ?>
