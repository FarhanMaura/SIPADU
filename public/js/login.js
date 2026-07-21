document.addEventListener('DOMContentLoaded', () => {
    // Auto-focus ke email
    const emailField = document.getElementById('email');
    if (emailField) {
        emailField.focus();
    }
    
    // Check if there are errors (variable passed from blade)
    if (typeof window.hasErrors !== 'undefined' && window.hasErrors) {
        const styleShake = document.createElement('style');
        styleShake.textContent = `
            @keyframes shake {
                0%, 100% { transform: translateX(0); }
                20% { transform: translateX(-10px); }
                40% { transform: translateX(10px); }
                60% { transform: translateX(-6px); }
                80% { transform: translateX(6px); }
            }
        `;
        document.head.appendChild(styleShake);
        
        const container = document.querySelector('.login-container');
        if (container) {
            container.style.animation = 'shake 0.4s ease';
            setTimeout(() => {
                container.style.animation = '';
            }, 500);
        }
    }
});

// Loading state on submit
const form = document.querySelector('form');
if (form) {
    form.addEventListener('submit', function() {
        const btn = document.getElementById('submitBtn');
        if (btn) {
            btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Memproses...';
            btn.style.opacity = '0.8';
        }
    });
}
