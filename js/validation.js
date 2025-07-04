// Simple form validation functions for LMS

// Initialize validation when DOM is ready
document.addEventListener('DOMContentLoaded', function() {
    setupFormValidation();
});

// Setup validation for all forms
function setupFormValidation() {
    const forms = document.querySelectorAll('form');
    
    forms.forEach(function(form) {
        // Add validation on form submit
        form.addEventListener('submit', function(e) {
            if (!validateForm(this)) {
                e.preventDefault();
            }
        });
        
        // Add real-time validation for inputs
        const inputs = form.querySelectorAll('input, textarea, select');
        inputs.forEach(function(input) {
            input.addEventListener('blur', function() {
                validateField(this);
            });
            
            input.addEventListener('input', function() {
                clearFieldError(this);
            });
        });
    });
}

// Main form validation function
function validateForm(form) {
    let isValid = true;
    const fields = form.querySelectorAll('input, textarea, select');
    
    fields.forEach(function(field) {
        if (!validateField(field)) {
            isValid = false;
        }
    });
    
    return isValid;
}

// Validate individual field
function validateField(field) {
    const value = field.value.trim();
    const fieldType = field.type;
    const isRequired = field.hasAttribute('required');
    
    // Clear previous errors
    clearFieldError(field);
    
    // Check if required field is empty
    if (isRequired && value === '') {
        showFieldError(field, 'This field is required.');
        return false;
    }
    
    // Skip validation if field is empty and not required
    if (value === '' && !isRequired) {
        return true;
    }
    
    // Validate based on field type
    switch (fieldType) {
        case 'email':
            return validateEmail(field);
        case 'password':
            return validatePassword(field);
        case 'text':
            return validateText(field);
        case 'number':
            return validateNumber(field);
        default:
            return true;
    }
}

// Email validation
function validateEmail(field) {
    const email = field.value.trim();
    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    
    if (!emailPattern.test(email)) {
        showFieldError(field, 'Please enter a valid email address.');
        return false;
    }
    
    return true;
}

// Password validation
function validatePassword(field) {
    const password = field.value;
    const minLength = 6;
    
    if (password.length < minLength) {
        showFieldError(field, `Password must be at least ${minLength} characters long.`);
        return false;
    }
    
    return true;
}

// Text validation
function validateText(field) {
    const text = field.value.trim();
    const fieldName = field.getAttribute('name');
    
    // Username validation
    if (fieldName === 'username') {
        if (text.length < 3) {
            showFieldError(field, 'Username must be at least 3 characters long.');
            return false;
        }
        
        const usernamePattern = /^[a-zA-Z0-9_]+$/;
        if (!usernamePattern.test(text)) {
            showFieldError(field, 'Username can only contain letters, numbers, and underscores.');
            return false;
        }
    }
    
    // Full name validation
    if (fieldName === 'full_name') {
        if (text.length < 2) {
            showFieldError(field, 'Full name must be at least 2 characters long.');
            return false;
        }
    }
    
    return true;
}

// Number validation
function validateNumber(field) {
    const value = field.value;
    const min = field.getAttribute('min');
    const max = field.getAttribute('max');
    
    if (isNaN(value)) {
        showFieldError(field, 'Please enter a valid number.');
        return false;
    }
    
    if (min && parseFloat(value) < parseFloat(min)) {
        showFieldError(field, `Value must be at least ${min}.`);
        return false;
    }
    
    if (max && parseFloat(value) > parseFloat(max)) {
        showFieldError(field, `Value must be no more than ${max}.`);
        return false;
    }
    
    return true;
}

// Show field error
function showFieldError(field, message) {
    field.style.borderColor = '#e74c3c';
    
    // Remove existing error message
    const existingError = field.parentNode.querySelector('.field-error');
    if (existingError) {
        existingError.remove();
    }
    
    // Create error message element
    const errorElement = document.createElement('div');
    errorElement.className = 'field-error';
    errorElement.textContent = message;
    errorElement.style.color = '#e74c3c';
    errorElement.style.fontSize = '12px';
    errorElement.style.marginTop = '5px';
    
    // Insert error message after the field
    field.parentNode.appendChild(errorElement);
}

