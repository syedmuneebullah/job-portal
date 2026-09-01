<script>
    document.addEventListener('DOMContentLoaded', function() {
        
        // ===== DOM ELEMENTS =====
        const sidebar = document.getElementById('sidebar');
        const mainContent = document.getElementById('mainContent');
        const toggleBtn = document.getElementById('toggleSidebar');
        const profileBtn = document.getElementById('profileBtn');
        const profileDropdown = document.getElementById('profileDropdown');
        const notificationBtn = document.getElementById('notificationBtn');
        const notificationDropdown = document.getElementById('notificationDropdown');
        
        let isSidebarCollapsed = false;
        let isHovering = false;
        let hoverTimeout = null;
        
        // ===== HELPER FUNCTIONS =====
        function hideAllText() {
            const navLinkTexts = document.querySelectorAll('.nav-link-text');
            const navLabels = document.querySelectorAll('.sidebar-nav-label');
            const navBadges = document.querySelectorAll('.nav-badge');
            const brandText = document.querySelector('.sidebar-brand-text');
            const userInfo = document.querySelector('.sidebar-user-info');
            const footerText = document.querySelector('.sidebar-footer-text');
            const tooltips = document.querySelectorAll('.nav-tooltip');
            
            navLinkTexts.forEach(el => el.classList.add('hidden'));
            navLabels.forEach(el => el.classList.add('hidden'));
            navBadges.forEach(el => el.classList.add('hidden'));
            if (brandText) brandText.classList.add('hidden');
            if (userInfo) userInfo.classList.add('hidden');
            if (footerText) footerText.classList.add('hidden');
            
            // Tooltips ko visible rakho (only when collapsed)
            tooltips.forEach(el => el.style.display = '');
        }
        
        function showAllText() {
            const navLinkTexts = document.querySelectorAll('.nav-link-text');
            const navLabels = document.querySelectorAll('.sidebar-nav-label');
            const navBadges = document.querySelectorAll('.nav-badge');
            const brandText = document.querySelector('.sidebar-brand-text');
            const userInfo = document.querySelector('.sidebar-user-info');
            const footerText = document.querySelector('.sidebar-footer-text');
            const tooltips = document.querySelectorAll('.nav-tooltip');
            
            navLinkTexts.forEach(el => el.classList.remove('hidden'));
            navLabels.forEach(el => el.classList.remove('hidden'));
            navBadges.forEach(el => el.classList.remove('hidden'));
            if (brandText) brandText.classList.remove('hidden');
            if (userInfo) userInfo.classList.remove('hidden');
            if (footerText) footerText.classList.remove('hidden');
            
            // Tooltips ko hide karo jab expand ho
            tooltips.forEach(el => el.style.display = 'none');
        }
        
        function collapseSidebar() {
            sidebar.style.width = '70px';
            mainContent.style.marginLeft = '70px';
            sidebar.classList.add('collapsed');
            hideAllText();
            isSidebarCollapsed = true;
        }
        
        function expandSidebar() {
            sidebar.style.width = '260px';
            mainContent.style.marginLeft = '260px';
            sidebar.classList.remove('collapsed');
            showAllText();
            isSidebarCollapsed = false;
        }
        
        // ===== SIDEBAR TOGGLE =====
        toggleBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            
            if (isSidebarCollapsed) {
                expandSidebar();
            } else {
                collapseSidebar();
            }
        });
        
        // ===== HOVER TO EXPAND =====
        sidebar.addEventListener('mouseenter', function() {
            if (isSidebarCollapsed) {
                clearTimeout(hoverTimeout);
                isHovering = true;
                
                // Expand on hover
                sidebar.style.width = '260px';
                mainContent.style.marginLeft = '260px';
                sidebar.classList.remove('collapsed');
                showAllText();
                
                // Hide tooltips when hovered
                document.querySelectorAll('.nav-tooltip').forEach(el => {
                    el.style.display = 'none';
                });
            }
        });
        
        sidebar.addEventListener('mouseleave', function() {
            if (isSidebarCollapsed && isHovering) {
                // Delay to prevent accidental collapse
                hoverTimeout = setTimeout(function() {
                    // Collapse back
                    sidebar.style.width = '70px';
                    mainContent.style.marginLeft = '70px';
                    sidebar.classList.add('collapsed');
                    hideAllText();
                    isHovering = false;
                    
                    // Show tooltips again
                    document.querySelectorAll('.nav-tooltip').forEach(el => {
                        el.style.display = '';
                    });
                }, 300);
            }
        });
        
        // ===== PROFILE DROPDOWN =====
        profileBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            profileDropdown.classList.toggle('hidden');
            notificationDropdown.classList.add('hidden');
        });
        
        // ===== NOTIFICATION DROPDOWN =====
        notificationBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            notificationDropdown.classList.toggle('hidden');
            profileDropdown.classList.add('hidden');
        });
        
        // ===== CLOSE DROPDOWNS ON OUTSIDE CLICK =====
        document.addEventListener('click', function(e) {
            if (!profileBtn.contains(e.target) && !profileDropdown.contains(e.target)) {
                profileDropdown.classList.add('hidden');
            }
            if (!notificationBtn.contains(e.target) && !notificationDropdown.contains(e.target)) {
                notificationDropdown.classList.add('hidden');
            }
        });
        
        // ===== RESPONSIVE: Auto collapse on small screens =====
        function handleResponsive() {
            if (window.innerWidth < 768) {
                if (!isSidebarCollapsed) {
                    collapseSidebar();
                }
            } else {
                // Only expand if not collapsed by user
                if (isSidebarCollapsed && !isHovering) {
                    // Don't auto-expand on desktop if user collapsed it
                    // But if it was collapsed by responsive, expand it
                    if (window.innerWidth >= 768) {
                        // Check if it was collapsed by user or by responsive
                        const wasResponsiveCollapse = localStorage.getItem('sidebarResponsive');
                        if (!wasResponsiveCollapse) {
                            expandSidebar();
                        }
                    }
                }
            }
        }
        
        // Store responsive state
        function setResponsiveState(collapsed) {
            localStorage.setItem('sidebarResponsive', collapsed ? 'true' : 'false');
        }
        
        // Override collapse/expand to track user action
        const originalCollapse = collapseSidebar;
        const originalExpand = expandSidebar;
        
        collapseSidebar = function() {
            originalCollapse();
            setResponsiveState(false);
        };
        
        expandSidebar = function() {
            originalExpand();
            setResponsiveState(false);
        };
        
        handleResponsive();
        window.addEventListener('resize', handleResponsive);
        
        // ===== TOOLTIP POSITIONING =====
        function positionTooltips() {
            document.querySelectorAll('.nav-tooltip').forEach(tooltip => {
                const parent = tooltip.closest('.nav-item');
                if (parent) {
                    // Remove old event listeners by cloning
                    const newTooltip = tooltip.cloneNode(true);
                    tooltip.parentNode.replaceChild(newTooltip, tooltip);
                    
                    parent.addEventListener('mouseenter', function() {
                        if (isSidebarCollapsed && !isHovering) {
                            const rect = this.getBoundingClientRect();
                            const tooltipEl = this.querySelector('.nav-tooltip');
                            if (tooltipEl) {
                                tooltipEl.style.left = (rect.left + 75) + 'px';
                                tooltipEl.style.top = (rect.top + rect.height / 2) + 'px';
                                tooltipEl.style.display = 'flex';
                            }
                        }
                    });
                    
                    parent.addEventListener('mouseleave', function() {
                        const tooltipEl = this.querySelector('.nav-tooltip');
                        if (tooltipEl) {
                            tooltipEl.style.display = 'none';
                        }
                    });
                }
            });
        }
        
        positionTooltips();
        
        // ===== KEYBOARD SHORTCUT: Ctrl + B to toggle =====
        document.addEventListener('keydown', function(e) {
            if (e.ctrlKey && e.key === 'b') {
                e.preventDefault();
                toggleBtn.click();
            }
        });
        
        console.log('Admin Panel Loaded Successfully!');
        console.log('💡 Tip: Press Ctrl + B to toggle sidebar');
        
    });
</script>