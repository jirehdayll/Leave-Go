import './bootstrap';

document.addEventListener('DOMContentLoaded', () => {
    // Simple form interaction
    const forms = document.querySelectorAll('form');
    
    forms.forEach(form => {
        form.addEventListener('submit', () => {
            const submitBtn = form.querySelector('button[type="submit"]');
            if (submitBtn) {
                submitBtn.innerText = 'Submitting...';
                submitBtn.style.opacity = '0.7';
                submitBtn.disabled = true;
            }
        });
    });

    // Handle dashboard card interactions if any
    const cards = document.querySelectorAll('.card');
    cards.forEach(card => {
        card.addEventListener('mouseenter', () => {
            // Potential hover logic
        });
    });
});
