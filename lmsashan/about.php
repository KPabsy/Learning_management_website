<?php
// Include required files
require_once 'includes/config.php';
require_once 'includes/functions.php';

// Get testimonials from database
$testimonials = getTestimonials();

$page_title = "About Tutor";
?>

<?php include 'includes/header.php'; ?>

<div class="page-header">
    <h2>About Your Mathematics Tutor</h2>
    <p>Meet Ashan Sudusinghe - Your dedicated mathematics educator</p>
</div>

<!-- Tutor Profile Section -->
<div class="tutor-profile">
    <div class="card">
        <div class="profile-header">
            <div class="profile-image">
                <div class="profile-avatar">👨‍🏫</div>
            </div>
            <div class="profile-info">
                <h2>Ashan Sudusinghe</h2>
                <h3>Professional Mathematics Tutor</h3>
                <p class="profile-subtitle">Specialized in Advanced Level & Ordinary Level Mathematics</p>
            </div>
        </div>
        
        <div class="profile-content">
            <div class="about-section">
                <h3>📚 About Me</h3>
                <p>Welcome to my mathematics tutoring service! I am Ashan Sudusinghe, a dedicated and experienced mathematics tutor with a passion for helping students excel in their mathematical journey. With years of teaching experience, I have helped hundreds of students achieve their academic goals and develop a genuine love for mathematics.</p>
                
                <p>My teaching philosophy centers around making mathematics accessible, understandable, and enjoyable for every student. I believe that every student has the potential to succeed in mathematics with the right guidance, practice, and encouragement.</p>
            </div>
            
            <div class="qualifications-section">
                <h3>🎓 Qualifications & Experience</h3>
                <div class="qualifications-grid">
                    <div class="qualification-item">
                        <h4>Educational Background</h4>
                        <ul>
                            <li>Bachelor's Degree in Mathematics</li>
                            <li>Teaching Diploma in Secondary Education</li>
                            <li>Advanced Level Mathematics - A Grade</li>
                            <li>Continuous Professional Development Courses</li>
                        </ul>
                    </div>
                    
                    <div class="qualification-item">
                        <h4>Teaching Experience</h4>
                        <ul>
                            <li>8+ years of private tutoring experience</li>
                            <li>500+ students successfully guided</li>
                            <li>Specialized in A/L and O/L Mathematics</li>
                            <li>Cambridge Mathematics curriculum expert</li>
                        </ul>
                    </div>
                </div>
            </div>
            
            <div class="subjects-section">
                <h3>📖 Subjects Offered</h3>
                <div class="subjects-grid">
                    <div class="subject-card">
                        <div class="subject-icon">🎯</div>
                        <h4>Advanced Level Mathematics</h4>
                        <p>Pure Mathematics, Applied Mathematics, and Statistics for A/L students</p>
                    </div>
                    
                    <div class="subject-card">
                        <div class="subject-icon">📐</div>
                        <h4>Ordinary Level Mathematics</h4>
                        <p>Complete O/L Mathematics syllabus with exam preparation</p>
                    </div>
                    
                    <div class="subject-card">
                        <div class="subject-icon">🔢</div>
                        <h4>Grade 6-11 Mathematics</h4>
                        <p>Foundation mathematics for middle and high school students</p>
                    </div>
                    
                    <div class="subject-card">
                        <div class="subject-icon">🌍</div>
                        <h4>Cambridge Mathematics</h4>
                        <p>International curriculum mathematics for Cambridge students</p>
                    </div>
                </div>
            </div>
            
            <div class="teaching-approach">
                <h3>🎯 Teaching Approach</h3>
                <div class="approach-grid">
                    <div class="approach-item">
                        <h4>Personalized Learning</h4>
                        <p>Each student receives individual attention with customized lesson plans tailored to their learning style and pace.</p>
                    </div>
                    
                    <div class="approach-item">
                        <h4>Practical Application</h4>
                        <p>Mathematics concepts are taught through real-world examples and practical applications to enhance understanding.</p>
                    </div>
                    
                    <div class="approach-item">
                        <h4>Regular Assessment</h4>
                        <p>Continuous evaluation through practice tests and assignments to track progress and identify areas for improvement.</p>
                    </div>
                    
                    <div class="approach-item">
                        <h4>Exam Preparation</h4>
                        <p>Comprehensive exam preparation with past papers, time management techniques, and effective study strategies.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Contact Information -->
