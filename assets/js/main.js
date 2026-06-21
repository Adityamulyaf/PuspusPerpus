/**
 * PuspusPerpus Frontend Interactivity & Animations
 * Uses GSAP for smooth entrance, stagger, modal and shake animations.
 */

document.addEventListener("DOMContentLoaded", () => {
    // 1. Page Entrance Fade In
    const mainContainer = document.querySelector('.main-container');
    if (mainContainer && typeof gsap !== 'undefined') {
        gsap.fromTo(mainContainer, 
            { opacity: 0, y: 15 }, 
            { opacity: 1, y: 0, duration: 0.45, ease: "power2.out" }
        );
    }

    // 2. Sidebar Mobile Toggle
    const sidebar = document.querySelector('.app-sidebar');
    const toggleBtn = document.querySelector('.sidebar-toggle');
    if (sidebar && toggleBtn) {
        toggleBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            sidebar.classList.toggle('show');
            
            // GSAP Sidebar Slide in on toggle
            if (sidebar.classList.contains('show') && typeof gsap !== 'undefined') {
                gsap.fromTo(sidebar, { x: -260 }, { x: 0, duration: 0.3, ease: "power2.out" });
            }
        });

        // Close sidebar clicking outside
        document.addEventListener('click', (e) => {
            if (window.innerWidth <= 991 && sidebar.classList.contains('show')) {
                if (!sidebar.contains(e.target) && !toggleBtn.contains(e.target)) {
                    sidebar.classList.remove('show');
                }
            }
        });
    }

    // 3. Dashboard Cards Stagger Animation
    const cards = document.querySelectorAll('.stat-card');
    if (cards.length > 0 && typeof gsap !== 'undefined') {
        gsap.fromTo(cards, 
            { opacity: 0, y: 25 }, 
            { opacity: 1, y: 0, duration: 0.5, stagger: 0.1, ease: "power3.out", delay: 0.1 }
        );
    }

    // 4. Table Rows Reveal Stagger Animation
    const rows = document.querySelectorAll('.table-custom tbody tr');
    if (rows.length > 0 && typeof gsap !== 'undefined') {
        gsap.fromTo(rows, 
            { opacity: 0, y: 10 }, 
            { opacity: 1, y: 0, duration: 0.4, stagger: 0.04, ease: "power2.out", delay: 0.15 }
        );
    }

    // 5. Client-Side Form Validations (with shake feedback)
    setupFormValidation();
});

/**
 * Shake element left/right to indicate input error
 */
function shakeElement(element) {
    if (typeof gsap !== 'undefined' && element) {
        gsap.fromTo(element, 
            { x: -8 }, 
            { x: 8, duration: 0.06, repeat: 5, yoyo: true, ease: "sine.inOut", onComplete: () => {
                element.style.transform = 'none';
            }}
        );
    }
}

/**
 * Clean error styling and messages
 */
function clearValidationError(input) {
    input.classList.remove('is-invalid');
    const feedback = input.parentNode.querySelector('.invalid-feedback');
    if (feedback) {
        feedback.remove();
    }
}

/**
 * Display error validation message
 */
function showValidationError(input, message) {
    clearValidationError(input);
    input.classList.add('is-invalid');
    
    const feedback = document.createElement('div');
    feedback.className = 'invalid-feedback';
    feedback.innerText = message;
    input.parentNode.appendChild(feedback);
    
    shakeElement(input);
}

/**
 * Validate forms on submit
 */
