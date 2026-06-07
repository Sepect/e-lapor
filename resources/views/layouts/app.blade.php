<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SIPENGOLAH Limbah B3 | @yield('title')</title>

    @vite(['resources/css/app.scss', 'resources/js/app.js'])

    <style>
        .sidebar-menu .nav-link p {
            white-space: normal;
            display: inline-block;
            line-height: 1.2;
            font-size: 0.9rem;
            vertical-align: middle;
            margin-left: 5px;
        }

        .small-box .icon {
            position: absolute;
            top: 10px;
            right: 15px;
            z-index: 0;
            opacity: 0.4;
        }

        .small-box .icon i {
            font-size: 4.5rem;
            transition: transform 0.3s;
        }

        .small-box:hover .icon i {
            transform: scale(1.1);
        }

        .small-box .inner {
            position: relative;
            z-index: 1;
            padding-right: 80px;
        }

        /* ===== TAB ANIMATION ===== */
        .tab-pane {
            display: none;
        }

        .tab-pane.active {
            display: block;
        }

        .tab-pane.fade {
            opacity: 0;
            transition: opacity 0.2s ease-in-out;
        }

        .tab-pane.fade.show {
            opacity: 1;
        }

        /* ===== NAV PILLS TRANSITION ===== */
        .nav-pills .nav-link {
            transition: background-color 0.2s ease, color 0.2s ease, box-shadow 0.2s ease;
        }

        /* Sidebar tetap di tempat saat konten di-scroll */
        .sidebar-expand-lg.layout-fixed .app-sidebar {
            position: sticky;
            top: 0;
            height: 100vh;
            overflow: hidden;
        }

        .sidebar-expand-lg.layout-fixed .app-sidebar .sidebar-wrapper {
            height: calc(100vh - 3.5rem - 1px);
            overflow-x: hidden;
            overflow-y: auto;
        }

        /* Header tetap di atas */
        .app-header {
            position: sticky;
            top: 0;
            z-index: 1050;
        }

        /* ===== STICKY TABLE COLUMNS ===== */
        .sticky-col {
            position: sticky;
            background-color: #fff;
            z-index: 2;
        }

        .first-col {
            left: 0;
            border-right: 2px solid #dee2e6 !important;
        }

        .last-col {
            right: 0;
            border-left: 2px solid #dee2e6 !important;
        }

        .table-hover tbody tr:hover td.sticky-col {
            background-color: #f8f9fa;
        }

        /* ===== HOVER LIFT (for filter cards) ===== */
        .hover-lift {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .hover-lift:hover {
            transform: translateY(-3px);
            box-shadow: 0 .5rem 1rem rgba(0, 0, 0, .1) !important;
        }

        /* ===== LAPORAN SHARED STYLES ===== */
        .report-header {
            border-left: 5px solid #0d6efd;
            background-color: #f8f9fa;
            padding: 15px 20px;
            border-radius: 4px;
            margin-bottom: 2rem;
            display: flex;
            align-items: center;
        }

        .report-header i {
            font-size: 1.8rem;
            color: #343a40;
            margin-right: 15px;
        }

        .report-header span {
            font-weight: 700;
            text-transform: uppercase;
            font-size: 1.1rem;
            color: #343a40;
            letter-spacing: 0.5px;
        }

        .form-label-custom {
            font-weight: 600;
            font-size: 0.85rem;
            text-transform: uppercase;
            color: #555;
            margin-top: 8px;
        }

        .btn-print-custom {
            border: 2px solid #343a40;
            background: #fff;
            color: #343a40;
            font-weight: 700;
            padding: 10px 30px;
            border-radius: 6px;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .btn-print-custom:hover {
            background: #343a40;
            color: #fff;
            transform: translateY(-2px);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .btn-print-custom i {
            margin-right: 10px;
        }
    </style>
    @stack('styles')
</head>

<body class="layout-fixed fixed-header sidebar-expand-lg bg-body-tertiary">
    <div class="app-wrapper">

        @include('partials.navbar')

        @if(Auth::check() && Auth::user()->role === 'penghasil')
            @include('penghasil.partials.sidebar')
        @elseif(Auth::check() && Auth::user()->role === 'transporter')
            @include('transporter.partials.sidebar')
        @else
            @include('partials.sidebar')
        @endif

        <main class="app-main">
            <div class="app-content-header">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-6">
                            <h3 class="mb-0">@yield('subtitle', 'Dashboard')</h3>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-end">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">@yield('title')</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <div class="app-content">
                <div class="container-fluid">
                    @yield('content')
                </div>
            </div>
        </main>

        @include('partials.footer')

    </div>
    <script type="module">
        window.konfirmasiLogout = function (event) {
            event.preventDefault();

            Swal.fire({
                title: 'Konfirmasi Logout',
                text: "Apakah Anda yakin ingin keluar?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Logout!'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('logout-form').submit();
                }
            });
        }
    </script>
    @if ($errors->any())
        <script type="module">
            let errorMessages = '';
            /* Looping semua pesan error dari Laravel */
            @foreach ($errors->all() as $error)
                errorMessages += '<li class="mb-1">{{ $error }}</li>';
            @endforeach

            Swal.fire({
                icon: 'error',
                title: 'Validasi Gagal!',
                html: '<ul class="text-start mb-0 text-danger fw-medium">' + errorMessages + '</ul>',
                confirmButtonText: 'Mengerti',
                customClass: {
                    /* Menggunakan class Bootstrap & sudut kotak (rounded-0) agar senada dengan desain Anda */
                    confirmButton: 'btn btn-dark rounded-0 px-4 fw-bold'
                },
                buttonsStyling: false
            });
        </script>
    @endif

    @if (session('success'))
        <script type="module">
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                confirmButtonText: 'TUTUP',
                customClass: {
                    confirmButton: 'btn btn-success rounded-0 px-4 fw-bold text-white'
                },
                buttonsStyling: false
            });
        </script>
    @endif

    @if (session('error'))
        <script type="module">
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: '{{ session('error') }}',
                confirmButtonText: 'KEMBALI',
                customClass: {
                    confirmButton: 'btn btn-dark rounded-0 px-4 fw-bold'
                },
                buttonsStyling: false
            });
        </script>
    @endif
    @stack('scripts')
</body>

</html>