// Clear field error
function clearFieldError(field) {
    field.style.borderColor = '#ddd';
    
    const errorElement = field.parentNode.querySelector('.field-error');
    if (errorElement) {
        errorElement.remove();
    }
}

// Login form specific validation
function validateLoginForm() {
    const username = document.getElementById('username');
    const password = document.getElementById('password');
    let isValid = true;
    
    if (!username.value.trim()) {
        showFieldError(username, 'Username is required.');
        isValid = false;
    }
    
    if (!password.value.trim()) {
        showFieldError(password, 'Password is required.');
        isValid = false;
    }
    
    return isValid;
}

// Registration form specific validation
function validateRegistrationForm() {
    const form = document.querySelector('form');
    const password = form.querySelector('input[name="password"]');
    const confirmPassword = form.querySelector('input[name="confirm_password"]');
    
    let isValid = validateForm(form);
    
    // Check password confirmation
    if (confirmPassword && password.value !== confirmPassword.value) {
        showFieldError(confirmPassword, 'Passwords do not match.');
        isValid = false;
    }
    
    return isValid;
}

// Material form validation
function validateMaterialForm() {
    const title = document.querySelector('input[name="title"]');
    const materialType = document.querySelector('select[name="material_type"]');
    let isValid = true;
    
    if (!title.value.trim()) {
        showFieldError(title, 'Material title is required.');
        isValid = false;
    }
    
    if (!materialType.value) {
        showFieldError(materialType, 'Please select a material type.');
        isValid = false;
    }
    
    return isValid;
}

// Class form validation
function validateClassForm() {
    const className = document.querySelector('input[name="class_name"]');
    const teacherName = document.querySelector('input[name="teacher_name"]');
    let isValid = true;
    
    if (!className.value.trim()) {
        showFieldError(className, 'Class name is required.');
        isValid = false;
    }
    
    if (!teacherName.value.trim()) {
        showFieldError(teacherName, 'Teacher name is required.');
        isValid = false;
    }
    
    return isValid;
}

// Show success message
function showSuccessMessage(message) {
    showMessage(message, 'success');
}

// Show error message
function showErrorMessage(message) {
    showMessage(message, 'error');
}

// General message display function
function showMessage(message, type) {
    // Remove existing messages
    const existingMessages = document.querySelectorAll('.validation-message');
    existingMessages.forEach(function(msg) {
        msg.remove();
    });
    
    // Create message element
    const messageElement = document.createElement('div');
    messageElement.className = 'validation-message message ' + type;
    messageElement.textContent = message;
    
    // Insert at top of main content
    const container = document.querySelector('.container');
    if (container) {
        container.insertBefore(messageElement, container.firstChild);
        
        // Auto-hide after 5 seconds
        setTimeout(function() {
            messageElement.style.opacity = '0';
            setTimeout(function() {
                if (messageElement.parentNode) {
                    messageElement.parentNode.removeChild(messageElement);
                }
            }, 300);
        }, 5000);
    }
}

// Prevent form double submission
function preventDoubleSubmit() {
    const forms = document.querySelectorAll('form');
    
    forms.forEach(function(form) {
        form.addEventListener('submit', function() {
            const submitButton = form.querySelector('button[type="submit"], input[type="submit"]');
            if (submitButton) {
                submitButton.disabled = true;
                submitButton.textContent = 'Processing...';
                
                // Re-enable after 3 seconds as fallback
                setTimeout(function() {
                    submitButton.disabled = false;
                    submitButton.textContent = submitButton.getAttribute('data-original-text') || 'Submit';
                }, 3000);
            }
        });
    });
}

// Initialize double submit prevention
document.addEventListener('DOMContentLoaded', function() {
    preventDoubleSubmit();
    
    // Store original button text
    const submitButtons = document.querySelectorAll('button[type="submit"], input[type="submit"]');
    submitButtons.forEach(function(button) {
        button.setAttribute('data-original-text', button.textContent);
    });
});
