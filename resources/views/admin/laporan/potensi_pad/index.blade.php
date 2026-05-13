@extends('layouts.app')

@section('title', 'Laporan Potensi PAD')
@section('subtitle', 'Laporan Potensi PAD')

@section('content')
    {{-- Page Header --}}
    <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden">
        <div class="card-body p-4 d-flex flex-column flex-md-row align-items-start align-items-md-center gap-3 bg-white position-relative">
            <div class="position-absolute top-0 start-0 w-100 h-100 bg-warning opacity-10" style="pointer-events: none;"></div>
            <div class="position-absolute top-0 start-0 h-100 bg-warning" style="width: 6px;"></div>

            <div class="bg-warning bg-gradient text-dark rounded-circle d-flex justify-content-center align-items-center flex-shrink-0 shadow-sm z-1"
                 style="width: 55px; height: 55px;">
                <i class="fas fa-chart-line fs-4"></i>
            </div>
            <div class="flex-grow-1 z-1">
                <h5 class="fw-bold mb-1 text-dark">Laporan Potensi PAD</h5>
                <p class="text-muted mb-0 small">Cetak laporan potensi Pendapatan Asli Daerah berdasarkan data limbah B3.</p>
            </div>
        </div>
    </div>

    {{-- Card Form --}}
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-header bg-white border-bottom p-4 d-flex align-items-center">
            <div class="bg-warning bg-opacity-10 text-warning-emphasis rounded p-2 me-3">
                <i class="fas fa-print"></i>
            </div>
            <div>
                <h6 class="mb-0 fw-bold text-dark">Cetak Potensi PAD</h6>
                <small class="text-muted">Silahkan pilih filter data laporan di bawah ini</small>
            </div>
        </div>
        <div class="card-body p-4 p-md-5">
            <form action="{{ route('admin.laporan.cetak') }}" method="POST">
                @csrf
                <input type="hidden" name="jenis_laporan" value="potensi_pad">

                <div class="row mb-4">
                    <label class="col-md-3 form-label-custom">TAHUN</label>
                    <div class="col-md-4 col-sm-12">
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="far fa-calendar-alt text-muted"></i></span>
                            <select class="form-select border-start-0 bg-light" name="tahun">
                                <option value="" selected disabled>Pilih Tahun</option>
                                @for($i = date('Y'); $i >= 2020; $i--)
                                    <option value="{{ $i }}" {{ old('tahun') == $i ? 'selected' : '' }}>{{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                        @error('tahun')
                            <small class="text-danger mt-1 d-block">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="row mb-4">
                    <label class="col-md-3 form-label-custom">PERIODE PELAPORAN</label>
                    <div class="col-md-9">
                        <div class="row g-2 align-items-center">
                            <div class="col-6 col-md-4">
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 px-2"><small class="text-muted">Dari</small></span>
                                    <input type="date" class="form-control border-start-0 bg-light" name="tgl_awal" value="{{ old('tgl_awal') }}">
                                </div>
                                @error('tgl_awal')
                                    <small class="text-danger mt-1 d-block">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-12 col-md-auto text-center py-1 py-md-0">
                                <span class="fw-bold text-muted small">S/D</span>
                            </div>
                            <div class="col-6 col-md-4">
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 px-2"><small class="text-muted">Sampai</small></span>
                                    <input type="date" class="form-control border-start-0 bg-light" name="tgl_akhir" value="{{ old('tgl_akhir') }}">
                                </div>
                                @error('tgl_akhir')
                                    <small class="text-danger mt-1 d-block">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mb-5">
                    <label class="col-md-3 form-label-custom">TANGGAL CETAK</label>
                    <div class="col-md-4 col-12">
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="fas fa-calendar-check text-muted"></i></span>
                            <input type="date" class="form-control border-start-0 bg-light" name="tgl_cetak" value="{{ old('tgl_cetak', date('Y-m-d')) }}">
                        </div>
                        @error('tgl_cetak')
                            <small class="text-danger mt-1 d-block">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="row mt-5">
                    <div class="col-md-3 d-none d-md-block"></div>
                    <div class="col-md-9 col-12">
                        <div class="d-flex flex-column flex-md-row gap-3">
                            <button type="submit" name="jenis_cetak" value="pdf" class="btn btn-danger fw-semibold rounded-pill px-4 shadow-sm d-inline-flex align-items-center justify-content-center">
                                <i class="fas fa-file-pdf me-2"></i> DOWNLOAD PDF
                            </button>
                            <button type="submit" name="jenis_cetak" value="excel" class="btn btn-success fw-semibold rounded-pill px-4 shadow-sm d-inline-flex align-items-center justify-content-center">
                                <i class="fas fa-file-excel me-2"></i> DOWNLOAD EXCEL
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
