// Form validation functions for LMS

// Initialize validation when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    initializeValidation();
});

// Main validation initialization
function initializeValidation() {
    // Find all forms and add validation
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        setupFormValidation(form);
    });
    
    // Setup real-time validation for inputs
    const inputs = document.querySelectorAll('input, textarea, select');
    inputs.forEach(input => {
        setupInputValidation(input);
    });
}

// Setup validation for a specific form
function setupFormValidation(form) {
    form.addEventListener('submit', function(e) {
        if (!validateForm(this)) {
            e.preventDefault();
            showValidationSummary(this);
        }
    });
}

// Setup validation for individual inputs
function setupInputValidation(input) {
    // Validate on blur (when user leaves the field)
    input.addEventListener('blur', function() {
        validateInput(this);
    });
    
    // Clear error on focus
    input.addEventListener('focus', function() {
        clearInputError(this);
    });
    
    // Real-time validation for certain fields
    if (input.type === 'email' || input.name === 'username') {
        input.addEventListener('input', function() {
            // Debounce the validation
            clearTimeout(this.validationTimeout);
            this.validationTimeout = setTimeout(() => {
                validateInput(this);
            }, 500);
        });
    }
}

// Validate entire form
function validateForm(form) {
    let isValid = true;
    const inputs = form.querySelectorAll('input, textarea, select');
    
    // Clear previous validation summary
    clearValidationSummary(form);
    
    inputs.forEach(input => {
        if (!validateInput(input)) {
            isValid = false;
        }
    });
    
    return isValid;
}

// Validate individual input
function validateInput(input) {
    const value = input.value.trim();
    const inputType = input.type;
    const inputName = input.name;
    const isRequired = input.hasAttribute('required');
    
    // Clear previous errors
    clearInputError(input);
    
    // Required field validation
    if (isRequired && value === '') {
        showInputError(input, 'This field is required');
        return false;
    }
    
    // Skip further validation if field is empty and not required
    if (value === '' && !isRequired) {
        return true;
    }
    
    // Specific validation based on input type and name
    switch (inputType) {
        case 'email':
            return validateEmail(input, value);
        case 'password':
            return validatePassword(input, value);
        case 'tel':
            return validatePhone(input, value);
        default:
            // Check by input name
            switch (inputName) {
                case 'username':
                    return validateUsername(input, value);
                case 'phone':
                    return validatePhone(input, value);
                case 'fullname':
                    return validateFullName(input, value);
                case 'school':
                    return validateSchool(input, value);
                case 'subjecttopic':
                    return validateSubjectTopic(input, value);
                default:
                    return validateGeneral(input, value);
            }
    }
}

// Email validation
function validateEmail(input, value) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    
    if (!emailRegex.test(value)) {
        showInputError(input, 'Please enter a valid email address');
        return false;
    }
    
    return true;
}

// Password validation
function validatePassword(input, value) {
    if (value.length < 6) {
        showInputError(input, 'Password must be at least 6 characters long');
        return false;
    }
    
    if (value.length > 50) {
        showInputError(input, 'Password must be less than 50 characters');
        return false;
    }
    
    return true;
}

// Username validation
function validateUsername(input, value) {
    if (value.length < 3) {
        showInputError(input, 'Username must be at least 3 characters long');
        return false;
    }
    
    if (value.length > 20) {
        showInputError(input, 'Username must be less than 20 characters');
        return false;
    }
    
    const usernameRegex = /^[a-zA-Z0-9_]+$/;
    if (!usernameRegex.test(value)) {
        showInputError(input, 'Username can only contain letters, numbers, and underscores');
        return false;
    }
    
    return true;
}

// Phone validation
function validatePhone(input, value) {
    // Remove all non-digit characters for validation
    const cleanPhone = value.replace(/\D/g, '');
    
    if (cleanPhone.length < 10) {
        showInputError(input, 'Phone number must be at least 10 digits');
        return false;
    }
    
    if (cleanPhone.length > 15) {
        showInputError(input, 'Phone number must be less than 15 digits');
        return false;
    }
    
    return true;
}

