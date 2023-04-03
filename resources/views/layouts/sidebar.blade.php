<ul class="navbar-nav bg-sidebar sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="">
        <img src="{{ asset('img/logo.webp') }}" width="100px">
    </a>
    <!-- Divider -->
    <hr class="sidebar-divider">
    <!-- Heading -->

    <div class="sidebar-heading">
        Menu
    </div>

    <!-- Nav Item - Beranda -->

    <!-- Nav Item - Pengguna -->
    @if (auth()->user()->id_role == '1')
        <li class="nav-item {{ request()->is('superadmin') ? 'active' : '' }}">
            <a class="nav-link" href="/superadmin">
                <i class="fas fa-fw fa-home"></i>
                <span>Dashboard</span></a>
        </li>

        <li class="nav-item {{ request()->is('superadmin/datauser') ? 'active' : '' }}">
            <a class="nav-link" href="/superadmin/datauser">
                <i class="fas fa-fw fa-user"></i>
                <span>Data User</span></a>
        </li>
        {{-- <li class="nav-item {{ request()->is('dokumen_terbuka_user') | request()->is('') ? 'active' : '' }}">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseSuperadmin"
                aria-controls="collapseTwo">
                <i class="fas fa-fw fa-file-alt"></i>
                <span>Dokumen</span>
            </a>
            <div id="collapseSuperadmin" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item {{ request()->is('') ? 'active' : '' }}" href="/dokumen_terbuka_user">
                        <i class="fas fa-fw fa-square fa-xs"></i>
                        <span>Terbuka</span>
                    </a>
                    <a class="collapse-item {{ request()->is('') ? 'active' : '' }}" href="/dokumen_terbatas_user">
                        <i class="fas fa-fw fa-square fa-xs"></i>
                        <span>Terbatas</span>
                    </a>
                </div>
            </div>
        </li> --}}
    @endif


    {{-- UNTUK TAMPILAN SUPER ADMIN --}}


    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
