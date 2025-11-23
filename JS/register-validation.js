// register-validation.js - Real-time Form Validation
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');
    const nameInput = document.getElementById('name');
    const surnameInput = document.getElementById('surname');
    const emailInput = document.getElementById('email');
    const telInput = document.getElementById('tel');
    const checkbox = document.getElementById('gridCheck');
    const submitBtn = form.querySelector('button[type="submit"]');

    // Wrap inputs in position relative container for icons
    [nameInput, surnameInput, emailInput, telInput].forEach(input => {
        if (!input.parentElement.classList.contains('input-wrapper')) {
            const wrapper = document.createElement('div');
            wrapper.className = 'input-wrapper';
            input.parentNode.insertBefore(wrapper, input);
            wrapper.appendChild(input);
        }
    });

    // Validation Functions
    function validateName(input) {
        const value = input.value.trim();
        const thaiRegex = /^[ก-๙a-zA-Z\s]+$/;
        
        removeIcon(input);
        
        if (value.length === 0) {
            showError(input, 'กรุณากรอกข้อมูล');
            return false;
        }
        
        if (value.length < 2) {
            showError(input, 'ต้องมีอย่างน้อย 2 ตัวอักษร');
            return false;
        }
        
        if (!thaiRegex.test(value)) {
            showError(input, 'ใช้ได้เฉพาะตัวอักษรไทยหรืออังกฤษเท่านั้น');
            return false;
        }
        
        showSuccess(input, 'ถูกต้อง');
        return true;
    }

    function validateEmail(input) {
        const value = input.value.trim();
        const emailRegex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
        
        removeIcon(input);
        
        if (value.length === 0) {
            showError(input, 'กรุณากรอกอีเมล');
            return false;
        }
        
        if (!emailRegex.test(value)) {
            showError(input, 'รูปแบบอีเมลไม่ถูกต้อง (example@email.com)');
            return false;
        }
        
        showSuccess(input, 'อีเมลถูกต้อง');
        return true;
    }

    function validateTel(input) {
        const value = input.value.replace(/[^0-9]/g, '');
        
        removeIcon(input);
        
        if (value.length === 0) {
            showError(input, 'กรุณากรอกเบอร์โทรศัพท์');
            return false;
        }
        
        if (value.length !== 10) {
            showError(input, 'เบอร์โทรต้องมี 10 หลักเท่านั้น');
            return false;
        }
        
        if (!/^[0-9]{10}$/.test(value)) {
            showError(input, 'กรุณากรอกเฉพาะตัวเลข');
            return false;
        }
        
        // Check if starts with valid Thai mobile prefix
        const validPrefixes = ['06', '08', '09'];
        const prefix = value.substring(0, 2);
        
        if (!validPrefixes.includes(prefix)) {
            showError(input, 'เบอร์โทรต้องขึ้นต้นด้วย 06, 08, หรือ 09');
            return false;
        }
        
        showSuccess(input, 'เบอร์โทรถูกต้อง');
        return true;
    }

    function showError(input, message) {
        input.classList.remove('is-valid');
        input.classList.add('is-invalid');
        
        let feedback = input.parentElement.querySelector('.invalid-feedback');
        if (!feedback) {
            feedback = document.createElement('div');
            feedback.classList.add('invalid-feedback');
            input.parentElement.appendChild(feedback);
        }
        
        feedback.textContent = message;
        feedback.classList.add('show');
                
        // Hide valid feedback if exists
        const validFeedback = input.parentElement.querySelector('.valid-feedback');
        if (validFeedback) {
            validFeedback.classList.remove('show');
        }
        
        updateSubmitButton();
    }

    function showSuccess(input, message) {
        input.classList.remove('is-invalid');
        input.classList.add('is-valid');
        
        let feedback = input.parentElement.querySelector('.valid-feedback');
        if (!feedback) {
            feedback = document.createElement('div');
            feedback.classList.add('valid-feedback');
            feedback.style.color = '#28a745';
            input.parentElement.appendChild(feedback);
        }
        
        feedback.textContent = message;
        feedback.classList.add('show');
        
        // Hide invalid feedback if exists
        const invalidFeedback = input.parentElement.querySelector('.invalid-feedback');
        if (invalidFeedback) {
            invalidFeedback.classList.remove('show');
        }
        
        updateSubmitButton();
    }

    function addIcon(input, icon, color) {
        removeIcon(input);
        const iconSpan = document.createElement('span');
        iconSpan.className = 'input-icon';
        iconSpan.textContent = icon;
        iconSpan.style.color = color;
        input.parentElement.appendChild(iconSpan);
    }

    function removeIcon(input) {
        const existingIcon = input.parentElement.querySelector('.input-icon');
        if (existingIcon) {
            existingIcon.remove();
        }
    }

    function updateSubmitButton() {
        const isFormValid = 
            nameInput.classList.contains('is-valid') &&
            surnameInput.classList.contains('is-valid') &&
            emailInput.classList.contains('is-valid') &&
            telInput.classList.contains('is-valid') &&
            checkbox.checked;
        
        if (isFormValid) {
            submitBtn.classList.remove('submit-btn-disabled');
            submitBtn.disabled = false;
        } else {
            submitBtn.classList.add('submit-btn-disabled');
            submitBtn.disabled = true;
        }
    }

    // Auto-format phone number with dashes
    function formatPhoneNumber(value) {
        const numbers = value.replace(/[^0-9]/g, '');
        
        if (numbers.length <= 3) {
            return numbers;
        } else if (numbers.length <= 6) {
            return numbers.slice(0, 3) + '-' + numbers.slice(3);
        } else if (numbers.length <= 10) {
            return numbers.slice(0, 3) + '-' + numbers.slice(3, 6) + '-' + numbers.slice(6, 10);
        } else {
            return numbers.slice(0, 3) + '-' + numbers.slice(3, 6) + '-' + numbers.slice(6, 10);
        }
    }

    // Real-time Event Listeners
    nameInput.addEventListener('input', function() {
        validateName(this);
    });

    nameInput.addEventListener('blur', function() {
        validateName(this);
    });

    surnameInput.addEventListener('input', function() {
        validateName(this);
    });

    surnameInput.addEventListener('blur', function() {
        validateName(this);
    });

    emailInput.addEventListener('input', function() {
        validateEmail(this);
    });

    emailInput.addEventListener('blur', function() {
        validateEmail(this);
    });

    telInput.addEventListener('input', function(e) {
        const formatted = formatPhoneNumber(e.target.value);
        e.target.value = formatted;
        validateTel(this);
    });

    telInput.addEventListener('blur', function() {
        validateTel(this);
    });

    checkbox.addEventListener('change', function() {
        updateSubmitButton();
    });

    // Form Submit Handler
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Validate all fields
        const isNameValid = validateName(nameInput);
        const isSurnameValid = validateName(surnameInput);
        const isEmailValid = validateEmail(emailInput);
        const isTelValid = validateTel(telInput);
        const isCheckboxChecked = checkbox.checked;
        
        if (!isNameValid || !isSurnameValid || !isEmailValid || !isTelValid) {
            // Scroll to first invalid field
            const firstInvalid = form.querySelector('.is-invalid');
            if (firstInvalid) {
                firstInvalid.scrollIntoView({ behavior: 'smooth', block: 'center' });
                firstInvalid.focus();
            }
            
            alert('❌ กรุณากรอกข้อมูลให้ถูกต้องครบถ้วน');
            return false;
        }
        
        if (!isCheckboxChecked) {
            alert('❌ กรุณายอมรับเงื่อนไขการรับข้อมูลข่าวสาร');
            checkbox.focus();
            return false;
        }
        
        // Show loading state
        submitBtn.textContent = 'กำลังส่งข้อมูล...';
        submitBtn.disabled = true;
        
        // Submit form
        this.submit();
    });

    // Initial state - disable submit button
    submitBtn.classList.add('submit-btn-disabled');
    submitBtn.disabled = true;

    // Add character counter for name fields (extra interaction)
    function addCharCounter(input, maxLength = 50) {
        const counter = document.createElement('small');
        counter.className = 'text-muted';
        counter.style.float = 'right';
        input.parentElement.appendChild(counter);
        
        function updateCounter() {
            const length = input.value.length;
            counter.textContent = `${length}/${maxLength}`;
            if (length > maxLength * 0.9) {
                counter.style.color = '#dc3545';
            } else {
                counter.style.color = '#6c757d';
            }
        }
        
        input.addEventListener('input', updateCounter);
        updateCounter();
    }

    addCharCounter(nameInput);
    addCharCounter(surnameInput);

    console.log('Register Validation Script Loaded Successfully');
});