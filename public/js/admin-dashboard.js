document.querySelectorAll('.stat-card').forEach(el => {
    const link = el.querySelector('.stat-link');
    if (link) {
        el.addEventListener('mouseenter', function () { link.style.gap = '0.7rem'; });
        el.addEventListener('mouseleave', function () { link.style.gap = '0.4rem'; });
    }
});
