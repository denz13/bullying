// Mobile Navigation Toggle
function toggleMobileNav() {
    const mobileNav = document.getElementById('mobileNav');
    if (mobileNav) {
        mobileNav.classList.toggle('active');
        document.body.style.overflow = mobileNav.classList.contains('active') ? 'hidden' : '';
    }
}

// Show/hide sections based on navigation - Global function
function showSection(sectionId) {
    // Handle home section
    const homeSection = document.getElementById('home');
    const homeContent = document.getElementById('home-content');
    
    if (sectionId === 'home') {
        if (homeSection) {
            homeSection.style.display = 'block';
            homeSection.classList.remove('hidden');
        }
        if (homeContent) {
            homeContent.style.display = 'block';
        }
    } else {
        if (homeSection) {
            homeSection.style.display = 'none';
            homeSection.classList.add('hidden');
        }
        if (homeContent) {
            homeContent.style.display = 'none';
        }
    }
    
    // Hide all content sections first
    document.querySelectorAll('.content-section').forEach(section => {
        section.style.setProperty('display', 'none', 'important');
        section.classList.remove('active');
    });
    
    // Show selected section
    if (sectionId === 'home') {
        // Scroll to top for home
        window.scrollTo({ top: 0, behavior: 'smooth' });
    } else {
        const targetSection = document.getElementById(sectionId + '-section');
        if (targetSection) {
            // Use both inline style and class to ensure visibility
            targetSection.style.setProperty('display', 'block', 'important');
            targetSection.classList.add('active');
            // Force a reflow to ensure display change takes effect
            void targetSection.offsetHeight;
            setTimeout(() => {
                targetSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }, 100);
        }
    }
    
    // Update active nav link (desktop)
    document.querySelectorAll('nav a').forEach(link => {
        link.classList.remove('active');
    });
    const activeLink = document.querySelector(`nav a[href="#${sectionId}"]`);
    if (activeLink) {
        activeLink.classList.add('active');
    }
    
    // Update active nav link (mobile)
    document.querySelectorAll('.mobile-nav-menu a').forEach(link => {
        link.classList.remove('active');
    });
    const activeMobileLink = document.querySelector(`.mobile-nav-menu a[href="#${sectionId}"]`);
    if (activeMobileLink) {
        activeMobileLink.classList.add('active');
    }
}

// Close mobile nav when clicking outside
document.addEventListener('click', function(event) {
    const mobileNav = document.getElementById('mobileNav');
    const mobileMenuToggle = document.querySelector('.mobile-menu-toggle');
    if (mobileNav && mobileMenuToggle && 
        !mobileNav.contains(event.target) && 
        !mobileMenuToggle.contains(event.target) &&
        mobileNav.classList.contains('active')) {
        toggleMobileNav();
    }
});

document.addEventListener('DOMContentLoaded', () => {
    const experienceForm = document.getElementById('experience-form');
    const experienceConfirmation = document.getElementById('experience-confirmation');

    if (experienceForm) {
        experienceForm.addEventListener('submit', async (event) => {
            event.preventDefault();
            const formData = new FormData(experienceForm);
            const anonymousCheckbox = experienceForm.querySelector('#is_anonymously');
            if (!anonymousCheckbox || !anonymousCheckbox.checked) {
                formData.set('is_anonymously', '0');
            }
            const submitButton = experienceForm.querySelector('button[type="submit"]');
            submitButton.disabled = true;
            submitButton.classList.add('opacity-70');

            try {
                const response = await fetch(experienceForm.action, {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                    body: formData,
                });

                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }

                experienceForm.reset();
                Swal.fire({
                    icon: 'success',
                    title: 'Experience shared',
                    text: 'Thank you for trusting us with your story.',
                    confirmButtonColor: '#1a4b84',
                });
            } catch (error) {
                console.error('Failed to submit shared experience:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Submission failed',
                    text: 'Sorry, something went wrong. Please try again.',
                    confirmButtonColor: '#b22222',
                });
            } finally {
                submitButton.disabled = false;
                submitButton.classList.remove('opacity-70');
            }
        });
    }

    const counselingForm = document.getElementById('counseling-form');

    if (counselingForm) {
        counselingForm.addEventListener('submit', async (event) => {
            event.preventDefault();
            const formData = new FormData(counselingForm);
            const submitButton = counselingForm.querySelector('button[type="submit"]');
            submitButton.disabled = true;
            submitButton.classList.add('opacity-70');

            try {
                const response = await fetch(counselingForm.action, {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                    body: formData,
                });

                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }

                counselingForm.reset();
                Swal.fire({
                    icon: 'success',
                    title: 'Support Request Received',
                    text: 'Thank you for reaching out. Our counseling team will contact you based on the urgency level you selected.',
                    footer: 'If this is an emergency, please contact school administration immediately at 09061007363.',
                    confirmButtonColor: '#1a4b84',
                });
            } catch (error) {
                console.error('Failed to submit counseling request:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Submission failed',
                    text: 'Sorry, something went wrong. Please try again.',
                    confirmButtonColor: '#b22222',
                });
            } finally {
                submitButton.disabled = false;
                submitButton.classList.remove('opacity-70');
            }
        });
    }

    // Smooth scrolling for navigation links
    document.querySelectorAll('nav a[href^="#"]').forEach((anchor) => {
        anchor.addEventListener('click', (event) => {
            event.preventDefault();
            const targetId = anchor.getAttribute('href').substring(1);
            const targetElement = document.getElementById(targetId);
            if (targetElement) {
                targetElement.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });

    // Feature card animation
    const featureCards = document.querySelectorAll('.feature-card');
    const animateCards = () => {
        featureCards.forEach((card) => {
            const cardTop = card.getBoundingClientRect().top;
            const windowHeight = window.innerHeight;
            if (cardTop < windowHeight - 100) {
                card.style.opacity = '1';
                card.style.transform = 'translateY(0)';
            }
        });
    };

    featureCards.forEach((card) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        card.style.transition = 'opacity 0.5s, transform 0.5s';
    });

    animateCards();
    window.addEventListener('scroll', animateCards);
    
    // FAQ functionality
    document.querySelectorAll('.faq-question').forEach(question => {
        question.addEventListener('click', function() {
            const faqItem = this.parentElement;
            faqItem.classList.toggle('active');
        });
    });
});