<div class="contact-section">
    <div class="card">
        <h3>📞 Contact Information</h3>
        <div class="contact-grid">
            <div class="contact-item">
                <div class="contact-icon">📱</div>
                <h4>Phone</h4>
                <p>+94 77 123 4567</p>
                <a href="tel:+94771234567" class="btn btn-secondary">Call Now</a>
            </div>
            
            <div class="contact-item">
                <div class="contact-icon">📧</div>
                <h4>Email</h4>
                <p>ashan.math@gmail.com</p>
                <a href="mailto:ashan.math@gmail.com" class="btn btn-secondary">Send Email</a>
            </div>
            
            <div class="contact-item">
                <div class="contact-icon">📍</div>
                <h4>Location</h4>
                <p>Colombo, Sri Lanka</p>
                <p class="location-note">Home visits available in Colombo area</p>
            </div>
            
            <div class="contact-item">
                <div class="contact-icon">⏰</div>
                <h4>Class Hours</h4>
                <p><strong>Weekdays:</strong> 4:00 PM - 8:00 PM</p>
                <p><strong>Weekends:</strong> 9:00 AM - 5:00 PM</p>
            </div>
        </div>
    </div>
</div>

<!-- Student Testimonials -->
<div class="testimonials-section">
    <div class="card">
        <div class="section-header">
            <h3>🌟 Student Testimonials</h3>
            <p>What my students say about their learning experience</p>
        </div>
        
        <div class="testimonials-grid">
            <?php if (empty($testimonials)): ?>
                <div class="no-testimonials">
                    <div class="no-content-icon">💬</div>
                    <h4>No Testimonials Yet</h4>
                    <p>Student testimonials will appear here once they are added.</p>
                </div>
            <?php else: ?>
                <?php foreach ($testimonials as $testimonial): ?>
                    <div class="testimonial-card">
                        <div class="testimonial-content">
                            <div class="quote-icon">"</div>
                            <p class="testimonial-text"><?php echo htmlspecialchars($testimonial['testimonial']); ?></p>
                        </div>
                        <div class="testimonial-author">
                            <h4><?php echo htmlspecialchars($testimonial['studentname']); ?></h4>
                            <p><?php echo htmlspecialchars($testimonial['school']); ?></p>
                            <span class="testimonial-date"><?php echo formatDate($testimonial['createdat']); ?></span>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Call to Action -->
<div class="cta-section">
    <div class="card cta-card">
        <h3>Ready to Excel in Mathematics?</h3>
        <p>Join hundreds of students who have improved their mathematics skills with personalized tutoring</p>
        <div class="cta-buttons">
            <?php if (isLoggedIn()): ?>
                <a href="dashboard.php" class="btn btn-primary">Go to Dashboard</a>
                <a href="resources.php" class="btn btn-secondary">View Study Materials</a>
            <?php else: ?>
                <a href="login.php" class="btn btn-primary">Student Login</a>
                <a href="tel:+94771234567" class="btn btn-secondary">Call for Inquiry</a>
            <?php endif; ?>
        </div>
    </div>
</div>

<style>
/* About Page Specific Styles */
.tutor-profile {
    margin-bottom: 40px;
}

.profile-header {
    display: flex;
    align-items: center;
    margin-bottom: 30px;
    padding-bottom: 20px;
    border-bottom: 2px solid #ecf0f1;
}

.profile-image {
    margin-right: 30px;
}

