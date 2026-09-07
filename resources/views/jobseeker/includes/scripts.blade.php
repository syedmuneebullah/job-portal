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
    const notificationList = document.getElementById('notificationList');
    const notificationBadge = document.getElementById('notificationBadge');
    const markAllReadBtn = document.getElementById('markAllReadBtn');
    
    let isSidebarCollapsed = false;
    let isHovering = false;
    let hoverTimeout = null;
    
    // ============================================================
    // HELPER FUNCTIONS - SIDEBAR
    // ============================================================
    
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
    
    // ============================================================
    // SIDEBAR EVENTS
    // ============================================================
    
    toggleBtn.addEventListener('click', function(e) {
        e.stopPropagation();
        if (isSidebarCollapsed) {
            expandSidebar();
        } else {
            collapseSidebar();
        }
    });
    
    sidebar.addEventListener('mouseenter', function() {
        if (isSidebarCollapsed) {
            clearTimeout(hoverTimeout);
            isHovering = true;
            sidebar.style.width = '260px';
            mainContent.style.marginLeft = '260px';
            sidebar.classList.remove('collapsed');
            showAllText();
            document.querySelectorAll('.nav-tooltip').forEach(el => {
                el.style.display = 'none';
            });
        }
    });
    
    sidebar.addEventListener('mouseleave', function() {
        if (isSidebarCollapsed && isHovering) {
            hoverTimeout = setTimeout(function() {
                sidebar.style.width = '70px';
                mainContent.style.marginLeft = '70px';
                sidebar.classList.add('collapsed');
                hideAllText();
                isHovering = false;
                document.querySelectorAll('.nav-tooltip').forEach(el => {
                    el.style.display = '';
                });
            }, 300);
        }
    });
    
    // ============================================================
    // NOTIFICATION FUNCTIONS
    // ============================================================
    
    // Toggle notifications dropdown
    if (notificationBtn) {
        notificationBtn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            // Hide profile dropdown if open
            if (profileDropdown) {
                profileDropdown.classList.add('hidden');
            }
            
            // Toggle notification dropdown
            if (notificationDropdown.style.display === 'none' || notificationDropdown.style.display === '') {
                notificationDropdown.style.display = 'block';
                loadNotifications();
            } else {
                notificationDropdown.style.display = 'none';
            }
        });
    }
    
    // Close notification dropdown when clicking outside
    document.addEventListener('click', function(e) {
        const container = document.getElementById('notificationContainer');
        const dropdown = document.getElementById('notificationDropdown');
        
        if (container && dropdown) {
            if (!container.contains(e.target)) {
                dropdown.style.display = 'none';
            }
        }
    });
    
    // Close dropdown on Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            const dropdown = document.getElementById('notificationDropdown');
            if (dropdown) {
                dropdown.style.display = 'none';
            }
        }
    });
    
    // Load notifications from server
    function loadNotifications() {
        if (!notificationList) return;
        
        fetch('/candidate/notifications/latest?limit=10')
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    renderNotifications(data.data);
                    updateBadge(data.unread_count);
                } else {
                    throw new Error(data.message || 'Failed to load notifications');
                }
            })
            .catch(error => {
                console.error('Error loading notifications:', error);
                notificationList.innerHTML = `
                    <div class="px-4 py-8 text-center text-gray-500">
                        <i class="fas fa-exclamation-circle text-3xl text-red-300 mb-2 block"></i>
                        <p class="text-sm">Failed to load notifications</p>
                        <button onclick="loadNotifications()" class="mt-2 text-xs text-blue-600 hover:underline">
                            <i class="fas fa-sync-alt mr-1"></i> Retry
                        </button>
                    </div>
                `;
            });
    }
    
    // Render notifications in dropdown
    function renderNotifications(notifications) {
        if (!notificationList) return;
        
        if (!notifications || notifications.length === 0) {
            notificationList.innerHTML = `
                <div class="px-4 py-8 text-center text-gray-500">
                    <i class="fas fa-bell-slash text-3xl text-gray-300 mb-2 block"></i>
                    <p class="text-sm">No notifications</p>
                </div>
            `;
            return;
        }

        let html = '';
        notifications.forEach(notification => {
            const showUrl = '/candidate/notifications/' + notification.id;
            const isRead = !notification.is_read ? 'bg-blue-50' : '';
            const newBadge = !notification.is_read ? '<span class="text-[10px] text-blue-600 font-medium">New</span>' : '';
            
            html += `
                <a href="${showUrl}" 
                   class="flex items-start gap-3 px-4 py-3 hover:bg-gray-50 transition-colors border-b border-gray-50 ${isRead}"
                   onclick="markAsRead(${notification.id})">
                    <div class="w-9 h-9 rounded-full ${getIconColor(notification.type)} flex items-center justify-center flex-shrink-0">
                        <i class="fas ${getIconClass(notification.type)} text-sm"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-800">${escapeHtml(notification.title)}</p>
                        <p class="text-xs text-gray-500 truncate">${escapeHtml(notification.message)}</p>
                        <div class="flex items-center justify-between mt-1">
                            <p class="text-[10px] text-gray-400">${formatTimeAgo(notification.created_at)}</p>
                            ${newBadge}
                        </div>
                    </div>
                </a>
            `;
        });
        
        notificationList.innerHTML = html;
    }
    
    // Escape HTML to prevent XSS
    function escapeHtml(text) {
        if (!text) return '';
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }
    
    // Get icon class based on notification type
    function getIconClass(type) {
        const icons = {
            'application_status_update': 'fa-user-check',
            'interview_scheduled': 'fa-calendar-plus',
            'interview_reminder': 'fa-clock',
            'interview_cancelled': 'fa-times-circle',
            'interview_rescheduled': 'fa-sync-alt',
            'meeting_link': 'fa-link',
            'new_application': 'fa-file-alt',
            'application_shortlisted': 'fa-star',
            'application_hired': 'fa-trophy',
            'application_rejected': 'fa-times'
        };
        return icons[type] || 'fa-bell';
    }
    
    // Get icon color based on notification type
    function getIconColor(type) {
        const colors = {
            'application_status_update': 'bg-blue-100 text-blue-600',
            'interview_scheduled': 'bg-green-100 text-green-600',
            'interview_reminder': 'bg-amber-100 text-amber-600',
            'interview_cancelled': 'bg-red-100 text-red-600',
            'interview_rescheduled': 'bg-purple-100 text-purple-600',
            'meeting_link': 'bg-blue-100 text-blue-600',
            'new_application': 'bg-emerald-100 text-emerald-600',
            'application_shortlisted': 'bg-yellow-100 text-yellow-600',
            'application_hired': 'bg-green-100 text-green-600',
            'application_rejected': 'bg-red-100 text-red-600'
        };
        return colors[type] || 'bg-gray-100 text-gray-600';
    }
    
    // Update notification badge
    function updateBadge(count) {
        if (!notificationBadge) return;
        
        if (count > 0) {
            notificationBadge.textContent = count > 99 ? '99+' : count;
            notificationBadge.style.display = 'flex';
        } else {
            notificationBadge.style.display = 'none';
        }
    }
    
    // Mark a single notification as read (make it global for inline onclick)
    window.markAsRead = function(id) {
        fetch('/candidate/notifications/' + id + '/mark-read', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                loadNotifications();
            }
        })
        .catch(error => console.error('Error marking as read:', error));
    };
    
    // Mark all notifications as read
    if (markAllReadBtn) {
        markAllReadBtn.addEventListener('click', function() {
            if (!confirm('Mark all notifications as read?')) return;
            
            fetch('/candidate/notifications/mark-all-read', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    loadNotifications();
                }
            })
            .catch(error => console.error('Error marking all as read:', error));
        });
    }
    
    // Format time ago
    function formatTimeAgo(dateString) {
        const date = new Date(dateString);
        const now = new Date();
        const diff = now - date;
        
        if (diff < 60000) return 'Just now';
        if (diff < 3600000) return Math.floor(diff / 60000) + 'm ago';
        if (diff < 86400000) return Math.floor(diff / 3600000) + 'h ago';
        if (diff < 604800000) return Math.floor(diff / 86400000) + 'd ago';
        return date.toLocaleDateString();
    }
    
    // ============================================================
    // PROFILE FUNCTIONS
    // ============================================================
    
    if (profileBtn && profileDropdown) {
        profileBtn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            // Hide notification dropdown if open
            if (notificationDropdown) {
                notificationDropdown.style.display = 'none';
            }
            
            // Toggle profile dropdown
            profileDropdown.classList.toggle('hidden');
        });
    }
    
    // Close profile dropdown when clicking outside
    document.addEventListener('click', function(e) {
        const container = document.getElementById('profileContainer');
        const dropdown = document.getElementById('profileDropdown');
        
        if (container && dropdown) {
            if (!container.contains(e.target)) {
                dropdown.classList.add('hidden');
            }
        }
    });
    
    // ============================================================
    // POLLING & INITIALIZATION
    // ============================================================
    
    // Load initial unread count on page load
    fetch('/candidate/notifications/unread-count')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                updateBadge(data.unread_count);
            }
        })
        .catch(error => console.error('Error loading unread count:', error));
    
    // Poll for new notifications every 30 seconds
    setInterval(function() {
        fetch('/candidate/notifications/unread-count')
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    updateBadge(data.unread_count);
                }
            })
            .catch(error => console.error('Error polling notifications:', error));
    }, 30000);
    
    // ============================================================
    // RESPONSIVE SIDEBAR
    // ============================================================
    
    function handleResponsive() {
        if (window.innerWidth < 768) {
            if (!isSidebarCollapsed) {
                collapseSidebar();
            }
        } else {
            if (isSidebarCollapsed && !isHovering) {
                if (window.innerWidth >= 768) {
                    const wasResponsiveCollapse = localStorage.getItem('sidebarResponsive');
                    if (!wasResponsiveCollapse) {
                        expandSidebar();
                    }
                }
            }
        }
    }
    
    function setResponsiveState(collapsed) {
        localStorage.setItem('sidebarResponsive', collapsed ? 'true' : 'false');
    }
    
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
    
    // ============================================================
    // TOOLTIP POSITIONING
    // ============================================================
    
    function positionTooltips() {
        document.querySelectorAll('.nav-tooltip').forEach(tooltip => {
            const parent = tooltip.closest('.nav-item');
            if (parent) {
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
    
    // ============================================================
    // KEYBOARD SHORTCUT
    // ============================================================
    
    document.addEventListener('keydown', function(e) {
        if (e.ctrlKey && e.key === 'b') {
            e.preventDefault();
            if (toggleBtn) {
                toggleBtn.click();
            }
        }
    });
    
    console.log('Admin Panel Loaded Successfully!');
    console.log('💡 Tip: Press Ctrl + B to toggle sidebar');
    
});
</script>