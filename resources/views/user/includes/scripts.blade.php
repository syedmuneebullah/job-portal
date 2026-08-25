
<!-- ===== JAVASCRIPT (toggle) ===== -->
<script>
    (function() {
        const toggleBtn = document.getElementById('mobileMenuToggle');
        const mobileMenu = document.getElementById('mobileMenu');

        if (toggleBtn && mobileMenu) {
            function toggleMenu(forceState) {
                const isOpen = typeof forceState === 'boolean' ? forceState : !mobileMenu.classList.contains('hidden');
                if (isOpen) {
                    mobileMenu.classList.remove('hidden');
                    mobileMenu.classList.add('open');
                    toggleBtn.innerHTML = '<i class="fas fa-times text-xl"></i>';
                } else {
                    mobileMenu.classList.add('hidden');
                    mobileMenu.classList.remove('open');
                    toggleBtn.innerHTML = '<i class="fas fa-bars text-xl"></i>';
                }
            }

            toggleBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                const currentlyHidden = mobileMenu.classList.contains('hidden');
                toggleMenu(currentlyHidden);
            });

            // close on outside click
            document.addEventListener('click', function(event) {
                const isInside = toggleBtn.contains(event.target) || mobileMenu.contains(event.target);
                if (!isInside && !mobileMenu.classList.contains('hidden')) {
                    toggleMenu(false);
                }
            });
        }
    })();
</script>
<!-- ===== JAVASCRIPT (back to top) ===== -->
<script>
    (function() {
        const backBtn = document.getElementById('backToTop');
        if (backBtn) {
            window.addEventListener('scroll', function() {
                if (window.scrollY > 400) {
                    backBtn.classList.add('visible');
                } else {
                    backBtn.classList.remove('visible');
                }
            });

            backBtn.addEventListener('click', function() {
                window.scrollTo({ top: 0, behavior: 'smooth' });
            });
        }
    })();
</script>