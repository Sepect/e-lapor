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
                    <a href="{{ route('penghasil.dashboard') }}"
                        class="nav-link {{ request()->routeIs('penghasil.dashboard') ? 'active bg-success' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <!-- Profil & Kontrak -->
                <li
                    class="nav-item {{ request()->routeIs('penghasil.profil') || request()->routeIs('penghasil.kontrak') ? 'menu-open' : '' }}">
                    <a href="#"
                        class="nav-link {{ request()->routeIs('penghasil.profil') || request()->routeIs('penghasil.kontrak') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-building"></i>
                        <p>
                            Profil & Kontrak
                            <i class="nav-arrow fas fa-angle-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('penghasil.profil') }}"
                                class="nav-link {{ request()->routeIs('penghasil.profil') ? 'active bg-success' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Profil Penghasil</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('penghasil.kontrak') }}"
                                class="nav-link {{ request()->routeIs('penghasil.kontrak') ? 'active bg-success' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Kontrak Kerjasama</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Pengelolaan Limbah -->
                <li
                    class="nav-item {{ request()->routeIs('penghasil.limbah') || request()->routeIs('penghasil.beritaAcara') ? 'menu-open' : '' }}">
                    <a href="#"
                        class="nav-link {{ request()->routeIs('penghasil.limbah') || request()->routeIs('penghasil.beritaAcara') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-balance-scale"></i>
                        <p>
                            Pengelolaan Limbah
                            <i class="nav-arrow fas fa-angle-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('penghasil.limbah') }}"
                                class="nav-link {{ request()->routeIs('penghasil.limbah') ? 'active bg-success' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Jumlah Limbah Diolah</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('penghasil.beritaAcara') }}"
                                class="nav-link {{ request()->routeIs('penghasil.beritaAcara') ? 'active bg-success' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>BA Penerimaan Limbah B3</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Keuangan -->
                <li
                    class="nav-item {{ request()->routeIs('penghasil.tagihan') || request()->routeIs('penghasil.pembayaran') ? 'menu-open' : '' }}">
                    <a href="#"
                        class="nav-link {{ request()->routeIs('penghasil.tagihan') || request()->routeIs('penghasil.pembayaran') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-wallet"></i>
                        <p>
                            Keuangan
                            <i class="nav-arrow fas fa-angle-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('penghasil.tagihan') }}"
                                class="nav-link {{ request()->routeIs('penghasil.tagihan') ? 'active bg-success' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Tagihan & Laporan</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('penghasil.pembayaran') }}"
                                class="nav-link {{ request()->routeIs('penghasil.pembayaran') ? 'active bg-success' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Setor Biaya Pengolahan</p>
                            </a>
                        </li>
                    </ul>
                </li>

            </ul>
        </nav>
    </div>
</aside>