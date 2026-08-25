<!-- ===== STYLES ===== -->
<style>
    /* custom styling layer – SwiftAI Recruit theme */
    .header-glass {
        background: rgba(255, 255, 255, 0.92);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border-bottom: 1px solid rgba(226, 232, 240, 0.5);
        box-shadow: 0 8px 30px -8px rgba(0, 20, 30, 0.06);
    }

    .logo-gradient {
        background: linear-gradient(135deg, #0B1A33 0%, #1A3A5C 70%, #2B5A7C 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        letter-spacing: -0.02em;
    }

    .nav-pill {
        transition: all 0.2s ease;
    }
    .nav-pill:hover {
        background: rgba(255, 255, 255, 0.7);
        color: #FF6B35;
        transform: scale(1.02);
    }

    .nav-link-hover {
        transition: all 0.2s ease;
    }
    .nav-link-hover:hover {
        background: rgba(255, 107, 53, 0.05);
        color: #FF6B35;
    }

    .mobile-menu-btn:active {
        transform: scale(0.94);
    }

    .focus-ring:focus {
        outline: 2px solid #FF6B35;
        outline-offset: 2px;
        border-radius: 9999px;
    }

    /* mobile menu smooth toggle */
    .mobile-menu {
        transition: all 0.25s cubic-bezier(0.2, 0.9, 0.3, 1);
        transform-origin: top;
        opacity: 0;
        transform: scaleY(0.96) translateY(-6px);
        display: block;
        pointer-events: none;
        visibility: hidden;
    }
    .mobile-menu.open {
        opacity: 1;
        transform: scaleY(1) translateY(0);
        pointer-events: auto;
        visibility: visible;
    }
    /* fallback hidden state (js will toggle class) */
    .mobile-menu.hidden {
        display: none !important;
        opacity: 0;
        pointer-events: none;
        visibility: hidden;
    }
    .mobile-menu:not(.hidden) {
        display: block;
        opacity: 1;
        transform: scaleY(1) translateY(0);
        pointer-events: auto;
        visibility: visible;
    }
</style>

<!-- ===== STYLES ===== -->
<style>
    .logo-gradient {
        background: linear-gradient(135deg, #D32F2F 0%, #B71C1C 70%, #880E0E 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        letter-spacing: -0.02em;
    }

    #backToTop.visible {
        opacity: 1;
        pointer-events: auto;
    }
</style>