.profile-avatar {
    width: 120px;
    height: 120px;
    background: linear-gradient(135deg, #3498db, #2980b9);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 3rem;
    color: white;
}

.profile-info h2 {
    color: #2c3e50;
    font-size: 2.2rem;
    margin-bottom: 5px;
}

.profile-info h3 {
    color: #3498db;
    font-size: 1.3rem;
    margin-bottom: 10px;
    font-weight: normal;
}

.profile-subtitle {
    color: #7f8c8d;
    font-size: 1rem;
}

.about-section {
    margin-bottom: 30px;
}

.about-section h3 {
    color: #2c3e50;
    margin-bottom: 15px;
    font-size: 1.4rem;
}

.about-section p {
    line-height: 1.6;
    margin-bottom: 15px;
}

.qualifications-grid,
.subjects-grid,
.approach-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 20px;
    margin-top: 20px;
}

.qualification-item,
.subject-card,
.approach-item {
    background: #f8f9fa;
    padding: 20px;
    border-radius: 8px;
    border-left: 4px solid #3498db;
}

.qualification-item h4,
.approach-item h4 {
    color: #2c3e50;
    margin-bottom: 15px;
}

.qualification-item ul {
    list-style: none;
    padding: 0;
}

.qualification-item li {
    padding: 5px 0;
    color: #555;
    position: relative;
    padding-left: 20px;
}

.qualification-item li:before {
    content: "✓";
    color: #27ae60;
    font-weight: bold;
    position: absolute;
    left: 0;
}

.subject-card {
    text-align: center;
    border-left-color: #27ae60;
}

.subject-icon {
    font-size: 2.5rem;
    margin-bottom: 15px;
}

.subject-card h4 {
    color: #2c3e50;
    margin-bottom: 10px;
}

.contact-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 25px;
    margin-top: 20px;
}

.contact-item {
    text-align: center;
    padding: 20px;
    background: #f8f9fa;
    border-radius: 8px;
}

.contact-icon {
    font-size: 2.5rem;
    margin-bottom: 15px;
}

.contact-item h4 {
    color: #2c3e50;
    margin-bottom: 10px;
}

.location-note {
    font-size: 0.9rem;
    color: #7f8c8d;
    font-style: italic;
}

.testimonials-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 25px;
    margin-top: 20px;
}

.testimonial-card {
    background: #f8f9fa;
    padding: 25px;
    border-radius: 8px;
    border-left: 4px solid #f39c12;
    position: relative;
}

.quote-icon {
    font-size: 3rem;
    color: #f39c12;
    position: absolute;
    top: 10px;
    right: 20px;
    opacity: 0.3;
}

.testimonial-text {
    font-style: italic;
    margin-bottom: 20px;
    color: #555;
    line-height: 1.6;
}

.testimonial-author h4 {
    color: #2c3e50;
    margin-bottom: 5px;
}

.testimonial-author p {
    color: #3498db;
    margin-bottom: 5px;
    font-weight: 500;
}

.testimonial-date {
    color: #7f8c8d;
    font-size: 0.9rem;
}

.cta-card {
    background: linear-gradient(135deg, #3498db, #2980b9);
    color: white;
    text-align: center;
    padding: 40px;
}

.cta-card h3 {
    color: white;
    font-size: 1.8rem;
    margin-bottom: 15px;
}

.cta-card p {
    color: rgba(255, 255, 255, 0.9);
    font-size: 1.1rem;
    margin-bottom: 25px;
}

.cta-buttons {
    display: flex;
    gap: 15px;
    justify-content: center;
    flex-wrap: wrap;
}

.no-testimonials {
    grid-column: 1 / -1;
    text-align: center;
    padding: 40px;
    color: #7f8c8d;
}

@media (max-width: 768px) {
    .profile-header {
        flex-direction: column;
        text-align: center;
    }
    
    .profile-image {
        margin-right: 0;
        margin-bottom: 20px;
    }
    
    .qualifications-grid,
    .subjects-grid,
    .approach-grid,
    .contact-grid,
    .testimonials-grid {
        grid-template-columns: 1fr;
    }
    
    .cta-buttons {
        flex-direction: column;
        align-items: center;
    }
}
</style>

<?php include 'includes/footer.php'; ?>
