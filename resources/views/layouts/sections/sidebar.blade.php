<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('dashboard') }}">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">V&E Admin</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item {{ $active == 'dashboard' ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>
    <li class="nav-item {{ $active == 'users' ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('users') }}">
            <i class="fas fa-user"></i>
            <span>User</span></a>
    </li>
    <li class="nav-item {{ $active == 'videos' ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('videos') }}">
            <i class="bi bi-camera-video-fill"></i>
            <span>Video</span></a>
    </li>
    <li class="nav-item {{ $active == 'reports' ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('reports') }}">
            <i class="bi bi-flag-fill"></i>
            <span>Report</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>
<!-- End of Sidebar -->
