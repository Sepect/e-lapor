@extends('layouts.app')

@section('title', 'Dashboard')
@section('subtitle', 'E-Lapor PAD')

@section('content')
    <!-- Welcome Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-body p-4 p-md-5 bg-primary bg-gradient text-white position-relative">
                    <div class="position-relative z-1">
                        <h4 class="fw-bold mb-2">Selamat Datang di E-Lapor PAD 👋</h4>
                        <p class="mb-0 opacity-75 fs-6">Pantau dan kelola data pelaporan limbah B3 serta realisasi Pendapatan Asli Daerah dengan mudah dan cepat.</p>
                    </div>
                    <!-- Decorative Icon -->
                    <i class="fas fa-chart-pie position-absolute text-white opacity-25" style="font-size: 8rem; right: 5%; top: 50%; transform: translateY(-50%);"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Section: Limbah B3 -->
    <div class="d-flex align-items-center mb-3">
        <div class="bg-success bg-opacity-10 text-success rounded-circle d-flex justify-content-center align-items-center me-3 shadow-sm" style="width: 45px; height: 45px;">
            <i class="fas fa-dumpster fs-5"></i>
        </div>
        <h5 class="fw-bold mb-0 text-dark">Limbah B3 yang Telah Diterima</h5>
    </div>

    <div class="row g-4 mb-5">
        <div class="col-12 col-md-6 col-xl-4">
            <div class="card border-0 shadow-sm rounded-4 h-100 hover-lift border-bottom border-4 border-info">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <p class="text-muted fw-semibold mb-1">Total Limbah Diterima</p>
                            <h3 class="fw-bold text-dark mb-0">1.250 <span class="fs-6 text-muted fw-normal">Ton</span></h3>
                        </div>
                        <div class="bg-info bg-opacity-10 text-info rounded-3 p-3">
                            <i class="fas fa-truck-loading fs-4"></i>
                        </div>
                    </div>
                    <a href="#" class="text-decoration-none text-info fw-semibold small d-inline-flex align-items-center">
                        Lihat Detail <i class="fas fa-arrow-right ms-2 fs-7"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-6 col-xl-4">
            <div class="card border-0 shadow-sm rounded-4 h-100 hover-lift border-bottom border-4 border-success">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <p class="text-muted fw-semibold mb-1">Telah Diolah UPT</p>
                            <h3 class="fw-bold text-dark mb-0">980 <span class="fs-6 text-muted fw-normal">Ton</span></h3>
                        </div>
                        <div class="bg-success bg-opacity-10 text-success rounded-3 p-3">
                            <i class="fas fa-recycle fs-4"></i>
                        </div>
                    </div>
                    <a href="#" class="text-decoration-none text-success fw-semibold small d-inline-flex align-items-center">
                        Lihat Detail <i class="fas fa-arrow-right ms-2 fs-7"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-6 col-xl-4">
            <div class="card border-0 shadow-sm rounded-4 h-100 hover-lift border-bottom border-4 border-warning">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <p class="text-muted fw-semibold mb-1">Belum Diolah UPT</p>
                            <h3 class="fw-bold text-dark mb-0">270 <span class="fs-6 text-muted fw-normal">Ton</span></h3>
                        </div>
                        <div class="bg-warning bg-opacity-10 text-warning rounded-3 p-3">
                            <i class="fas fa-hourglass-half fs-4"></i>
                        </div>
                    </div>
                    <a href="#" class="text-decoration-none text-warning fw-semibold small d-inline-flex align-items-center">
                        Lihat Detail <i class="fas fa-arrow-right ms-2 fs-7"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Section: PAD -->
    <div class="d-flex align-items-center mb-3">
        <div class="bg-warning bg-opacity-10 text-warning rounded-circle d-flex justify-content-center align-items-center me-3 shadow-sm" style="width: 45px; height: 45px;">
            <i class="fas fa-coins fs-5"></i>
        </div>
        <h5 class="fw-bold mb-0 text-dark">Pendapatan Asli Daerah (PAD)</h5>
    </div>

    <div class="row g-4 mb-5">
        <div class="col-12 col-md-6 col-xl-4">
            <div class="card border-0 shadow-sm rounded-4 h-100 hover-lift bg-primary text-white">
                <div class="card-body p-4 position-relative overflow-hidden">
                    <i class="fas fa-chart-line position-absolute text-white opacity-25" style="font-size: 5rem; right: -10px; bottom: -10px;"></i>
                    <p class="fw-semibold mb-1 opacity-75">Jumlah Potensi PAD</p>
                    <h3 class="fw-bold mb-0">Rp 5.000 <span class="fs-6 fw-normal">M</span></h3>
                    <div class="mt-4">
                        <a href="#" class="text-decoration-none text-white fw-semibold small d-inline-flex align-items-center">
                            Lihat Detail <i class="fas fa-arrow-right ms-2 fs-7"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-6 col-xl-4">
            <div class="card border-0 shadow-sm rounded-4 h-100 hover-lift bg-success text-white">
                <div class="card-body p-4 position-relative overflow-hidden">
                    <i class="fas fa-money-bill-wave position-absolute text-white opacity-25" style="font-size: 5rem; right: -10px; bottom: -10px;"></i>
                    <p class="fw-semibold mb-1 opacity-75">Jumlah Realisasi PAD</p>
                    <h3 class="fw-bold mb-0">Rp 3.200 <span class="fs-6 fw-normal">M</span></h3>
                    <div class="mt-4">
                        <a href="#" class="text-decoration-none text-white fw-semibold small d-inline-flex align-items-center">
                            Lihat Detail <i class="fas fa-arrow-right ms-2 fs-7"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-6 col-xl-4">
            <div class="card border-0 shadow-sm rounded-4 h-100 hover-lift bg-danger text-white">
                <div class="card-body p-4 position-relative overflow-hidden">
                    <i class="fas fa-file-invoice-dollar position-absolute text-white opacity-25" style="font-size: 5rem; right: -10px; bottom: -10px;"></i>
                    <p class="fw-semibold mb-1 opacity-75">Jumlah Piutang Tahun Lalu</p>
                    <h3 class="fw-bold mb-0">Rp 1.800 <span class="fs-6 fw-normal">M</span></h3>
                    <div class="mt-4">
                        <a href="#" class="text-decoration-none text-white fw-semibold small d-inline-flex align-items-center">
                            Lihat Detail <i class="fas fa-arrow-right ms-2 fs-7"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Section: Table -->
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
        <div class="card-header bg-white border-bottom p-4 d-flex align-items-center justify-content-between">
            <h6 class="mb-0 fw-bold d-flex align-items-center text-dark">
                <i class="fas fa-table me-2 text-primary fs-5"></i>
                Rekapitulasi Jumlah Limbah B3 Berdasarkan Jumlah PAD
            </h6>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0 align-middle text-center">
                    <thead class="table-light text-muted">
                        <tr>
                            <th class="py-3 fw-semibold">Total Limbah B3 (Ton)</th>
                            <th class="py-3 fw-semibold">Telah Setor Retribusi PAD</th>
                            <th class="py-3 fw-semibold">Belum Setor Retribusi PAD</th>
                        </tr>
                    </thead>
                    <tbody class="border-top-0">
                        <tr>
                            <td class="py-3 fw-semibold text-dark">1.250 Ton</td>
                            <td class="py-3 text-success fw-bold bg-success bg-opacity-10 rounded-start-3">900 Ton</td>
                            <td class="py-3 text-danger fw-bold bg-danger bg-opacity-10 rounded-end-3">350 Ton</td>
                        </tr>
                        <tr>
                            <td class="py-3 fw-semibold text-dark">500 Ton</td>
                            <td class="py-3 text-success fw-bold bg-success bg-opacity-10 rounded-start-3">200 Ton</td>
                            <td class="py-3 text-danger fw-bold bg-danger bg-opacity-10 rounded-end-3">300 Ton</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
