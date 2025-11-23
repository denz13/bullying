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
    // Hide hero section
    const heroSection = document.getElementById('home');
    if (heroSection) {
        if (sectionId === 'home') {
            heroSection.style.display = 'block';
            heroSection.classList.remove('hidden');
        } else {
            heroSection.style.display = 'none';
            heroSection.classList.add('hidden');
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
            if (!experienceForm.querySelector('#anonymous').checked) {
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
                    footer: 'If this is an emergency, please contact school administration immediately at (046) 123-4567 ext. 101.',
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

    // Navigation click handlers (desktop)
    document.querySelectorAll('nav a[href^="#"]').forEach((anchor) => {
        anchor.addEventListener('click', (event) => {
            event.preventDefault();
            const targetId = anchor.getAttribute('href').substring(1);
            showSection(targetId);
        });
    });
    
    // Handle hash changes in URL
    function handleHashChange() {
        const hash = window.location.hash.substring(1);
        if (hash) {
            showSection(hash);
        } else {
            showSection('home');
        }
    }
    
    // Check initial hash on page load
    handleHashChange();
    
    // Listen for hash changes
    window.addEventListener('hashchange', handleHashChange);

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

    // Hero Carousel
    const heroSlides = document.querySelectorAll('.hero-slide');
    const carouselIndicators = document.querySelectorAll('.carousel-indicator');
    let currentSlide = 0;
    let carouselInterval;

    function showSlide(index) {
        heroSlides.forEach((slide, i) => {
            slide.classList.remove('active');
            if (i === index) {
                slide.classList.add('active');
            }
        });
        
        carouselIndicators.forEach((indicator, i) => {
            indicator.classList.remove('active');
            if (i === index) {
                indicator.classList.add('active');
            }
        });
    }

    function nextSlide() {
        currentSlide = (currentSlide + 1) % heroSlides.length;
        showSlide(currentSlide);
    }

    function startCarousel() {
        carouselInterval = setInterval(nextSlide, 5000); // Change slide every 5 seconds
    }

    function stopCarousel() {
        clearInterval(carouselInterval);
    }

    // Initialize carousel
    if (heroSlides.length > 0) {
        startCarousel();
        
        // Indicator click handlers
        carouselIndicators.forEach((indicator, index) => {
            indicator.addEventListener('click', () => {
                currentSlide = index;
                showSlide(currentSlide);
                stopCarousel();
                startCarousel(); // Restart carousel
            });
        });
        
        // Pause on hover
        const heroCarousel = document.querySelector('.hero-carousel');
        if (heroCarousel) {
            heroCarousel.addEventListener('mouseenter', stopCarousel);
            heroCarousel.addEventListener('mouseleave', startCarousel);
        }
    }
});
