@extends('layouts.app')

@section('title', 'Dashboard Penghasil')

@section('content')
    <style>
        /* Efek interaktif saat mouse diarahkan ke kotak statistik */
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
            <div
                class="card-body p-4 d-flex flex-column flex-md-row align-items-center border-start border-5 border-primary">

                <div
                    class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex justify-content-center align-items-center me-3"
                    style="width: 50px; height: 50px;">
                    <i class="fas fa-home fs-4"></i>
                </div>

                <div class="me-auto mt-3 mt-md-0 text-center text-md-start">
                    <h4 class="fw-bold mb-0 text-dark">Dashboard</h4>
                    <p class="text-muted mb-0 small">Ringkasan aktivitas dan data limbah B3 Anda</p>
                </div>

            </div>
        </div>

        <div class="card border-0 shadow-sm rounded-4 mb-4 bg-white">
            <div
                class="card-body p-4 d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                <div>
                    <h5 class="fw-bold mb-1 text-dark">Selamat Datang, <span
                            class="text-primary">{{strtoupper(auth()->user()->nama_user)}}</span> 👋</h5>
                    <p class="text-muted mb-0 small">Pantau status pengiriman, kuota, dan sisa limbah Anda di sini.</p>
                </div>
            </div>
        </div>

        <div class="row g-4 mb-4 text-center">
            <div class="col-lg-4 col-md-6">
                <div class="card shadow-sm border-0 rounded-4 h-100 bg-white hover-lift">
                    <div class="card-body p-4 p-lg-5">
                        <div
                            class="bg-primary bg-opacity-10 text-primary rounded-circle d-inline-flex justify-content-center align-items-center mb-3"
                            style="width: 65px; height: 65px;">
                            <i class="fas fa-truck-loading fs-3"></i>
                        </div>
                        <h6 class="text-uppercase text-muted fw-bold mb-2">Diangkut / Dikirim</h6>
                        <h1 class="fw-bold text-primary display-5 mb-3">150</h1>
                        <span class="badge bg-light text-primary px-3 py-2 rounded-pill border">SATUAN TON</span>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6">
                <div class="card shadow-sm border-0 rounded-4 h-100 bg-white hover-lift">
                    <div class="card-body p-4 p-lg-5">
                        <div
                            class="bg-success bg-opacity-10 text-success rounded-circle d-inline-flex justify-content-center align-items-center mb-3"
                            style="width: 65px; height: 65px;">
                            <i class="fas fa-box-open fs-3"></i>
                        </div>
                        <h6 class="text-uppercase text-muted fw-bold mb-2">Telah Diterima UPT</h6>
                        <h1 class="fw-bold text-success display-5 mb-3">120</h1>
                        <span class="badge bg-light text-success px-3 py-2 rounded-pill border">SATUAN TON</span>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6">
                <div class="card shadow-sm border-0 rounded-4 h-100 bg-white hover-lift">
                    <div class="card-body p-4 p-lg-5">
                        <div
                            class="bg-warning bg-opacity-10 text-warning rounded-circle d-inline-flex justify-content-center align-items-center mb-3"
                            style="width: 65px; height: 65px;">
                            <i class="fas fa-recycle fs-3"></i>
                        </div>
                        <h6 class="text-uppercase text-muted fw-bold mb-2">Telah Diolah UPT</h6>
                        <h1 class="fw-bold text-warning display-5 mb-3">90</h1>
                        <span class="badge bg-light text-warning px-3 py-2 rounded-pill border">SATUAN TON</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm rounded-4 bg-white overflow-hidden">
            <div class="card-header bg-white border-bottom p-4 d-flex align-items-center">
                <i class="fas fa-chart-pie text-primary fs-4 me-3"></i>
                <h5 class="mb-0 fw-bold text-dark text-uppercase">Rekapitulasi Jumlah Limbah B3</h5>
            </div>

            <div class="card-body p-0">
                <div class="row g-0 text-center">

                    <div class="col-md-4 border-end-md border-bottom border-bottom-md-0 p-4 p-lg-5">
                        <div class="text-muted mb-2"><i class="fas fa-database fs-5"></i></div>
                        <p class="text-muted fw-bold text-uppercase mb-2">Total Limbah B3</p>
                        <h2 class="fw-bold text-dark mb-0">500.00 <span class="fs-6 text-muted fw-normal">TON</span>
                        </h2>
                    </div>

                    <div
                        class="col-md-4 border-end-md border-bottom border-bottom-md-0 p-4 p-lg-5 bg-success bg-opacity-10">
                        <div class="text-success mb-2"><i class="fas fa-arrow-up fs-5"></i></div>
                        <p class="text-success fw-bold text-uppercase mb-2">Telah Dikeluarkan</p>
                        <h2 class="fw-bold text-success mb-0">360.00 <span class="fs-6 fw-normal">TON</span></h2>
                    </div>

                    <div class="col-md-4 p-4 p-lg-5 bg-danger bg-opacity-10">
                        <div class="text-danger mb-2"><i class="fas fa-exclamation-circle fs-5"></i></div>
                        <p class="text-danger fw-bold text-uppercase mb-2">Sisa Limbah B3</p>
                        <h2 class="fw-bold text-danger mb-0">140.00 <span class="fs-6 fw-normal">TON</span></h2>
                    </div>

                </div>
            </div>
        </div>

    </div>
@endsection
