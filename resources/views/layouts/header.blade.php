<style>
    /* ---------------------------------------------------- */
    /* NEW LIGHT BLUE / NEON AESTHETIC STYLES (ALIGNMENT & LINE FIX) */
    /* ---------------------------------------------------- */

    /* 1. Base Sidebar Styling (Updated to Light Blue) */
    .main-sidebar.sidebar-dark-primary {
        background-color: #e0e7ea !important;
        color: #333333;
        width: 250px;
        min-height: 100vh;
        position: fixed;
        top: 0;
        left: 0;
        z-index: 1038;
        box-shadow: 2px 0 15px rgba(0, 0, 0, 0.1);
        transition: width 0.3s ease-in-out;
        display: flex;
        flex-direction: column;
    }

    /* Keep Content Wrapper functional */
    .content-wrapper,
    .main-header.navbar {
        margin-left: 250px;
        transition: margin-left 0.3s ease-in-out;
    }

    .sidebar-collapse .content-wrapper,
    .sidebar-collapse .main-header.navbar {
        margin-left: 80px;
    }

    /* Scrollbar Styling */
    .sidebar-wrapper::-webkit-scrollbar {
        width: 4px;
    }

    .sidebar-wrapper::-webkit-scrollbar-track {
        background: #e0e7ea;
    }

    .sidebar-wrapper::-webkit-scrollbar-thumb {
        background: #bbbbbb;
        border-radius: 2px;
    }

    .sidebar-wrapper {
        flex-grow: 1;
        overflow-y: auto;
        padding-bottom: 20px;
    }

    .nav-sidebar .nav-link p {
        white-space: nowrap !important;
    }


    /* 2. Top Logo/Title Section (FIXED: Stacked, Centered, No Line) */
    .brand-link {
        /* Important: Use flex-direction: column to stack content vertically */
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        height: 80px;
        /* Increased height to accommodate stacked text */
        padding: 10px 0;
        border-bottom: 0px !important;
        text-decoration: none;
        margin-bottom: 5px;
        /* ... other brand-link styles ... */
    }

    .brand-logo-container {
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
    }

    .brand-link .brand-image {
        float: none;
        height: 35px;
        max-width: 100%;
        margin: 0;
        margin-bottom: 4px;
        /* Small gap between logo and text */
    }

    .brand-text-stacked {
        display: block;
        font-size: 1.0rem;
        /* <-- CHANGE THIS VALUE (e.g., to 1.0rem or 1.1rem) */
        font-weight: 700;
        color: #363333 !important;
        letter-spacing: 0.5px;
    }

    /* 3. Navigation Menu (Main Items) */
    .nav-sidebar {
        padding: 0 10px;
    }

    .nav-sidebar>.nav-item {
        margin-bottom: 4px;
    }

    .nav-header {
        color: #292929 !important;
        font-size: 0.75rem !important;
        padding: 10px 15px 5px !important;
        text-transform: uppercase !important;
        font-weight: 600;
    }

    .nav-sidebar>.nav-item>.nav-link {
        color: #282828;
        padding: 10px 15px;
        display: flex;
        align-items: center;
        border-radius: 12px;
        transition: all 0.3s ease;
        font-weight: 500;
    }

    /* Hover State (Subtle background lift) */
    .nav-sidebar>.nav-item>.nav-link:hover {
        background-color: #fff0f5;
        color: #007bff;
    }

    /* Active State: Vibrant selection with a slight glow effect (The "blue box") */
    .nav-item.menu-open>.nav-link:not(.active) {
        /* Set parent link text color to a clear dark gray when open but not active */
        color: #333333 !important;
        background-color: transparent !important;
        box-shadow: none;
        border-left: none;
    }

    .nav-item.menu-open>.nav-link:not(.active) .nav-icon {
        /* Set the icon color for the open parent link */
        color: #333333 !important;
    }

    .nav-item.menu-open>.nav-link .right {
        /* Keep the arrow visible when menu is open */
        color: #555555;
    }

    /* Icons and Text */
    .nav-sidebar .nav-icon {
        font-size: 1.1rem;
        width: 30px;
        text-align: center;
        margin-right: 12px;
        color: #000000;
    }

    .nav-sidebar>.nav-item>.nav-link.active .nav-icon {
        color: #ffffff !important;
    }

    /* Right Arrow for Dropdowns */
    .nav-sidebar .right {
        color: #333333;
    }

    .nav-sidebar>.nav-item.menu-open>.nav-link .right {
        transform: rotate(-90deg);
        color: #999999;
    }

    /* 4. Treeview (Sub-menu) Styling - Seamless Look */
    /* 4. Treeview (Sub-menu) Styling - FIX VISIBILITY */
    .nav-treeview {
        /* Keep the light background color */
        background-color: #f0f0f0;
        border-radius: 12px;
        margin: 0;
        padding: 5px 0 5px 10px;
    }

    .nav-treeview .nav-item .nav-link {
        /* --- FIX: Made inactive text darker for visibility --- */
        color: #333333 !important;
        /* DARKER TEXT */
        font-weight: 600;
        padding: 8px 15px 8px 35px !important;
        font-size: 0.9rem;
        border-radius: 8px;
    }

    .nav-treeview .nav-icon {
        /* Also ensure the circle icons are visible */
        color: #555555 !important;
    }

    .nav-treeview .nav-item .nav-link.active {
        /* Active sub-link remains visible (blue text) */
        background-color: #e6f7ff !important;
        color: #007bff !important;
        font-weight: 600;
        box-shadow: none;
    }


    /* 6. Bottom Profile Card */
    .bottom-profile {
        margin: 15px 10px;
        padding: 15px;
        background-color: #e6f7ff;
        border-radius: 12px;
        display: flex;
        align-items: center;
        color: #333;
        box-shadow: 0 2px 8px rgba(0, 123, 255, 0.1);
    }

    .bottom-profile .user-image {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        margin-right: 12px;
        object-fit: cover;
        border: 2px solid #007bff;
        filter: drop-shadow(0 0 5px rgba(0, 123, 255, 0.3));
    }

    .bottom-profile .user-details .user-name {
        font-size: 0.95rem;
        font-weight: 700;
        color: #333333;
    }

    .bottom-profile .user-details .user-email {
        font-size: 0.75rem;
        color: #777777;
    }

    .bottom-profile .logout-icon {
        color: #333333;
        padding: 5px;
    }

    .bottom-profile .logout-icon:hover {
        background-color: #cceeff;
        color: #007bff;
    }

    /* 7. Top Navbar (Header) - Rounded Edges */
    .main-header.navbar {
        background-color: #ffffff;
        border-bottom: 1px solid #e0e0e0;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.03);
        border-top-right-radius: 12px;
        border-bottom-right-radius: 12px;
    }

    /* 8. Collapsed State Fixes */
    .sidebar-collapse .main-sidebar.sidebar-dark-primary {
        width: 80px;
    }

    /* --- FIX: Ensure no text is visible when collapsed --- */
    .sidebar-collapse .brand-link {
        flex-direction: column;
        height: 80px;
        padding: 10px 0;
        border-bottom: 0 !important;
        /* Final check for line removal on collapse */
    }

    .sidebar-collapse .brand-logo-container {
        display: none;
    }

    .sidebar-collapse .brand-link .brand-image {
        margin-right: 0;
        margin-bottom: 0;
    }

    .sidebar-collapse .nav-sidebar .nav-link p,
    .sidebar-collapse .nav-sidebar .right {
        display: none;
    }

    .sidebar-collapse .nav-sidebar>.nav-item>.nav-link {
        justify-content: center;
        margin: 5px auto;
        width: 50px;
        padding: 10px 0;
        border-left: none !important;
    }

    .sidebar-collapse .bottom-profile {
        display: none;
    }