function setupFormValidation() {
    // A. Login Form Validation
    const loginForm = document.getElementById('login-form');
    if (loginForm) {
        loginForm.addEventListener('submit', (e) => {
            let hasError = false;
            const emailInput = document.getElementById('email');
            const passwordInput = document.getElementById('password');

            // Email check
            const emailVal = emailInput.value.trim();
            if (emailVal === '') {
                showValidationError(emailInput, 'Email wajib diisi.');
                hasError = true;
            } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(emailVal)) {
                showValidationError(emailInput, 'Format email tidak valid.');
                hasError = true;
            } else {
                clearValidationError(emailInput);
            }

            // Password check
            const passwordVal = passwordInput.value;
            if (passwordVal === '') {
                showValidationError(passwordInput, 'Password wajib diisi.');
                hasError = true;
            } else if (passwordVal.length < 6) {
                showValidationError(passwordInput, 'Password minimal 6 karakter.');
                hasError = true;
            } else {
                clearValidationError(passwordInput);
            }

            if (hasError) {
                e.preventDefault();
            }
        });
    }

    // B. Book Add/Edit Form Validation
    const bookForm = document.getElementById('book-form');
    if (bookForm) {
        bookForm.addEventListener('submit', (e) => {
            let hasError = false;
            const titleInput = document.getElementById('title');
            const authorInput = document.getElementById('author');
            const publisherInput = document.getElementById('publisher');
            const yearInput = document.getElementById('publication_year');
            const categorySelect = document.getElementById('category_id');

            // Title validation
            if (titleInput.value.trim() === '') {
                showValidationError(titleInput, 'Judul buku wajib diisi.');
                hasError = true;
            } else if (titleInput.value.trim().length < 3) {
                showValidationError(titleInput, 'Judul minimal 3 karakter.');
                hasError = true;
            } else {
                clearValidationError(titleInput);
            }

            // Author validation
            if (authorInput.value.trim() === '') {
                showValidationError(authorInput, 'Penulis wajib diisi.');
                hasError = true;
            } else if (authorInput.value.trim().length < 3) {
                showValidationError(authorInput, 'Penulis minimal 3 karakter.');
                hasError = true;
            } else {
                clearValidationError(authorInput);
            }

            // Publisher validation
            if (publisherInput.value.trim() === '') {
                showValidationError(publisherInput, 'Penerbit wajib diisi.');
                hasError = true;
            } else {
                clearValidationError(publisherInput);
            }

            // Publication Year validation
            const currentYear = new Date().getFullYear();
            const yearVal = yearInput.value.trim();
            if (yearVal === '') {
                showValidationError(yearInput, 'Tahun terbit wajib diisi.');
                hasError = true;
            } else if (isNaN(yearVal)) {
                showValidationError(yearInput, 'Tahun harus berupa angka.');
                hasError = true;
            } else {
                const yearInt = parseInt(yearVal, 10);
                if (yearInt < 1900 || yearInt > currentYear) {
                    showValidationError(yearInput, `Tahun harus antara 1900 hingga ${currentYear}.`);
                    hasError = true;
                } else {
                    clearValidationError(yearInput);
                }
            }

            // Category validation
            if (categorySelect.value === '') {
                showValidationError(categorySelect, 'Kategori wajib dipilih.');
                hasError = true;
            } else {
                clearValidationError(categorySelect);
            }

            if (hasError) {
                e.preventDefault();
            }
        });
    }

    // C. Category Form Validation
    const categoryForm = document.getElementById('category-form');
    if (categoryForm) {
        categoryForm.addEventListener('submit', (e) => {
            let hasError = false;
            const nameInput = document.getElementById('name');

            // Category Name validation
            if (nameInput.value.trim() === '') {
                showValidationError(nameInput, 'Nama kategori wajib diisi.');
                hasError = true;
            } else if (nameInput.value.trim().length < 3) {
                showValidationError(nameInput, 'Nama kategori minimal 3 karakter.');
                hasError = true;
            } else {
                clearValidationError(nameInput);
            }

            if (hasError) {
                e.preventDefault();
            }
        });
    }
}

/**
 * Confirm delete popup (Exposed globally)
 */
window.openConfirmModal = function(modalId, actionUrl, message = '') {
    const overlay = document.getElementById(modalId);
    if (!overlay) return;

    if (actionUrl) {
        const form = overlay.querySelector('form');
        if (form) {
            form.action = actionUrl;
        }
    }

    if (message) {
        const textElement = overlay.querySelector('.modal-message');
        if (textElement) {
            textElement.textContent = message;
        }
    }

    overlay.classList.add('active');

    // Scale up & fade in modal content
    const container = overlay.querySelector('.modal-container');
    if (container && typeof gsap !== 'undefined') {
        gsap.fromTo(container, 
            { scale: 0.94, opacity: 0 }, 
            { scale: 1, opacity: 1, duration: 0.22, ease: "power2.out" }
        );
    }
};

window.closeConfirmModal = function(modalId) {
    const overlay = document.getElementById(modalId);
    if (!overlay) return;

    const container = overlay.querySelector('.modal-container');
    if (container && typeof gsap !== 'undefined') {
        gsap.to(container, {
            scale: 0.94, 
            opacity: 0, 
            duration: 0.18, 
            ease: "power2.in",
            onComplete: () => {
                overlay.classList.remove('active');
            }
        });
    } else {
        overlay.classList.remove('active');
    }
};