// Full name validation
function validateFullName(input, value) {
    if (value.length < 2) {
        showInputError(input, 'Full name must be at least 2 characters long');
        return false;
    }
    
    if (value.length > 50) {
        showInputError(input, 'Full name must be less than 50 characters');
        return false;
    }
    
    const nameRegex = /^[a-zA-Z\s.'-]+$/;
    if (!nameRegex.test(value)) {
        showInputError(input, 'Full name can only contain letters, spaces, dots, hyphens, and apostrophes');
        return false;
    }
    
    return true;
}

// School validation
function validateSchool(input, value) {
    if (value.length < 2) {
        showInputError(input, 'School name must be at least 2 characters long');
        return false;
    }
    
    if (value.length > 100) {
        showInputError(input, 'School name must be less than 100 characters');
        return false;
    }
    
    return true;
}

// Subject topic validation
function validateSubjectTopic(input, value) {
    if (value.length < 3) {
        showInputError(input, 'Subject topic must be at least 3 characters long');
        return false;
    }
    
    if (value.length > 100) {
        showInputError(input, 'Subject topic must be less than 100 characters');
        return false;
    }
    
    return true;
}

// General validation for text inputs
function validateGeneral(input, value) {
    const maxLength = input.getAttribute('maxlength');
    const minLength = input.getAttribute('minlength');
    
    if (minLength && value.length < parseInt(minLength)) {
        showInputError(input, `Must be at least ${minLength} characters long`);
        return false;
    }
    
    if (maxLength && value.length > parseInt(maxLength)) {
        showInputError(input, `Must be less than ${maxLength} characters long`);
        return false;
    }
    
    return true;
}

// Show input error
function showInputError(input, message) {
    input.classList.add('error');
    
    // Remove existing error message
    const existingError = input.parentNode.querySelector('.error-message');
    if (existingError) {
        existingError.remove();
    }
    
    // Create new error message
    const errorElement = document.createElement('span');
    errorElement.className = 'error-message';
    errorElement.textContent = message;
    
    // Insert error message after the input
    input.parentNode.appendChild(errorElement);
    
    // Add shake animation
    input.style.animation = 'shake 0.5s ease-in-out';
    setTimeout(() => {
        input.style.animation = '';
    }, 500);
}

// Clear input error
function clearInputError(input) {
    input.classList.remove('error');
    
    const errorMessage = input.parentNode.querySelector('.error-message');
    if (errorMessage) {
        errorMessage.remove();
    }
}

// Show validation summary
function showValidationSummary(form) {
    const errors = form.querySelectorAll('.error-message');
    
    if (errors.length > 0) {
        const errorMessages = Array.from(errors).map(error => error.textContent);
        const uniqueMessages = [...new Set(errorMessages)];
        
        let summaryText = 'Please fix the following errors:\n';
        uniqueMessages.forEach((message, index) => {
            summaryText += `${index + 1}. ${message}\n`;
        });
        
        alert(summaryText);
        
        // Focus on first error field
        const firstErrorField = form.querySelector('.error');
        if (firstErrorField) {
            firstErrorField.focus();
        }
    }
}

// Clear validation summary
function clearValidationSummary(form) {
    const errorMessages = form.querySelectorAll('.error-message');
    errorMessages.forEach(error => error.remove());
    
    const errorFields = form.querySelectorAll('.error');
    errorFields.forEach(field => field.classList.remove('error'));
}

// Login form specific validation
function validateLoginForm(form) {
    const username = form.querySelector('[name="username"]');
    const password = form.querySelector('[name="password"]');
    
    let isValid = true;
    
    if (!username.value.trim()) {
        showInputError(username, 'Username is required');
        isValid = false;
    }
    
    if (!password.value.trim()) {
        showInputError(password, 'Password is required');
        isValid = false;
    }
    
    return isValid;
}

// Student registration form validation
function validateStudentForm(form) {
    const requiredFields = ['username', 'email', 'password', 'fullname', 'phone', 'school'];
    let isValid = true;
    
    requiredFields.forEach(fieldName => {
        const field = form.querySelector(`[name="${fieldName}"]`);
        if (field && !validateInput(field)) {
            isValid = false;
        }
    });
    
    return isValid;
}

// Class form validation
function validateClassForm(form) {
    const requiredFields = ['classdate', 'classtime', 'subjecttopic'];
    let isValid = true;
    
    requiredFields.forEach(fieldName => {
        const field = form.querySelector(`[name="${fieldName}"]`);
        if (field && !validateInput(field)) {
            isValid = false;
        }
    });
    
    // Validate date is not in the past
    const dateField = form.querySelector('[name="classdate"]');
    if (dateField && dateField.value) {
        const selectedDate = new Date(dateField.value);
        const today = new Date();
        today.setHours(0, 0, 0, 0);
        
        if (selectedDate < today) {
            showInputError(dateField, 'Class date cannot be in the past');
            isValid = false;
        }
    }
    
    return isValid;
}

// Utility functions
function formatPhoneNumber(input) {
    let value = input.value.replace(/\D/g, '');
    
    if (value.length >= 10) {
        value = value.substring(0, 10);
        value = value.replace(/(\d{3})(\d{3})(\d{4})/, '($1) $2-$3');
    }
    
    input.value = value;
}

// Add CSS for shake animation
const style = document.createElement('style');
style.textContent = `
    @keyframes shake {
        0%, 100% { transform: translateX(0); }
        10%, 30%, 50%, 70%, 90% { transform: translateX(-5px); }
        20%, 40%, 60%, 80% { transform: translateX(5px); }
    }
    
    .error {
        border-color: #e74c3c !important;
        box-shadow: 0 0 0 3px rgba(231, 76, 60, 0.1) !important;
    }
    
    .error-message {
        color: #e74c3c;
        font-size: 0.85rem;
        margin-top: 5px;
        display: block;
        animation: fadeIn 0.3s ease-in-out;
    }
    
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-5px); }
        to { opacity: 1; transform: translateY(0); }
    }
`;
document.head.appendChild(style);

// Export functions for global use
window.validateForm = validateForm;
window.validateInput = validateInput;
window.validateLoginForm = validateLoginForm;
window.validateStudentForm = validateStudentForm;
window.validateClassForm = validateClassForm;
window.formatPhoneNumber = formatPhoneNumber;
