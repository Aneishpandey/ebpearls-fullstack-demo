class ContactForm {
    constructor() {
        this.form = document.getElementById('contactForm');
        this.submitBtn = this.form.querySelector('button[type="submit"]');
        this.init();
    }
    
    init() {
        this.form.addEventListener('submit', (e) => this.handleSubmit(e));
    }
    
    validateForm() {
        const name = this.form.querySelector('#name').value.trim();
        const email = this.form.querySelector('#email').value.trim();
        const message = this.form.querySelector('#message').value.trim();
        
        let isValid = true;
        
        // Reset error messages
        document.querySelectorAll('.error-message').forEach(error => {
            error.style.display = 'none';
        });
        
        if (!name) {
            this.showError('nameError', 'Name is required');
            isValid = false;
        }
        
        if (!email) {
            this.showError('emailError', 'Email is required');
            isValid = false;
        } else if (!this.isValidEmail(email)) {
            this.showError('emailError', 'Please enter a valid email address');
            isValid = false;
        }
        
        if (!message) {
            this.showError('messageError', 'Message is required');
            isValid = false;
        }
        
        return isValid;
    }
    
    showError(elementId, message) {
        const errorElement = document.getElementById(elementId);
        errorElement.textContent = message;
        errorElement.style.display = 'block';
    }
    
    isValidEmail(email) {
        return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
    }
    
    async handleSubmit(e) {
        e.preventDefault();
        
        if (!this.validateForm()) return;
        
        this.submitBtn.disabled = true;
        this.submitBtn.textContent = 'Sending...';
        
        try {
            const formData = {
                name: this.form.querySelector('#name').value.trim(),
                email: this.form.querySelector('#email').value.trim(),
                message: this.form.querySelector('#message').value.trim()
            };
            
            const response = await fetch('/api/contact/submit.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(formData)
            });
            
            const data = await response.json();
            
            if (response.ok) {
                this.showSuccess();
                this.form.reset();
            } else {
                throw new Error(data.message || 'Something went wrong');
            }
        } catch (error) {
            this.showError('formError', error.message);
        } finally {
            this.submitBtn.disabled = false;
            this.submitBtn.textContent = 'Submit';
        }
    }
    
    showSuccess() {
        const successMessage = document.createElement('div');
        successMessage.className = 'success-message';
        successMessage.textContent = 'Thank you for your message. We will get back to you soon!';
        
        this.form.insertAdjacentElement('beforebegin', successMessage);
        
        setTimeout(() => {
            successMessage.remove();
        }, 5000);
    }
}

// Initialize Contact Form
const contactForm = new ContactForm();