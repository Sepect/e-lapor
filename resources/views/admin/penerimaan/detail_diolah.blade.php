@extends('layouts.app')

@section('title', 'Detail Limbah Diolah')
@section('subtitle', 'Detail Limbah Diolah')

@section('content')
    @php
        $info      = $limbah->penghasil->informasiPenghasil ?? null;
        $transInfo = $limbah->transporter->informasiTransporter ?? null;
    @endphp

    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-2 mb-4">
        <h4 class="fw-bold mb-0 text-dark d-flex align-items-center">
            <div class="bg-warning bg-opacity-10 text-warning-emphasis p-2 rounded-circle me-3 d-inline-flex justify-content-center align-items-center" style="width: 45px; height: 45px;">
                <i class="fas fa-cog"></i>
            </div>
            Proses Limbah Diolah
        </h4>
        <a href="{{ route('admin.penerimaan.index', 'diolah') }}" class="btn btn-light fw-semibold rounded-pill px-4 shadow-sm border">
            <i class="fas fa-arrow-left me-2"></i> Kembali
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-4 shadow-sm mb-4" role="alert">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <form action="{{ route('admin.penerimaan.selesai', $limbah->id_limbah) }}" method="POST" id="formDiolah">
        @csrf

        {{-- Detail Data --}}
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
            <div class="card-header bg-white border-bottom p-4">
                <h6 class="mb-0 fw-bold d-flex align-items-center text-dark">
                    <i class="fas fa-info-circle me-2 text-primary fs-5"></i> Detail Data Limbah
                </h6>
            </div>
            <div class="card-body p-4">
                <div class="row g-5">
                    <div class="col-12 col-lg-6">
                        <div class="mb-3 row g-2 align-items-center">
                            <label class="col-sm-4 col-form-label text-muted fw-medium small">NOMOR MANIFEST</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control bg-light border-0 fw-semibold font-monospace text-primary"
                                    value="{{ $limbah->no_manifest ?? '-' }}" readonly>
                            </div>
                        </div>
                        <div class="mb-3 row g-2 align-items-center">
                            <label class="col-sm-4 col-form-label text-muted fw-medium small">NAMA PENGIRIM</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control bg-light border-0 fw-semibold text-dark"
                                    value="{{ $info->nama_penghasil ?? $limbah->penghasil->nama_user ?? '-' }}" readonly>
                            </div>
                        </div>
                        <div class="mb-3 row g-2 align-items-center">
                            <label class="col-sm-4 col-form-label text-muted fw-medium small">NAMA TRANSPORTER</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control bg-light border-0 fw-semibold text-dark"
                                    value="{{ $transInfo->nama_transporter ?? $limbah->transporter->nama_user ?? '-' }}" readonly>
                            </div>
                        </div>
                        <div class="mb-3 row g-2 align-items-center">
                            <label class="col-sm-4 col-form-label text-muted fw-medium small">TANGGAL ANGKUT</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control bg-light border-0 fw-semibold text-dark"
                                    value="{{ $limbah->tgl_rencana?->format('d M Y') ?? '-' }}" readonly>
                            </div>
                        </div>
                        <div class="mb-3 row g-2 align-items-center">
                            <label class="col-sm-4 col-form-label text-muted fw-medium small">TANGGAL DITERIMA</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control bg-light border-0 fw-semibold text-dark"
                                    value="{{ $limbah->tgl_diterima?->format('d M Y') ?? '-' }}" readonly>
                            </div>
                        </div>
                        <div class="mb-3 row g-2 align-items-center">
                            <label class="col-sm-4 col-form-label text-muted fw-medium small">BERAT LIMBAH B3</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control bg-light border-0 fw-semibold text-dark"
                                    value="{{ $limbah->jumlah_limbah }} {{ $limbah->satuan }}" readonly>
                            </div>
                        </div>
                        <div class="row g-2 align-items-center">
                            <label class="col-sm-4 col-form-label text-muted fw-medium small">KODE LIMBAH</label>
                            <div class="col-sm-8">
                                <div class="d-inline-block bg-secondary bg-opacity-10 border border-secondary text-secondary fw-bold px-3 py-1 rounded font-monospace">
                                    {{ $limbah->kode_limbah }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-lg-6">
                        <div class="p-3 bg-light rounded-4 border">
                            <div class="mb-3 row g-2 align-items-center">
                                <label class="col-sm-4 col-form-label text-muted fw-medium small">TANGGAL DIOLAH</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control bg-white border-0 fw-semibold text-dark shadow-sm"
                                        value="{{ $limbah->tgl_terolah?->format('d M Y') ?? now()->format('d M Y') }}" readonly>
                                </div>
                            </div>
                            <div class="mb-3 row g-2 align-items-center">
                                <label for="shift_operator" class="col-sm-4 col-form-label fw-bold text-primary small">
                                    SHIFT OPERATOR <span class="text-danger">*</span>
                                </label>
                                <div class="col-sm-8">
                                    <select id="shift_operator" class="form-select border-primary shadow-sm" name="shift_operator">
                                        <option value="Pagi">Pagi</option>
                                        <option value="Sore">Sore</option>
                                        <option value="Malam">Malam</option>
                                    </select>
                                </div>
                            </div>
                            <div class="mb-3 row g-2 align-items-center">
                                <label for="pj_shift" class="col-sm-4 col-form-label fw-bold text-primary small">
                                    PJ SHIFT <span class="text-danger">*</span>
                                </label>
                                <div class="col-sm-8">
                                    <input type="text" id="pj_shift" class="form-control border-primary shadow-sm"
                                        name="pj_shift" placeholder="Nama penanggung jawab">
                                </div>
                            </div>
                            <div class="mb-3 row g-2 align-items-center">
                                <label for="total_diolah" class="col-sm-4 col-form-label fw-bold text-primary small">
                                    TOTAL DIOLAH <span class="text-danger">*</span>
                                </label>
                                <div class="col-sm-8">
                                    <div class="input-group shadow-sm">
                                        <input type="number" id="total_diolah" class="form-control border-primary"
                                            name="total_diolah" value="{{ $limbah->jumlah_limbah }}" placeholder="0">
                                        <span class="input-group-text bg-primary text-white border-primary fw-bold">{{ $limbah->satuan }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3 row g-2 align-items-center">
                                <label for="total_kemasan_diolah" class="col-sm-4 col-form-label fw-bold text-primary small">
                                    TOTAL KEMASAN <span class="text-danger">*</span>
                                </label>
                                <div class="col-sm-8">
                                    <div class="input-group shadow-sm">
                                        <input type="number" id="total_kemasan_diolah" class="form-control border-primary"
                                            name="total_kemasan_diolah" placeholder="0">
                                        <span class="input-group-text bg-primary text-white border-primary fw-bold">Pcs</span>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3 row g-2 align-items-center">
                                <label for="total_bottom_ash" class="col-sm-4 col-form-label fw-bold text-primary small">
                                    BOTTOM ASH <span class="text-danger">*</span>
                                </label>
                                <div class="col-sm-8">
                                    <div class="input-group shadow-sm">
                                        <input type="number" id="total_bottom_ash" class="form-control border-primary"
                                            name="total_bottom_ash" placeholder="0">
                                        <span class="input-group-text bg-primary text-white border-primary fw-bold">Kg</span>
                                    </div>
                                </div>
                            </div>
                            <div class="row g-2 align-items-center">
                                <label for="tgl_bottom_ash" class="col-sm-4 col-form-label fw-bold text-primary small">
                                    TGL KELUAR ASH
                                </label>
                                <div class="col-sm-8">
                                    <input type="date" id="tgl_bottom_ash" class="form-control border-primary shadow-sm"
                                        name="tgl_bottom_ash">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Cetak Laporan --}}
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-5">
            <div class="card-header bg-white border-bottom p-4">
                <h6 class="mb-0 fw-bold text-uppercase text-dark">
                    <i class="fas fa-print me-2 text-secondary fs-5"></i> Cetak Laporan Harian Penerimaan Limbah
                </h6>
            </div>
            <div class="card-body p-4 p-md-5">
                <div class="row justify-content-center">
                    <div class="col-12 col-lg-8">
                        <div class="mb-4 row g-2 align-items-center">
                            <label for="tgl_cetak" class="col-sm-4 col-form-label text-muted fw-semibold small">TANGGAL CETAK</label>
                            <div class="col-sm-8">
                                <input type="date" id="tgl_cetak" class="form-control px-3 py-2 shadow-sm"
                                    name="tgl_cetak" value="{{ now()->format('Y-m-d') }}">
                            </div>
                        </div>
                        <div class="mb-4 row g-2 align-items-center">
                            <label for="tgl_terima_filter" class="col-sm-4 col-form-label text-muted fw-semibold small">TGL LIMBAH DITERIMA</label>
                            <div class="col-sm-8">
                                <input type="date" id="tgl_terima_filter" class="form-control px-3 py-2 shadow-sm"
                                    name="tgl_terima_filter" value="{{ $limbah->tgl_diterima?->format('Y-m-d') }}">
                            </div>
                        </div>
                        <div class="row g-2 align-items-center bg-light p-3 rounded-3 border">
                            <label class="col-sm-4 col-form-label text-muted fw-semibold small">FORMAT CETAK</label>
                            <div class="col-sm-8">
                                <div class="d-flex flex-wrap gap-4">
                                    <div class="form-check form-switch fs-5">
                                        <input class="form-check-input shadow-none" type="checkbox" id="pdfCheck" name="cetak_pdf" checked>
                                        <label class="form-check-label fw-bold text-dark fs-6 mt-1 ms-2" for="pdfCheck">
                                            <i class="fas fa-file-pdf text-danger me-1"></i> PDF
                                        </label>
                                    </div>
                                    <div class="form-check form-switch fs-5">
                                        <input class="form-check-input shadow-none" type="checkbox" id="excelCheck" name="cetak_excel">
                                        <label class="form-check-label fw-bold text-dark fs-6 mt-1 ms-2" for="excelCheck">
                                            <i class="fas fa-file-excel text-success me-1"></i> Excel
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-light border-top p-4 d-flex justify-content-end gap-3">
                <a href="{{ route('admin.penerimaan.index', 'diolah') }}" class="btn btn-light border fw-semibold rounded-pill px-4 shadow-sm">
                    Batal
                </a>
                <button type="submit" form="formDiolah" class="btn btn-warning fw-bold rounded-pill px-5 shadow-sm text-dark">
                    <i class="fas fa-paper-plane me-2"></i> Simpan & Selesai
                </button>
            </div>
        </div>

    </form>

    <style>
        .form-switch .form-check-input { width: 3em; cursor: pointer; }
        .form-switch .form-check-input:checked { background-color: #198754; border-color: #198754; }
    </style>
@endsection
