(function() {

            // Mobile menu toggler
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('overlay');
            const menuBtn = document.getElementById('mobileMenuBtn');

            function toggleMenu() {
                sidebar.classList.toggle('open');
                overlay.classList.toggle('show');
            }

            if (menuBtn) {
                menuBtn.addEventListener('click', toggleMenu);
            }

            if (overlay) {
                overlay.addEventListener('click', toggleMenu);
            }
        
})();