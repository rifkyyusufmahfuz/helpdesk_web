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

        <li
            class="nav-item {{ request()->is('superadmin/datauseraktif') | request()->is('superadmin/datausernonaktif') | request()->is('superadmin/datapegawai') ? 'active' : '' }}">
            <a class="nav-link {{ request()->is('superadmin/datauseraktif') || request()->is('superadmin/datausernonaktif') || request()->is('superadmin/datapegawai') ? '' : 'collapsed' }}"
                href="#" data-toggle="collapse" data-target="#collapseSuperadmin" aria-controls="collapseTwo">
                <i class="fas fa-fw fa-users"></i>
                <span>Informasi User</span>
            </a>
            <div id="collapseSuperadmin"
                class="collapse {{ request()->is('superadmin/datauseraktif') || request()->is('superadmin/datausernonaktif') || request()->is('superadmin/datapegawai') ? 'show' : '' }}"
                aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item {{ request()->is('superadmin/datauseraktif') ? 'active' : '' }}"
                        href="/superadmin/datauseraktif">
                        <i class="fas fa-fw fa-user"></i>
                        <span>Data User Aktif</span>
                    </a>
                    <a class="collapse-item {{ request()->is('superadmin/datausernonaktif') ? 'active' : '' }}"
                        href="/superadmin/datausernonaktif">
                        <i class="fas fa-fw fa-user"></i>
                        <span>Data User Nonaktif</span>
                    </a>
                    <a class="collapse-item {{ request()->is('superadmin/datapegawai') ? 'active' : '' }}"
                        href="/superadmin/datapegawai">
                        <i class="fas fa-fw fa-briefcase"></i>
                        <span>Data Pegawai</span>
                    </a>
                </div>
            </div>
        </li>
    @endif

    {{-- MENU UNTUK USER PEGAWAI --}}
    @if (auth()->user()->id_role == '4')
        <li class="nav-item {{ request()->is('pegawai') ? 'active' : '' }}">
            <a class="nav-link" href="/pegawai">
                <i class="fas fa-fw fa-home"></i>
                <span>Dashboard</span>
            </a>
        </li>

        <li class="nav-item {{ request()->is('pegawai/permintaan_software') | request()->is('') ? 'active' : '' }}">
            <a class="nav-link {{ request()->is('pegawai/permintaan_software') || request()->is('') ? '' : 'collapsed' }}"
                href="#" data-toggle="collapse" data-target="#collapseSuperadmin" aria-controls="collapseTwo">
                <i class="fas fa-fw fa-cog"></i>
                <span>Permintaan Layanan</span>
            </a>
            <div id="collapseSuperadmin"
                class="collapse {{ request()->is('pegawai/permintaan_software') || request()->is('') ? 'show' : '' }}"
                aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item {{ request()->is('pegawai/permintaan_software') ? 'active' : '' }}"
                        href="/pegawai/permintaan_software">
                        <i class="fas fa-fw fa-laptop-code"></i>
                        <span>Instalasi Software</span>
                    </a>
                    <a class="collapse-item {{ request()->is('') ? 'active' : '' }}" href="">
                        <i class="fas fa-fw fa-tools"></i>
                        <span>Pengecekan Hardware</span>
                    </a>
                </div>
            </div>
        </li>
    @endif


    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
