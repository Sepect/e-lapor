<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
    <div class="sidebar-brand bg-light text-center">
        <a href="#" class="brand-link">
            <img src="{{ asset('assets/img/logo_pemprov.png') }}" alt="Logo" class="brand-image"
                 style="opacity: 1; max-height: 40px;">
        </a>
    </div>

    <div class="text-center py-2 border-bottom border-secondary text-white">
        <small class="d-block text-muted" style="font-size: 0.7rem;">UPT PLB3 DINAS PENGELOLAAN</small>
        <span class="fw-bold" style="font-size: 0.9rem;">LINGKUNGAN HIDUP</span>
    </div>

    <div class="text-center mb-4 p-2 bg-white">
        <img src="{{ asset('assets/img/logo_pemprov.png') }}"
             alt="Logo Pemprov"
             class="img-fluid"
             style="max-height: 100px; width: auto;">
    </div>

    <div class="sidebar-wrapper">
        <nav class="mt-2">
            <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu">

                <li class="nav-item">
                    <a href="{{ route('transporter.dashboard') }}"
                       class="nav-link {{ request()->routeIs('transporter.dashboard') ? 'active bg-success' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>DASHBOARD</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('transporter.profil') }}"
                       class="nav-link {{ request()->routeIs('transporter.profil') ? 'active bg-success' : '' }}">
                        <i class="nav-icon fas fa-building"></i>
                        <p>PROFIL TRANSPORTER</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('transporter.kontrak') }}"
                       class="nav-link {{ request()->routeIs('transporter.kontrak') ? 'active bg-success' : '' }}">
                        <i class="nav-icon fas fa-handshake"></i>
                        <p>KONTRAK KERJASAMA</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('transporter.limbah') }}"
                       class="nav-link {{ request()->routeIs('transporter.limbah') ? 'active bg-success' : '' }}">
                        <i class="nav-icon fas fa-balance-scale"></i>
                        <p>PENGANGKUTAN<br>LIMBAH B3</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('transporter.beritaAcara') }}"
                       class="nav-link {{ request()->routeIs('transporter.beritaAcara') ? 'active bg-success' : '' }}">
                        <i class="nav-icon fas fa-file-contract"></i>
                        <p>BA PENERIMAAN<br>LIMBAH B3</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('transporter.tagihan') }}"
                       class="nav-link {{ request()->routeIs('transporter.tagihan') ? 'active bg-success' : '' }}">
                        <i class="nav-icon fas fa-file-invoice-dollar"></i>
                        <p>SURAT TAGIHAN</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('transporter.pad') }}"
                       class="nav-link {{ request()->routeIs('transporter.pad') ? 'active bg-success' : '' }}">
                        <i class="nav-icon fas fa-money-bill-wave"></i>
                        <p>SETOR PAD</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('transporter.retribusi') }}"
                       class="nav-link {{ request()->routeIs('transporter.retribusi') ? 'active bg-success' : '' }}">
                        <i class="nav-icon fas fa-money-bill-wave"></i>
                        <p>SETOR RETRIBUSI</p>
                    </a>
                </li>

                <li class="nav-item mt-3 border-top pt-2">
                    <a href="{{ route('transporter.akun') }}"
                       class="nav-link {{ request()->routeIs('transporter.akun') ? 'active bg-success' : '' }}">
                        <i class="nav-icon fas fa-cog"></i>
                        <p>PENGATURAN AKUN</p>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>
