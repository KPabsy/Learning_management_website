// Basic utility functions for the LMS

// Wait for DOM to be ready
document.addEventListener('DOMContentLoaded', function() {
    initializeApp();
});

// Initialize application
function initializeApp() {
    // Set up form validations
    setupFormValidation();
    
    // Set up confirmation dialogs
    setupConfirmDialogs();
    
    // Set up auto-hide messages
    setupAutoHideMessages();
    
    // Set up current date/time
    updateDateTime();
}

// Form validation setup
function setupFormValidation() {
    const forms = document.querySelectorAll('form');
    
    forms.forEach(function(form) {
        form.addEventListener('submit', function(e) {
            if (!validateForm(form)) {
                e.preventDefault();
                showMessage('Please fill in all required fields correctly.', 'error');
            }
        });
    });
}

// Basic form validation
function validateForm(form) {
    let isValid = true;
    const requiredFields = form.querySelectorAll('[required]');
    
    requiredFields.forEach(function(field) {
        if (!field.value.trim()) {
            field.style.borderColor = '#e74c3c';
            isValid = false;
        } else {
            field.style.borderColor = '#ddd';
        }
    });
    
    // Email validation
    const emailFields = form.querySelectorAll('input[type="email"]');
    emailFields.forEach(function(field) {
        if (field.value && !isValidEmail(field.value)) {
            field.style.borderColor = '#e74c3c';
            isValid = false;
        }
    });
    
    return isValid;
}

// Email validation function
function isValidEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
}

// Setup confirmation dialogs
function setupConfirmDialogs() {
    const confirmLinks = document.querySelectorAll('[data-confirm]');
    
    confirmLinks.forEach(function(link) {
        link.addEventListener('click', function(e) {
            const message = this.getAttribute('data-confirm');
            if (!confirm(message)) {
                e.preventDefault();
            }
        });
    });
}

// Auto-hide success messages
function setupAutoHideMessages() {
    const messages = document.querySelectorAll('.message.success');
    
    messages.forEach(function(message) {
        setTimeout(function() {
            message.style.opacity = '0';
            setTimeout(function() {
                if (message.parentNode) {
                    message.parentNode.removeChild(message);
                }
            }, 300);
        }, 3000);
    });
}

// Show message function
function showMessage(text, type) {
    const messageDiv = document.createElement('div');
    messageDiv.className = 'message ' + (type || 'info');
    messageDiv.textContent = text;
    
    const container = document.querySelector('.container');
    if (container) {
        container.insertBefore(messageDiv, container.firstChild);
        
        // Auto-hide after 3 seconds
        setTimeout(function() {
            messageDiv.style.opacity = '0';
            setTimeout(function() {
                if (messageDiv.parentNode) {
                    messageDiv.parentNode.removeChild(messageDiv);
                }
            }, 300);
        }, 3000);
    }
}

// Update current date and time
function updateDateTime() {
    const dateTimeElements = document.querySelectorAll('.current-datetime');
    
    if (dateTimeElements.length > 0) {
        const now = new Date();
        const dateTimeString = now.toLocaleString();
        
        dateTimeElements.forEach(function(element) {
            element.textContent = dateTimeString;
        });
    }
}

// Simple loading spinner
function showLoading() {
    const spinner = document.createElement('div');
    spinner.className = 'spinner';
    spinner.id = 'loading-spinner';
    
    const container = document.querySelector('.container');
    if (container) {
        container.appendChild(spinner);
    }
}

function hideLoading() {
    const spinner = document.getElementById('loading-spinner');
    if (spinner) {
        spinner.parentNode.removeChild(spinner);
    }
}

// Simple table search function
function searchTable(inputId, tableId) {
    const input = document.getElementById(inputId);
    const table = document.getElementById(tableId);
    
    if (input && table) {
        input.addEventListener('keyup', function() {
            const filter = this.value.toLowerCase();
            const rows = table.getElementsByTagName('tr');
            
            for (let i = 1; i < rows.length; i++) {
                const row = rows[i];
                const cells = row.getElementsByTagName('td');
                let found = false;
                
                for (let j = 0; j < cells.length; j++) {
                    const cell = cells[j];
                    if (cell.textContent.toLowerCase().indexOf(filter) > -1) {
                        found = true;
                        break;
                    }
                }
                
                row.style.display = found ? '' : 'none';
            }
        });
    }
}

// Format date for display
function formatDate(dateString) {
    const date = new Date(dateString);
    const options = { 
        year: 'numeric', 
        month: 'long', 
        day: 'numeric' 
    };
    return date.toLocaleDateString('en-US', options);
}

// Format time for display
function formatTime(timeString) {
    const time = new Date('2000-01-01 ' + timeString);
    return time.toLocaleTimeString('en-US', { 
        hour: 'numeric', 
        minute: '2-digit',
        hour12: true 
    });
}

// Simple accordion functionality
function setupAccordion() {
    const accordionHeaders = document.querySelectorAll('.accordion-header');
    
    accordionHeaders.forEach(function(header) {
        header.addEventListener('click', function() {
            const content = this.nextElementSibling;
            const isOpen = content.style.display === 'block';
            
            // Close all accordion items
            document.querySelectorAll('.accordion-content').forEach(function(item) {
                item.style.display = 'none';
            });
            
            // Open clicked item if it was closed
            if (!isOpen) {
                content.style.display = 'block';
            }
        });
    });
}

// Simple tab functionality
function openTab(tabName, element) {
    // Hide all tab contents
    const tabContents = document.querySelectorAll('.tab-content');
    tabContents.forEach(function(content) {
        content.style.display = 'none';
    });
    
    // Remove active class from all tab buttons
    const tabButtons = document.querySelectorAll('.tab-button');
    tabButtons.forEach(function(button) {
        button.classList.remove('active');
    });
    
    // Show selected tab content
    const selectedTab = document.getElementById(tabName);
    if (selectedTab) {
        selectedTab.style.display = 'block';
    }
    
    // Add active class to clicked button
    if (element) {
        element.classList.add('active');
    }
}

// Initialize any additional features when page loads
window.addEventListener('load', function() {
    setupAccordion();
    
    // Set up table search if elements exist
    if (document.getElementById('search-input') && document.getElementById('data-table')) {
        searchTable('search-input', 'data-table');
    }
});
