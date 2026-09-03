<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Panel - JobGenie')</title>

    <!-- Tailwind CSS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        * {
            font-family: 'Inter', sans-serif;
        }

        /* ===== CUSTOM SCROLLBAR ===== */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }
        ::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 10px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #a8a8a8;
        }

        /* ===== SIDEBAR TRANSITIONS ===== */
        .sidebar-transition {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* ===== DROPDOWN ANIMATIONS ===== */
        .dropdown-enter {
            animation: slideDown 0.2s ease-out;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* ===== SIDEBAR ACTIVE LINK ===== */
        .nav-link-active {
            background: rgba(255, 117, 67, 0.15) !important;
            border-right: 3px solid #FF7543 !important;
        }

        .nav-link-active i {
            color: #FF7543 !important;
        }

        /* ===== NOTIFICATION BADGE PULSE ===== */
        .badge-pulse {
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.1); }
            100% { transform: scale(1); }
        }

        /* ======================================== */
        /* ===== COLLAPSED SIDEBAR STYLES ===== */
        /* ======================================== */

        /* Hide text when collapsed */
        .sidebar.collapsed .sidebar-brand-text,
        .sidebar.collapsed .sidebar-user-info,
        .sidebar.collapsed .sidebar-nav-label,
        .sidebar.collapsed .nav-link-text,
        .sidebar.collapsed .nav-badge,
        .sidebar.collapsed .sidebar-footer-text {
            display: none !important;
        }

        /* Center icons when collapsed */
        .sidebar.collapsed .nav-link {
            justify-content: center !important;
            padding: 12px 0 !important;
            margin: 0 !important;
        }

        .sidebar.collapsed .nav-link i {
            font-size: 20px !important;
            margin: 0 !important;
        }

        .sidebar.collapsed .sidebar-brand {
            justify-content: center !important;
            padding: 18px 0 !important;
        }

        .sidebar.collapsed .sidebar-brand .brand-icon {
            margin: 0 !important;
        }

        .sidebar.collapsed .sidebar-user-profile {
            justify-content: center !important;
            padding: 12px 0 !important;
        }

        .sidebar.collapsed .sidebar-footer {
            justify-content: center !important;
            padding: 8px 0 !important;
        }

        .sidebar.collapsed .sidebar-footer .nav-link {
            justify-content: center !important;
            padding: 12px 0 !important;
        }

        /* ======================================== */
        /* ===== HOVER TO EXPAND STYLES ===== */
        /* ======================================== */

        /* Jab sidebar collapsed ho aur hover karein to expand ho */
        .sidebar.collapsed:hover {
            width: 260px !important;
        }

        /* Hover pe text dikhao */
        .sidebar.collapsed:hover .sidebar-brand-text,
        .sidebar.collapsed:hover .sidebar-user-info,
        .sidebar.collapsed:hover .sidebar-nav-label,
        .sidebar.collapsed:hover .nav-link-text,
        .sidebar.collapsed:hover .nav-badge,
        .sidebar.collapsed:hover .sidebar-footer-text {
            display: block !important;
        }

        /* Hover pe items left align ho jayein */
        .sidebar.collapsed:hover .nav-link {
            justify-content: flex-start !important;
            padding: 10px 12px !important;
            margin: 2px 8px !important;
        }

        .sidebar.collapsed:hover .nav-link i {
            font-size: 16px !important;
            margin-right: 12px !important;
        }

        .sidebar.collapsed:hover .sidebar-brand {
            justify-content: flex-start !important;
            padding: 20px 24px !important;
        }

        .sidebar.collapsed:hover .sidebar-brand .brand-icon {
            margin-right: 12px !important;
        }

        .sidebar.collapsed:hover .sidebar-user-profile {
            justify-content: flex-start !important;
            padding: 16px 24px !important;
        }

        .sidebar.collapsed:hover .sidebar-footer {
            justify-content: flex-start !important;
            padding: 12px 16px !important;
        }

        .sidebar.collapsed:hover .sidebar-footer .nav-link {
            justify-content: flex-start !important;
            padding: 10px 12px !important;
        }

        /* Hover pe badge bhi dikhao */
        .sidebar.collapsed:hover .nav-badge {
            display: inline-block !important;
            margin-left: auto !important;
        }

        /* Hover pe tooltip hide karo (kyunki full menu show ho raha hai) */
        .sidebar.collapsed:hover .nav-tooltip {
            display: none !important;
        }

        /* ======================================== */
        /* ===== TOOLTIP STYLES ===== */
        /* ======================================== */

        .nav-item {
            position: relative;
        }

        .nav-tooltip {
            position: fixed;
            left: 80px;
            top: 50%;
            transform: translateY(-50%);
            background: #1a237e;
            color: white;
            padding: 6px 14px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 500;
            white-space: nowrap;
            box-shadow: 0 4px 12px rgba(0,0,0,0.3);
            display: none !important;
            z-index: 9999;
            border: 1px solid rgba(255,255,255,0.1);
            pointer-events: none;
        }

        .nav-tooltip::before {
            content: '';
            position: absolute;
            left: -6px;
            top: 50%;
            transform: translateY(-50%);
            border-right: 6px solid #1a237e;
            border-top: 6px solid transparent;
            border-bottom: 6px solid transparent;
        }

        /* Tooltip only show when sidebar is collapsed AND not hovered */
        .sidebar.collapsed:not(:hover) .nav-item:hover .nav-tooltip {
            display: flex !important;
        }

        /* Hover effect on nav items when collapsed */
        .sidebar.collapsed .nav-item:hover .nav-link {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 8px;
        }

        /* ======================================== */
        /* ===== SMOOTH TRANSITIONS ===== */
        /* ======================================== */

        .sidebar,
        .sidebar .sidebar-brand,
        .sidebar .sidebar-user-profile,
        .sidebar .nav-link,
        .sidebar .sidebar-footer,
        .sidebar .sidebar-brand-text,
        .sidebar .sidebar-user-info,
        .sidebar .sidebar-nav-label,
        .sidebar .nav-link-text,
        .sidebar .nav-badge,
        .sidebar .sidebar-footer-text,
        .sidebar .nav-tooltip {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* ======================================== */
        /* ===== RESPONSIVE STYLES ===== */
        /* ======================================== */

        @media (max-width: 768px) {
            .sidebar {
                width: 70px !important;
            }

            .sidebar .sidebar-brand-text,
            .sidebar .sidebar-user-info,
            .sidebar .sidebar-nav-label,
            .sidebar .nav-link-text,
            .sidebar .nav-badge,
            .sidebar .sidebar-footer-text {
                display: none !important;
            }

            .sidebar .nav-link {
                justify-content: center !important;
                padding: 12px 0 !important;
            }

            .sidebar .nav-link i {
                font-size: 20px !important;
                margin: 0 !important;
            }

            .sidebar .sidebar-brand {
                justify-content: center !important;
                padding: 18px 0 !important;
            }

            .sidebar .sidebar-user-profile {
                justify-content: center !important;
                padding: 12px 0 !important;
            }

            .sidebar .sidebar-footer {
                justify-content: center !important;
                padding: 8px 0 !important;
            }

            #mainContent {
                margin-left: 70px !important;
            }

            /* Mobile pe bhi hover to expand kaam kare */
            .sidebar:hover {
                width: 260px !important;
            }

            .sidebar:hover .sidebar-brand-text,
            .sidebar:hover .sidebar-user-info,
            .sidebar:hover .sidebar-nav-label,
            .sidebar:hover .nav-link-text,
            .sidebar:hover .nav-badge,
            .sidebar:hover .sidebar-footer-text {
                display: block !important;
            }

            .sidebar:hover .nav-link {
                justify-content: flex-start !important;
                padding: 10px 12px !important;
            }

            .sidebar:hover .nav-link i {
                font-size: 16px !important;
                margin-right: 12px !important;
            }

            .sidebar:hover .sidebar-brand {
                justify-content: flex-start !important;
                padding: 20px 24px !important;
            }

            .sidebar:hover .sidebar-user-profile {
                justify-content: flex-start !important;
                padding: 16px 24px !important;
            }

            .sidebar:hover .sidebar-footer {
                justify-content: flex-start !important;
                padding: 12px 16px !important;
            }

            .sidebar:hover .nav-tooltip {
                display: none !important;
            }
        }

        /* ======================================== */
        /* ===== ADDITIONAL UTILITIES ===== */
        /* ======================================== */

        /* For hiding elements with JavaScript */
        .hidden {
            display: none !important;
        }

        /* For smooth hover effects on cards */
        .hover-scale {
            transition: transform 0.2s;
        }
        .hover-scale:hover {
            transform: scale(1.02);
        }

        /* For glassmorphism effects */
        .glass {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        .nav-link-active {
            background: rgba(255, 117, 67, 0.1) !important;
            border-right: 3px solid #FF7543 !important;
            color: #1a237e !important;
        }

        .nav-link-active i {
            color: #FF7543 !important;
        }

        /* Hover effect in light theme */
        .sidebar .nav-link:hover {
            background: #f3f4f6 !important;
            color: #1a237e !important;
        }

        .sidebar .nav-link:hover i {
            color: #FF7543 !important;
        }

        /* Tooltip in light theme */
        .nav-tooltip {
            background: #1a237e !important;
            color: white !important;
            border: 1px solid rgba(255,255,255,0.1) !important;
        }

        .nav-tooltip::before {
            border-right-color: #1a237e !important;
        }

        /* Collapsed sidebar in light theme */
        .sidebar.collapsed .nav-link {
            color: #6b7280 !important;
        }

        .sidebar.collapsed .nav-link i {
            color: #9ca3af !important;
        }

        .sidebar.collapsed .nav-link:hover {
            background: #f3f4f6 !important;
            color: #1a237e !important;
        }

        .sidebar.collapsed .nav-link:hover i {
            color: #FF7543 !important;
        }

        /* Hover to expand in light theme */
        .sidebar.collapsed:hover .nav-link {
            color: #6b7280 !important;
        }

        .sidebar.collapsed:hover .nav-link i {
            color: #9ca3af !important;
        }

        .sidebar.collapsed:hover .nav-link:hover {
            background: #f3f4f6 !important;
            color: #1a237e !important;
        }

        .sidebar.collapsed:hover .nav-link:hover i {
            color: #FF7543 !important;
        }

        /* Scrollbar in light theme */
        .sidebar::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        .sidebar::-webkit-scrollbar-thumb {
            background: #d1d5db;
            border-radius: 10px;
        }

        .sidebar::-webkit-scrollbar-thumb:hover {
            background: #9ca3af;
        }
    </style>

    @stack('styles')
</head>
<body>
    <div class="min-h-screen bg-gray-50/50">

        <!-- ===== SIDEBAR ===== -->
        @include('jobseeker.includes.sidebar')

        <!-- ===== MAIN CONTENT ===== -->
        <div id="mainContent" class="sidebar-transition" style="margin-left: 260px;">

            <!-- ===== HEADER ===== -->
            @include('jobseeker.includes.header')

            <!-- ===== PAGE CONTENT ===== -->
            <main class="p-6">
                @yield('content')
            </main>

        </div>

    </div>

    <!-- ===== SCRIPTS ===== -->
    @include('jobseeker.includes.scripts')

    @stack('scripts')

</body>
</html>
