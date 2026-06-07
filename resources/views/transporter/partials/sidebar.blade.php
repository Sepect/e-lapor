<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">


    <div class="text-center py-2 border-bottom border-secondary text-white">
        <small class="d-block text-muted" style="font-size: 0.7rem;">UPT PLB3 DINAS PENGELOLAAN</small>
        <span class="fw-bold" style="font-size: 0.9rem;">LINGKUNGAN HIDUP</span>
    </div>

    <div class="text-center mb-4 p-2 bg-white">
        <img src="{{ asset('assets/img/logo_pemprov.png') }}" alt="Logo Pemprov" class="img-fluid"
            style="max-height: 100px; width: auto;">
    </div>

    <div class="sidebar-wrapper">
        <nav class="mt-2">
            <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu">

                <li class="nav-item">
                    <a href="{{ route('transporter.dashboard') }}"
                        class="nav-link {{ request()->routeIs('transporter.dashboard') ? 'active bg-success' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>



                <!-- Profil & Kontrak -->
                <li
                    class="nav-item {{ request()->routeIs('transporter.profil') || request()->routeIs('transporter.kontrak') ? 'menu-open' : '' }}">
                    <a href="#"
                        class="nav-link {{ request()->routeIs('transporter.profil') || request()->routeIs('transporter.kontrak') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-building"></i>
                        <p>
                            Profil & Kontrak
                            <i class="nav-arrow fas fa-angle-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('transporter.profil') }}"
                                class="nav-link {{ request()->routeIs('transporter.profil') ? 'active bg-success' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Profil Transporter</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('transporter.kontrak') }}"
                                class="nav-link {{ request()->routeIs('transporter.kontrak') ? 'active bg-success' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Kontrak Kerjasama</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Pengangkutan Limbah -->
                <li
                    class="nav-item {{ request()->routeIs('transporter.limbah') || request()->routeIs('transporter.beritaAcara') ? 'menu-open' : '' }}">
                    <a href="#"
                        class="nav-link {{ request()->routeIs('transporter.limbah') || request()->routeIs('transporter.beritaAcara') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-balance-scale"></i>
                        <p>
                            Pengangkutan Limbah
                            <i class="nav-arrow fas fa-angle-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('transporter.limbah') }}"
                                class="nav-link {{ request()->routeIs('transporter.limbah') ? 'active bg-success' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Pengangkutan Limbah B3</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('transporter.beritaAcara') }}"
                                class="nav-link {{ request()->routeIs('transporter.beritaAcara') ? 'active bg-success' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>BA Penerimaan Limbah B3</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Keuangan -->
                <li
                    class="nav-item {{ request()->routeIs('transporter.tagihan') || request()->routeIs('transporter.pad') || request()->routeIs('transporter.retribusi') ? 'menu-open' : '' }}">
                    <a href="#"
                        class="nav-link {{ request()->routeIs('transporter.tagihan') || request()->routeIs('transporter.pad') || request()->routeIs('transporter.retribusi') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-wallet"></i>
                        <p>
                            Keuangan
                            <i class="nav-arrow fas fa-angle-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('transporter.tagihan') }}"
                                class="nav-link {{ request()->routeIs('transporter.tagihan') ? 'active bg-success' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Surat Tagihan</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('transporter.pad') }}"
                                class="nav-link {{ request()->routeIs('transporter.pad') ? 'active bg-success' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Setor PAD</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('transporter.retribusi') }}"
                                class="nav-link {{ request()->routeIs('transporter.retribusi') ? 'active bg-success' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Setor Retribusi</p>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
    </div>
</aside>