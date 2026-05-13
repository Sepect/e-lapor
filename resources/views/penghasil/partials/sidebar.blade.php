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
                    <a href="{{ route('penghasil.dashboard') }}"
                       class="nav-link {{ request()->routeIs('penghasil.dashboard') ? 'active bg-success' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>DASHBOARD</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('penghasil.profil') }}"
                       class="nav-link {{ request()->routeIs('penghasil.profil') ? 'active bg-success' : '' }}">
                        <i class="nav-icon fas fa-building"></i>
                        <p>PROFIL PENGHASIL</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('penghasil.kontrak') }}"
                       class="nav-link {{ request()->routeIs('penghasil.kontrak') ? 'active bg-success' : '' }}">
                        <i class="nav-icon fas fa-handshake"></i>
                        <p>KONTRAK KERJASAMA</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('penghasil.limbah') }}"
                       class="nav-link {{ request()->routeIs('penghasil.limbah') ? 'active bg-success' : '' }}">
                        <i class="nav-icon fas fa-balance-scale"></i>
                        <p>JUMLAH LIMBAH YANG<br>AKAN DIOLAH</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('penghasil.beritaAcara') }}"
                       class="nav-link {{ request()->routeIs('penghasil.beritaAcara') ? 'active bg-success' : '' }}">
                        <i class="nav-icon fas fa-file-contract"></i>
                        <p>BA PENERIMAAN<br>LIMBAH B3</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('penghasil.tagihan') }}"
                       class="nav-link {{ request()->routeIs('penghasil.tagihan') ? 'active bg-success' : '' }}">
                        <i class="nav-icon fas fa-file-invoice-dollar"></i>
                        <p>SURAT TAGIHAN &<br>LAPORAN PENGOLAHAN</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('penghasil.pembayaran') }}"
                       class="nav-link {{ request()->routeIs('penghasil.pembayaran') ? 'active bg-success' : '' }}">
                        <i class="nav-icon fas fa-money-bill-wave"></i>
                        <p>SETOR BIAYA<br>PENGOLAHAN</p>
                    </a>
                </li>

                <li class="nav-item mt-3 border-top pt-2">
                    <a href="{{ route('penghasil.akun') }}"
                       class="nav-link {{ request()->routeIs('penghasil.akun') ? 'active bg-success' : '' }}">
                        <i class="nav-icon fas fa-cog"></i>
                        <p>PENGATURAN AKUN</p>
                    </a>
                </li>

            </ul>
        </nav>
    </div>
</aside>
