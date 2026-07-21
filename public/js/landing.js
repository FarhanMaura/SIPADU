// Navbar scroll effect
const navbar = document.getElementById('navbar');
if (navbar) {
    window.addEventListener('scroll', () => {
        navbar.classList.toggle('scrolled', window.scrollY > 30);
    });
}

// Mobile menu sidebar
const mobileToggle = document.getElementById('mobile-toggle');
const mobileClose = document.getElementById('mobile-close');
const mobileMenu = document.getElementById('mobile-menu');
const mobileOverlay = document.getElementById('mobile-overlay');

function toggleMobileMenu() {
    if (!mobileMenu || !mobileOverlay) return;
    
    const isClosed = mobileMenu.classList.contains('translate-x-full');
    if (isClosed) {
        mobileOverlay.classList.remove('hidden');
        setTimeout(() => mobileOverlay.classList.remove('opacity-0'), 10);
        mobileMenu.classList.remove('translate-x-full');
    } else {
        mobileMenu.classList.add('translate-x-full');
        mobileOverlay.classList.add('opacity-0');
        setTimeout(() => mobileOverlay.classList.add('hidden'), 300);
    }
}

if (mobileToggle) mobileToggle.addEventListener('click', toggleMobileMenu);
if (mobileClose) mobileClose.addEventListener('click', toggleMobileMenu);
if (mobileOverlay) mobileOverlay.addEventListener('click', toggleMobileMenu);

// Smooth scroll
document.querySelectorAll('a[href^="#"]').forEach(a => {
    a.addEventListener('click', e => {
        const targetId = a.getAttribute('href');
        if (targetId === '#') return;
        
        const t = document.querySelector(targetId);
        if (t) { 
            e.preventDefault(); 
            t.scrollIntoView({ behavior: 'smooth' }); 
            // Close mobile menu if open
            if (mobileMenu && !mobileMenu.classList.contains('translate-x-full')) {
                toggleMobileMenu();
            }
        }
    });
});

// Fade-in on scroll (Intersection Observer)
const fadeEls = document.querySelectorAll('.fade-in');
if (fadeEls.length > 0) {
    const observer = new IntersectionObserver(entries => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
            }
        });
    }, { threshold: 0.1 });
    fadeEls.forEach(el => observer.observe(el));
}
