<ul class="navbar-nav sidebar sidebar-dark accordion d-none d-lg-block" id="accordionSidebar" style="background-color: #bb9587; z-index: 1030; height: 100vh;">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('dashboard_hewan') }}">
        <div class="sidebar-brand-icon rotate-n-15">
             <img src="{{ asset('assets/image/sipetra.png') }}" alt="Logo SiPETRA" style="height: 40px; width: auto;">
        </div>
        <div class="sidebar-brand-text mx-3">SiPETRA</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Dashboard -->
    <li class="nav-item {{ Request::routeIs('penyedia.dashboard') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('penyedia.dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Riwayat -->
    <li class="nav-item {{ Request::routeIs('layanansaya') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('layanansaya') }}">
            <i class="fas fa-fw fa-history"></i>
            <span>Layanan</span>
        </a>
    </li>

     <li class="nav-item {{ Request::routeIs('karyawan.index') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('karyawan.index') }}">
            <i class="fas fa-fw fa-user"></i>
            <span>karyawan</span>
        </a>
    </li>
    <li class="nav-item {{ Request::routeIs('pesanantoko*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('pesanantoko') }}">
            <i class="fas fa-fw fa-store"></i>
            <span>Pesanan</span>
        </a>

        {{-- Submenu yang otomatis terbuka saat aktif --}}
       <div id="collapsePesanan" class="collapse {{ Request::routeIs('pesanantoko*') ? 'show' : '' }}">
            <div class="py-2 collapse-inner rounded">
                <a class="collapse-item {{ Request::routeIs('pesanantoko.diproses') ? 'active' : '' }}"
                href="{{ route('pesanantoko.diproses') }}">
                    Diproses
                </a>
                <a class="collapse-item {{ Request::routeIs('pesanantoko.menunggu') ? 'active' : '' }}"
                href="{{ route('pesanantoko.menunggu') }}">
                    Menunggu Diproses
                </a>
                <a class="collapse-item {{ Request::routeIs('pesanantoko.selesai') ? 'active' : '' }}"
                href="{{ route('pesanantoko.selesai') }}">
                    Selesai
                </a>
            </div>
        </div>

    </li>


    <li class="nav-item {{ Request::routeIs('tampilantoko') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('tampilantoko') }}">
            <i class="fas fa-fw fa-store"></i>
            <span>menejemen Tampilan</span>
        </a>
         <div id="collapsePesanan" class="collapse {{ Request::routeIs('tampilantoko*') ? 'show' : '' }}">
            <div class="py-2 collapse-inner rounded">
                <a class="collapse-item {{ Request::routeIs('penyedia.ulasan') ? 'active' : '' }}"
                href="{{ route('penyedia.ulasan') }}">
                    Ulasan
                </a>
                </div>
        </div>
    </li>


    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
