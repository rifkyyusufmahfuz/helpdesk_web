<ul class="navbar-nav bg-sidebar sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="">
        <img src="{{ asset('custom_script/img/logo.webp') }}" width="100px">
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
                        <i class="fas fa-fw fa-user-check"></i>
                        <span>Data User Aktif</span>
                    </a>
                    <a class="collapse-item {{ request()->is('superadmin/datausernonaktif') ? 'active' : '' }}"
                        href="/superadmin/datausernonaktif">
                        <i class="fas fa-fw fa-user-times"></i>
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

        <li
            class="nav-item {{ request()->is('pegawai/permintaan_software') || request()->is('pegawai/permintaan_hardware') ? 'active' : '' }}">
            <a class="nav-link {{ request()->is('pegawai/permintaan_software') || request()->is('pegawai/permintaan_hardware') ? '' : 'collapsed' }}"
                href="#" data-toggle="collapse" data-target="#collapseSuperadmin" aria-controls="collapseTwo">
                <i class="fas fa-fw fa-cog"></i>
                <span>Permintaan Layanan</span>
            </a>
            <div id="collapseSuperadmin"
                class="collapse {{ request()->is('pegawai/permintaan_software') || request()->is('pegawai/permintaan_hardware') ? 'show' : '' }}"
                aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item {{ request()->is('pegawai/permintaan_software') ? 'active' : '' }}"
                        href="/pegawai/permintaan_software">
                        <i class="fas fa-fw fa-laptop-code"></i>
                        <span>Instalasi Software</span>
                    </a>
                    <a class="collapse-item {{ request()->is('pegawai/permintaan_hardware') ? 'active' : '' }}"
                        href="/pegawai/permintaan_hardware">
                        <i class="fas fa-fw fa-tools"></i>
                        <span>Pengecekan Hardware</span>
                    </a>
                </div>
            </div>
        </li>
    @endif



    {{-- MENU UNTUK USER ADMIN --}}
    @if (auth()->user()->id_role == '2')
        <li class="nav-item {{ request()->is('admin') ? 'active' : '' }}">
            <a class="nav-link" href="/admin">
                <i class="fas fa-fw fa-home"></i>
                <span>Dashboard</span>
            </a>
        </li>

        {{-- MENU PERMINTAAN LAYANAN --}}
        <li
            class="nav-item {{ request()->is('admin/permintaan_software*') || request()->is('admin/permintaan_hardware*') ? 'active' : '' }}">
            <a class="nav-link {{ request()->is('admin/permintaan_software*') || request()->is('admin/permintaan_hardware*') ? '' : 'collapsed' }}"
                href="#" data-toggle="collapse" data-target="#collapseSuperadmin" aria-controls="collapseTwo">
                <i class="fas fa-fw fa-cog"></i>
                <span>Permintaan Layanan</span>
                @php
                    $permintaan_count = DB::table('permintaan')
                        ->where('status_permintaan', '1')
                        ->count();
                @endphp
                @if ($permintaan_count > 0)
                    <span class="badge badge-danger badge-pill badge-counter">{{ $permintaan_count }}</span>
                @endif
            </a>
            <div id="collapseSuperadmin"
                class="collapse {{ request()->is('admin/permintaan_software*') || request()->is('admin/permintaan_hardware*') ? 'show' : '' }}"
                aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    {{-- PERMINTAAN INSTALASI SOFTWARE --}}
                    <a class="collapse-item {{ request()->is('admin/permintaan_software*') ? 'active' : '' }}"
                        href="/admin/permintaan_software">
                        <i class="fas fa-fw fa-laptop-code"></i>
                        <span>Instalasi Software</span>
                        @php
                            $permintaan_software_count = DB::table('permintaan')
                                ->where('status_permintaan', '1')
                                ->where('tipe_permintaan', 'software')
                                ->count();
                        @endphp
                        @if ($permintaan_software_count > 0)
                            <span
                                class="badge badge-danger badge-pill badge-counter">{{ $permintaan_software_count }}</span>
                        @endif
                    </a>
                    {{-- PERMINTAAN PENGECEKAN HARDWARE --}}
                    <a class="collapse-item {{ request()->is('admin/permintaan_hardware*') ? 'active' : '' }}"
                        href="/admin/permintaan_hardware">
                        <i class="fas fa-fw fa-tools"></i>
                        <span>Pengecekan Hardware</span>
                        @php
                            $permintaan_hardware_count = DB::table('permintaan')
                                ->where('status_permintaan', '1')
                                ->where('tipe_permintaan', 'hardware')
                                ->count();
                        @endphp
                        @if ($permintaan_hardware_count > 0)
                            <span
                                class="badge badge-danger badge-counter badge-pill">{{ $permintaan_hardware_count }}</span>
                        @endif
                    </a>
                </div>
            </div>
        </li>
    @endif



    {{-- MENU UNTUK USER MANAGER --}}
    @if (auth()->user()->id_role == '3')
        <li class="nav-item {{ request()->is('manager') ? 'active' : '' }}">
            <a class="nav-link" href="/manager">
                <i class="fas fa-fw fa-home"></i>
                <span>Dashboard</span>
            </a>
        </li>

        {{-- MENU PERMINTAAN Software --}}
        <li
            class="nav-item {{ request()->is('manager/permintaan_software*') || request()->is('manager/riwayat_otorisasi*') || request()->is('') ? 'active' : '' }}">
            <a class="nav-link {{ request()->is('manager/permintaan_software*') || request()->is('manager/riwayat_otorisasi*') || request()->is('') ? '' : 'collapsed' }}"
                href="#" data-toggle="collapse" data-target="#collapseSoftware" aria-controls="collapseTwo">
                <i class="fas fa-fw fa-cog"></i>
                <span>Permintaan Software</span>
                @php
                    $permintaan_count = DB::table('permintaan')
                        ->join('otorisasi', 'otorisasi.id_otorisasi', '=', 'permintaan.id_otorisasi')
                        ->where('status_approval', 'waiting')
                        ->where('tipe_permintaan', 'software')
                        ->count();
                @endphp
                @if ($permintaan_count > 0)
                    <span class="badge badge-danger badge-pill badge-counter">{{ $permintaan_count }}</span>
                @endif
            </a>
            <div id="collapseSoftware"
                class="collapse {{ request()->is('manager/permintaan_software*') || request()->is('manager/riwayat_otorisasi*') ? 'show' : '' }}"
                aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    {{-- PERMINTAAN INSTALASI SOFTWARE --}}
                    <a class="collapse-item {{ request()->is('manager/permintaan_software*') ? 'active' : '' }}"
                        href="/manager/permintaan_software">
                        <i class="fas fa-fw fa-check"></i>
                        <span class="custom-span">Otorisasi Permintaan</span>
                        @php
                            $permintaan_software_count = DB::table('permintaan')
                                ->join('otorisasi', 'otorisasi.id_otorisasi', '=', 'permintaan.id_otorisasi')
                                ->where('status_approval', 'waiting')
                                ->where('tipe_permintaan', 'software')
                                ->count();
                        @endphp
                        @if ($permintaan_software_count > 0)
                            <span
                                class="badge badge-danger badge-pill badge-counter">{{ $permintaan_software_count }}</span>
                        @endif
                    </a>

                    {{-- PERMINTAAN REVISI --}}
                    <a class="collapse-item {{ request()->is('manager/riwayat_otorisasi*') ? 'active' : '' }}"
                        href="/manager/riwayat_otorisasi">
                        <i class="fas fa-fw fa-history"></i>
                        <span class="custom-span">Riwayat Otorisasi</span>
                    </a>
                </div>
            </div>
        </li>

        {{-- Permintaan hardware --}}
        <li
            class="nav-item {{ request()->is('manager/permintaan_hardware*') || request()->is('manager/riwayat_validasi*') ? 'active' : '' }}">
            <a class="nav-link {{ request()->is('manager/permintaan_hardware*') || request()->is('manager/riwayat_validasi*') ? '' : 'collapsed' }}"
                href="#" data-toggle="collapse" data-target="#collapseHardware" aria-controls="collapseTwo">
                <i class="fas fa-fw fa-cog"></i>
                <span>Pengecekan Hardware</span>
                @php
                    $permintaan_count = DB::table('permintaan')
                        ->join('otorisasi', 'otorisasi.id_otorisasi', '=', 'permintaan.id_otorisasi')
                        ->where('status_approval', 'waiting')
                        ->where('tipe_permintaan', 'hardware')
                        ->count();
                @endphp
                @if ($permintaan_count > 0)
                    <span class="badge badge-danger badge-pill badge-counter">{{ $permintaan_count }}</span>
                @endif
            </a>
            <div id="collapseHardware"
                class="collapse {{ request()->is('manager/permintaan_hardware*') || request()->is('manager/riwayat_validasi*') || request()->is('/manager/permintaan_hardware') ? 'show' : '' }}"
                aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    {{-- PERMINTAAN INSTALASI SOFTWARE --}}
                    <a class="collapse-item {{ request()->is('manager/permintaan_hardware*') ? 'active' : '' }}"
                        href="/manager/permintaan_hardware">
                        <i class="fas fa-fw fa-check"></i>
                        <span class="custom-span">Validasi Rekomendasi</span>
                        @php
                            $permintaan_software_count = DB::table('permintaan')
                                ->join('otorisasi', 'otorisasi.id_otorisasi', '=', 'permintaan.id_otorisasi')
                                ->where('status_approval', 'waiting')
                                ->where('tipe_permintaan', 'hardware')
                                ->count();
                        @endphp
                        @if ($permintaan_software_count > 0)
                            <span
                                class="badge badge-danger badge-pill badge-counter">{{ $permintaan_software_count }}</span>
                        @endif
                    </a>

                    {{-- PERMINTAAN REVISI --}}
                    <a class="collapse-item {{ request()->is('manager/riwayat_validasi*') ? 'active' : '' }}"
                        href="/manager/riwayat_validasi">
                        <i class="fas fa-fw fa-history"></i>
                        <span class="custom-span">Riwayat Validasi</span>
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
