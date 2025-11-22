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

    // Smooth scrolling for navigation links
    document.querySelectorAll('nav a[href^="#"]').forEach((anchor) => {
        anchor.addEventListener('click', (event) => {
            event.preventDefault();
            const targetId = anchor.getAttribute('href');
            const target = document.querySelector(targetId);
            if (target) {
                target.scrollIntoView({ behavior: 'smooth' });
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
});
