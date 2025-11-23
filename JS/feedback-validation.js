// feedback-validation.js - Real-time Feedback Form Validation
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('.feedback-form');
    const nameInput = document.getElementById('name');
    const emailInput = document.getElementById('email');
    const ratingSelect = document.getElementById('rating');
    const messageTextarea = document.getElementById('message');
    const submitBtn = form.querySelector('button[type="submit"]');
    const successMessage = document.getElementById('success-message');

    // Character counter for message
    const charCounter = document.createElement('div');
    charCounter.className = 'char-counter';
    messageTextarea.parentElement.appendChild(charCounter);

    // Rating preview
    const ratingPreview = document.createElement('span');
    ratingPreview.className = 'rating-preview';
    ratingSelect.parentElement.appendChild(ratingPreview);

    // Validation Functions
    function validateName(input) {
        const value = input.value.trim();
        const nameRegex = /^[ก-๙a-zA-Z\s]+$/;
        
        removeErrorMessage(input);
        
        if (value.length === 0) {
            showError(input, 'กรุณากรอกชื่อ');
            return false;
        }
        
        if (value.length < 2) {
            showError(input, 'ชื่อต้องมีอย่างน้อย 2 ตัวอักษร');
            return false;
        }
        
        if (!nameRegex.test(value)) {
            showError(input, 'ใช้ได้เฉพาะตัวอักษรไทยหรืออังกฤษ');
            return false;
        }
        
        showSuccess(input);
        return true;
    }

    function validateEmail(input) {
        const value = input.value.trim();
        const emailRegex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
        
        removeErrorMessage(input);
        
        if (value.length === 0) {
            showError(input, 'กรุณากรอกอีเมล');
            return false;
        }
        
        if (!emailRegex.test(value)) {
            showError(input, 'รูปแบบอีเมลไม่ถูกต้อง');
            return false;
        }
        
        showSuccess(input);
        return true;
    }

    function validateRating(select) {
        removeErrorMessage(select);
        
        if (select.value === '') {
            showError(select, 'กรุณาเลือกระดับความพึงพอใจ');
            return false;
        }
        
        showSuccess(select);
        updateRatingPreview(select.value);
        return true;
    }

    function validateMessage(textarea) {
        const value = textarea.value.trim();
        const minLength = 10;
        const maxLength = 500;
        
        removeErrorMessage(textarea);
        
        if (value.length === 0) {
            showError(textarea, 'กรุณากรอกความคิดเห็น');
            updateCharCounter(0, maxLength);
            return false;
        }
        
        if (value.length < minLength) {
            showError(textarea, `ความคิดเห็นต้องมีอย่างน้อย ${minLength} ตัวอักษร`);
            updateCharCounter(value.length, maxLength);
            return false;
        }
        
        if (value.length > maxLength) {
            showError(textarea, `ความคิดเห็นต้องไม่เกิน ${maxLength} ตัวอักษร`);
            updateCharCounter(value.length, maxLength);
            return false;
        }
        
        showSuccess(textarea);
        updateCharCounter(value.length, maxLength);
        return true;
    }

    function showError(element, message) {
        element.classList.remove('valid');
        element.classList.add('invalid');
        
        let errorDiv = element.parentElement.querySelector('.error-message');
        if (!errorDiv) {
            errorDiv = document.createElement('div');
            errorDiv.className = 'error-message';
            element.parentElement.appendChild(errorDiv);
        }
        
        errorDiv.textContent = '❌ ' + message;
        errorDiv.classList.add('show');
    }

    function showSuccess(element) {
        element.classList.remove('invalid');
        element.classList.add('valid');
        
        const errorDiv = element.parentElement.querySelector('.error-message');
        if (errorDiv) {
            errorDiv.classList.remove('show');
        }
    }

    function removeErrorMessage(element) {
        const errorDiv = element.parentElement.querySelector('.error-message');
        if (errorDiv) {
            errorDiv.classList.remove('show');
        }
    }

    function updateCharCounter(current, max) {
        charCounter.textContent = `${current}/${max} ตัวอักษร`;
        
        if (current > max) {
            charCounter.classList.add('danger');
            charCounter.classList.remove('warning');
        } else if (current > max * 0.9) {
            charCounter.classList.add('warning');
            charCounter.classList.remove('danger');
        } else {
            charCounter.classList.remove('warning', 'danger');
        }
    }

    function updateRatingPreview(rating) {
        const stars = '⭐'.repeat(parseInt(rating));
        ratingPreview.textContent = stars;
        ratingPreview.style.display = rating ? 'inline' : 'none';
    }

    // Real-time Event Listeners
    nameInput.addEventListener('input', function() {
        validateName(this);
    });

    nameInput.addEventListener('blur', function() {
        validateName(this);
    });

    emailInput.addEventListener('input', function() {
        validateEmail(this);
    });

    emailInput.addEventListener('blur', function() {
        validateEmail(this);
    });

    ratingSelect.addEventListener('change', function() {
        validateRating(this);
    });

    messageTextarea.addEventListener('input', function() {
        validateMessage(this);
    });

    messageTextarea.addEventListener('blur', function() {
        validateMessage(this);
    });

    // Initialize character counter
    updateCharCounter(0, 500);

    // Form Submit Handler
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Validate all fields
        const isNameValid = validateName(nameInput);
        const isEmailValid = validateEmail(emailInput);
        const isRatingValid = validateRating(ratingSelect);
        const isMessageValid = validateMessage(messageTextarea);
        
        if (!isNameValid || !isEmailValid || !isRatingValid || !isMessageValid) {
            const firstInvalid = form.querySelector('.invalid');
            if (firstInvalid) {
                firstInvalid.scrollIntoView({ behavior: 'smooth', block: 'center' });
                firstInvalid.focus();
            }
            return false;
        }
        
        // Show loading state
        submitBtn.textContent = 'กำลังส่ง...';
        submitBtn.classList.add('submit-loading');
        submitBtn.disabled = true;
        
        // Simulate form submission
        setTimeout(() => {
            // Show success message
            successMessage.style.display = 'block';
            successMessage.textContent = '✓ ขอบคุณสำหรับความคิดเห็นของคุณ';
            
            // Reset form
            form.reset();
            
            // Remove validation classes
            [nameInput, emailInput, ratingSelect, messageTextarea].forEach(el => {
                el.classList.remove('valid', 'invalid');
            });
            
            // Reset button
            submitBtn.textContent = 'SUBMIT';
            submitBtn.classList.remove('submit-loading');
            submitBtn.disabled = false;
            
            // Reset rating preview
            ratingPreview.style.display = 'none';
            
            // Reset character counter
            updateCharCounter(0, 500);
            
            // Hide success message after 5 seconds
            setTimeout(() => {
                successMessage.style.display = 'none';
            }, 5000);
        }, 1500);
    });

    // Add hover effect on submit button
    submitBtn.addEventListener('mouseenter', function() {
        if (!this.disabled) {
            this.style.transform = 'scale(1.05)';
        }
    });

    submitBtn.addEventListener('mouseleave', function() {
        this.style.transform = 'scale(1)';
    });

    console.log('✓ Feedback Validation Script Loaded Successfully');
});