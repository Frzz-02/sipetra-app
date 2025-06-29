<ul class="navbar-nav sidebar sidebar-dark accordion" id="accordionSidebar" style="background-color: #bb9587; z-index: 1030; height: 100vh;">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('dashboard_hewan') }}">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-paw text-white"></i>
        </div>
        <div class="sidebar-brand-text mx-3">SiPETRA</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Dashboard -->
    <li class="nav-item {{ Request::routeIs('dashboard_hewan') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('dashboard_hewan') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Riwayat -->
    <li class="nav-item {{ Request::routeIs('riwayat.pesanan') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('riwayat.pesanan') }}">
            <i class="fas fa-fw fa-history"></i>
            <span>Riwayat Pesanan</span>
        </a>
    </li>


    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