</style>

{{-- Horizontal Navbar (Top Bar) --}}
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
    </ul>
    <ul class="navbar-nav ml-auto">
        <li class="nav-item d-flex align-items-center">
            <span id="datetime" class="text-muted"></span>
        </li>
    </ul>
</nav>

{{-- JavaScript for Date/Time (kept for functionality) --}}
<script>
    function updateDateTime() {
        const now = new Date();
        const options = {
            year: 'numeric',
            month: 'short',
            day: '2-digit',
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit',
            hour12: true
        };
        document.getElementById('datetime').textContent = now.toLocaleString('en-US', options);
    }

    updateDateTime();
    setInterval(updateDateTime, 1000);
</script>

{{-- Main Sidebar Container --}}
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    {{-- LOGO/TITLE HEADER AREA (Top) --}}
    <a href="javascript:;" class="brand-link">
        {{-- Logo Image --}}
        <img src="{{ url('dist/img/CSWD.png') }}" alt="CSWDO Logo" class="brand-image">

        <div class="brand-logo-container">
            {{-- Text Title --}}
            <span class="brand-text-stacked">CSWDO</span>
        </div>
    </a>

    {{-- Sidebar Content (Scrollable) --}}
    <div class="sidebar-wrapper">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">

                <li class="nav-header">MAIN</li>

                {{-- ================================================= --}}
                {{-- ADMIN LINKS (user_type == 1) --}}
                {{-- ================================================= --}}
                @if (Auth::user()->user_type == 1)
                    <li class="nav-item">
                        <a href="{{ url('admin/dashboard') }}"
                            class="nav-link @if (Request::segment(2) == 'dashboard') active @endif">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>

                    {{-- Clients Dropdown --}}
                    @php
                        $clientActive =
                            Request::segment(2) == 'client' ||
                            Request::segment(3) == 'missing-requirements' ||
                            Request::segment(2) == 'client_dependents';
                    @endphp
                    <li
                        class="nav-item has-treeview @if ($clientActive) menu-is-opening menu-open @endif">
                        <a href="#" class="nav-link @if ($clientActive) active @endif">
                            <i class="nav-icon fas fa-users"></i>
                            <p>
                                Clients
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ url('admin/client/list') }}"
                                    class="nav-link @if (Request::segment(3) == 'list' && Request::segment(2) == 'client') active @endif">
                                    <i class="fas fa-clipboard-list nav-icon"></i>
                                    <p>Client List</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ url('admin/client/missing-requirements') }}"
                                    class="nav-link @if (Request::segment(3) == 'missing-requirements') active @endif">
                                    <i class="fas fa-exclamation-triangle nav-icon"></i>
                                    <p>Missing Requirements</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ url('admin/client_dependents/list') }}"
                                    class="nav-link @if (Request::segment(2) == 'client_dependents') active @endif">
                                    <i class="fas fa-bed nav-icon"></i>
                                    <p>Patient</p>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item">
                        <a href="{{ url('admin/client_verification/list') }}"
                            class="nav-link @if (Request::segment(2) == 'client_verification') active @endif">
                            <i class="nav-icon fas fa-hands-helping"></i>
                            <p>Beneficiaries</p>
                        </a>
                    </li>

                    {{-- Documents Dropdown --}}
                    <li class="nav-item has-treeview @if (Request::segment(2) == 'ar') menu-open @endif">
                        <a href="#" class="nav-link @if (Request::segment(2) == 'ar') active @endif">
                            <i class="nav-icon fas fa-folder"></i>
                            <p>
                                Documents
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ url('admin/ar/list') }}"
                                    class="nav-link @if (Request::segment(3) == 'list' && Request::segment(2) == 'ar') active @endif">
                                    <i class="fas fa-file-alt nav-icon"></i>
                                    <p>AR Form</p>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item">
                        <a href="{{ url('admin/reports') }}"
                            class="nav-link @if (Request::segment(2) == 'reports') active @endif">
                            <i class="nav-icon fas fa-chart-bar"></i>
                            <p>Reports & Visualization</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ url('admin/classification') }}"
                            class="nav-link @if (Request::segment(2) == 'classification') active @endif">
                            <i class="nav-icon fas fa-brain"></i>
                            <p>Classification Analysis</p>
                        </a>
                    </li>

                    <li class="nav-header">ADMINISTRATION</li>

                    <li class="nav-item">
                        <a href="{{ route('admin.import.form') }}"
                            class="nav-link @if (Request::segment(2) == 'receipts' && Request::segment(3) == 'import') active @endif">
                            <i class="nav-icon fas fa-file-import"></i>
                            <p>Import Data</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ url('admin/admin/list') }}"
                            class="nav-link @if (Request::segment(2) == 'admin') active @endif">
                            <i class="nav-icon fas fa-user-tie"></i>
                            <p>Admin</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ url('admin/staff/list') }}"
                            class="nav-link @if (Request::segment(2) == 'staff') active @endif">
                            <i class="nav-icon fas fa-user-friends"></i>
                            <p>Staff</p>
                        </a>
                    </li>

                    <li class="nav-header">SETTINGS</li>

                    <li class="nav-item">
                        <a href="{{ url('admin/account') }}"
                            class="nav-link @if (Request::segment(2) == 'account') active @endif">
                            <i class="nav-icon fas fa-id-badge"></i>
                            <p>My Account</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ url('admin/change_password') }}"
                            class="nav-link @if (Request::segment(2) == 'change_password') active @endif">
                            <i class="nav-icon fas fa-key"></i>
                            <p>Change Password</p>
                        </a>
                    </li>

                    {{-- STAFF LINKS (user_type == 2) --}}
                @elseif(Auth::user()->user_type == 2)
                    <li class="nav-item">
                        <a href="{{ url('staff/dashboard') }}"
                            class="nav-link @if (Request::segment(2) == 'dashboard') active @endif">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>

                    {{-- Clients Dropdown --}}
                    @php
                        $staffClientActive =
                            Request::segment(2) == 'client' || Request::segment(2) == 'client_dependents';
                    @endphp
                    <li
                        class="nav-item has-treeview @if ($staffClientActive) menu-is-opening menu-open @endif">
                        <a href="#" class="nav-link @if ($staffClientActive) active @endif">
                            <i class="nav-icon fas fa-users"></i>
                            <p>
                                Clients
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ url('staff/client/list') }}"
                                    class="nav-link @if (Request::segment(2) == 'client') active @endif">
                                    <i class="fas fa-clipboard-list nav-icon"></i>
                                    <p>Client</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ url('staff/client_dependents/list') }}"
                                    class="nav-link @if (Request::segment(2) == 'client_dependents') active @endif">
                                    <i class="fas fa-bed nav-icon"></i>
                                    <p>Patient</p>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item">
                        <a href="{{ url('staff/client_verification/list') }}"
                            class="nav-link @if (Request::segment(2) == 'client_verification') active @endif">
                            <i class="nav-icon fas fa-hands-helping"></i>
                            <p>Beneficiaries</p>
                        </a>
                    </li>

                    {{-- Documents Dropdown --}}
                    <li class="nav-item has-treeview @if (Request::segment(2) == 'ar') menu-open @endif">
                        <a href="#" class="nav-link @if (Request::segment(2) == 'ar') active @endif">
                            <i class="nav-icon fas fa-folder"></i>
                            <p>
                                Documents
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ url('staff/ar/list') }}"
                                    class="nav-link @if (Request::segment(2) == 'ar') active @endif">
                                    <i class="fas fa-file-alt nav-icon"></i>
                                    <p>AR Form</p>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item">
                        <a href="{{ url('staff/reports') }}"
                            class="nav-link @if (Request::segment(2) == 'reports') active @endif">
                            <i class="nav-icon fas fa-chart-bar"></i>
                            <p>Reports & Visualization</p>
                        </a>
                    </li>

                    <li class="nav-header">SETTINGS</li>

                    <li class="nav-item">
                        <a href="{{ url('staff/account') }}"
                            class="nav-link @if (Request::segment(2) == 'account') active @endif">
                            <i class="nav-icon fas fa-id-badge"></i>
                            <p>My Account</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ url('staff/change_password') }}"
                            class="nav-link @if (Request::segment(2) == 'change_password') active @endif">
                            <i class="nav-icon fas fa-key"></i>
                            <p>Change Password</p>
                        </a>
                    </li>

                    {{-- STUDENT LINKS (user_type == 3) --}}
                @elseif(Auth::user()->user_type == 3)
                    <li class="nav-item">
                        <a href="{{ url('student/dashboard') }}"
                            class="nav-link @if (Request::segment(2) == 'dashboard') active @endif">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>
                    {{-- ... (Rest of Student Links) ... --}}

                    <li class="nav-header">SETTINGS</li>

                    <li class="nav-item">
                        <a href="{{ url('student/account') }}"
                            class="nav-link @if (Request::segment(2) == 'account') active @endif">
                            <i class="nav-icon fas fa-id-badge"></i>
                            <p>My Account</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ url('student/change_password') }}"
                            class="nav-link @if (Request::segment(2) == 'change_password') active @endif">
                            <i class="nav-icon fas fa-key"></i>
                            <p>Change Password</p>
                        </a>
                    </li>

                    {{-- PARENT LINKS (user_type == 4) --}}
                @elseif(Auth::user()->user_type == 4)
                    <li class="nav-item">
                        <a href="{{ url('parent/dashboard') }}"
                            class="nav-link @if (Request::segment(2) == 'dashboard') active @endif">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>
                    {{-- ... (Rest of Parent Links) ... --}}

                    <li class="nav-header">SETTINGS</li>

                    <li class="nav-item">
                        <a href="{{ url('parent/account') }}"
                            class="nav-link @if (Request::segment(2) == 'account') active @endif">
                            <i class="nav-icon fas fa-id-badge"></i>
                            <p>My Account</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ url('parent/change_password') }}"
                            class="nav-link @if (Request::segment(2) == 'change_password') active @endif">
                            <i class="nav-icon fas fa-key"></i>
                            <p>Change Password</p>
                        </a>
                    </li>
                @endif

                {{-- Global Logout Link --}}
                <li class="nav-item">
                    <a href="{{ url('logout') }}" class="nav-link">
                        <i class="nav-icon fas fa-sign-out-alt"></i>
                        <p>Logout</p>
                    </a>
                </li>
            </ul>
        </nav>

    </div> {{-- End sidebar-wrapper --}}

    {{-- Bottom Profile Card (Moved back to the bottom) --}}
    <div class="bottom-profile">
        <img src="{{ url('dist/img/user2-160x160.jpg') }}" class="user-image" alt="User Image">
        <div class="user-details">
            <div class="user-name">{{ Auth::user()->name }}</div>
            <div class="user-email">{{ Auth::user()->email }}</div>
        </div>
        <a href="{{ url('logout') }}" class="logout-icon" title="Logout">
            <i class="fas fa-sign-out-alt"></i>
        </a>
    </div>
</aside>