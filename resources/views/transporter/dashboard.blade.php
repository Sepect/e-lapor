@extends('layouts.app')

@section('title', 'Dashboard Transporter')

@section('content')
    <style>
        .hover-lift {
            transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
        }

        .hover-lift:hover {
            transform: translateY(-5px);
            box-shadow: 0 .5rem 1.5rem rgba(0, 0, 0, .15) !important;
        }
    </style>

    <div class="container-fluid py-4 px-0">

        <div class="card border-0 shadow-sm rounded-4 mb-4 bg-white overflow-hidden">
            <div class="card-body p-4 d-flex flex-column flex-md-row align-items-center border-start border-5 border-primary">
                <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex justify-content-center align-items-center me-3" style="width: 50px; height: 50px;">
                    <i class="fas fa-truck-moving fs-4"></i>
                </div>
                <div class="me-auto mt-3 mt-md-0 text-center text-md-start">
                    <h4 class="fw-bold mb-0 text-dark">Dashboard Transporter</h4>
                    <p class="text-muted mb-0 small">Ringkasan aktivitas pengiriman dan setoran PAD Anda</p>
                </div>
            </div>
        </div>

        <div class="d-flex align-items-center mb-3 mt-5">
            <div class="bg-primary rounded p-1 me-2" style="width: 5px; height: 20px;"></div>
            <h6 class="text-uppercase fw-bold mb-0">Limbah B3 Yang Telah Dikirim</h6>
        </div>

        <div class="row g-4 mb-5 text-center">
            <div class="col-lg-4 col-md-6">
                <div class="card shadow-sm border-0 rounded-4 h-100 bg-white hover-lift">
                    <div class="card-body p-4 p-lg-5">
                        <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-inline-flex justify-content-center align-items-center mb-3" style="width: 65px; height: 65px;">
                            <i class="fas fa-truck-loading fs-3"></i>
                        </div>
                        <h6 class="text-uppercase text-muted fw-bold mb-2">Diangkut / Dikirim</h6>
                        <h1 class="fw-bold text-primary display-5 mb-3">150.5</h1>
                        <span class="badge bg-light text-primary px-3 py-2 rounded-pill border">SATUAN TON</span>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6">
                <div class="card shadow-sm border-0 rounded-4 h-100 bg-white hover-lift">
                    <div class="card-body p-4 p-lg-5">
                        <div class="bg-success bg-opacity-10 text-success rounded-circle d-inline-flex justify-content-center align-items-center mb-3" style="width: 65px; height: 65px;">
                            <i class="fas fa-check-circle fs-3"></i>
                        </div>
                        <h6 class="text-uppercase text-muted fw-bold mb-2">Telah Diterima UPT</h6>
                        <h1 class="fw-bold text-success display-5 mb-3">120.0</h1>
                        <span class="badge bg-light text-success px-3 py-2 rounded-pill border">SATUAN TON</span>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6">
                <div class="card shadow-sm border-0 rounded-4 h-100 bg-white hover-lift">
                    <div class="card-body p-4 p-lg-5">
                        <div class="bg-warning bg-opacity-10 text-warning rounded-circle d-inline-flex justify-content-center align-items-center mb-3" style="width: 65px; height: 65px;">
                            <i class="fas fa-recycle fs-3"></i>
                        </div>
                        <h6 class="text-uppercase text-muted fw-bold mb-2">Telah Diolah UPT</h6>
                        <h1 class="fw-bold text-warning display-5 mb-3">90.0</h1>
                        <span class="badge bg-light text-warning px-3 py-2 rounded-pill border">SATUAN TON</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex align-items-center mb-3 mt-5">
            <div class="bg-info rounded p-1 me-2" style="width: 5px; height: 20px;"></div>
            <h6 class="text-uppercase fw-bold mb-0">Setoran PAD</h6>
        </div>

        <div class="row g-4 mb-5 text-center">
            <div class="col-lg-4 col-md-6">
                <div class="card shadow-sm border-0 rounded-4 h-100 bg-white hover-lift border-bottom border-4 border-info">
                    <div class="card-body p-4 p-lg-5">
                        <div class="bg-info bg-opacity-10 text-info rounded-circle d-inline-flex justify-content-center align-items-center mb-3" style="width: 65px; height: 65px;">
                            <i class="fas fa-balance-scale fs-3"></i>
                        </div>
                        <h6 class="text-uppercase text-muted fw-bold mb-2">Disetor Retribusi</h6>
                        <h2 class="fw-bold text-info mb-3">85.5 <span class="fs-6 fw-normal">TON</span></h2>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6">
                <div class="card shadow-sm border-0 rounded-4 h-100 bg-white hover-lift border-bottom border-4 border-success">
                    <div class="card-body p-4 p-lg-5">
                        <div class="bg-success bg-opacity-10 text-success rounded-circle d-inline-flex justify-content-center align-items-center mb-3" style="width: 65px; height: 65px;">
                            <i class="fas fa-money-bill-wave fs-3"></i>
                        </div>
                        <h6 class="text-uppercase text-muted fw-bold mb-2">Jumlah Setoran</h6>
                        <h2 class="fw-bold text-success mb-3">Rp 25.000.000</h2>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6">
                <div class="card shadow-sm border-0 rounded-4 h-100 bg-white hover-lift border-bottom border-4 border-danger">
                    <div class="card-body p-4 p-lg-5">
                        <div class="bg-danger bg-opacity-10 text-danger rounded-circle d-inline-flex justify-content-center align-items-center mb-3" style="width: 65px; height: 65px;">
                            <i class="fas fa-exclamation-circle fs-3"></i>
                        </div>
                        <h6 class="text-uppercase text-muted fw-bold mb-2">Belum Setor</h6>
                        <h2 class="fw-bold text-danger mb-3">Rp 5.000.000</h2>
                    </div>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm rounded-4 bg-white overflow-hidden mb-5">
            <div class="card-header bg-white border-bottom p-4 d-flex align-items-center">
                <i class="fas fa-chart-pie text-primary fs-4 me-3"></i>
                <h5 class="mb-0 fw-bold text-dark text-uppercase fs-6">Rekapitulasi Limbah B3 Berdasarkan Setoran PAD</h5>
            </div>

            <div class="card-body p-0">
                <div class="row g-0 text-center">
                    <div class="col-md-4 border-end-md border-bottom border-bottom-md-0 p-4 p-lg-5">
                        <div class="text-muted mb-2"><i class="fas fa-database fs-5"></i></div>
                        <p class="text-muted fw-bold text-uppercase mb-2">Total Limbah B3</p>
                        <h2 class="fw-bold text-dark mb-1">500.00 <span class="fs-6 text-muted fw-normal">TON</span></h2>
                        <small class="text-muted">Akumulasi Tahun 2026</small>
                    </div>

                    <div class="col-md-4 border-end-md border-bottom border-bottom-md-0 p-4 p-lg-5 bg-success bg-opacity-10">
                        <div class="text-success mb-2"><i class="fas fa-check-circle fs-5"></i></div>
                        <p class="text-success fw-bold text-uppercase mb-2">Telah Disetorkan PAD</p>
                        <h2 class="fw-bold text-success mb-1">450.00 <span class="fs-6 fw-normal">TON</span></h2>
                        <small class="text-success opacity-75">Sudah Terverifikasi</small>
                    </div>

                    <div class="col-md-4 p-4 p-lg-5 bg-danger bg-opacity-10">
                        <div class="text-danger mb-2"><i class="fas fa-clock fs-5"></i></div>
                        <p class="text-danger fw-bold text-uppercase mb-2">Belum Disetorkan PAD</p>
                        <h2 class="fw-bold text-danger mb-1">50.00 <span class="fs-6 fw-normal">TON</span></h2>
                        <small class="text-danger opacity-75">Menunggu Pembayaran</small>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
