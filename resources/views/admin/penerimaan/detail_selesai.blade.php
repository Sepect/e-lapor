@extends('layouts.app')

@section('title', 'Detail Selesai Diolah')
@section('subtitle', 'Detail Selesai Diolah')

@section('content')
    @php
        $info      = $limbah->penghasil->informasiPenghasil ?? null;
        $transInfo = $limbah->transporter->informasiTransporter ?? null;
        $ba        = $limbah->beritaAcara;
        $kontrak   = $limbah->kontrak;
    @endphp

    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-2 mb-4">
        <h4 class="fw-bold mb-0 text-dark d-flex align-items-center">
            <div class="bg-secondary bg-opacity-10 text-secondary p-2 rounded-circle me-3 d-inline-flex justify-content-center align-items-center" style="width: 45px; height: 45px;">
                <i class="fas fa-flag-checkered"></i>
            </div>
            Limbah Selesai Diolah
        </h4>
        <div class="d-flex gap-2">
            <button class="btn btn-outline-secondary fw-semibold rounded-pill px-4 shadow-sm" onclick="window.print()">
                <i class="fas fa-print me-2"></i> Cetak
            </button>
            <a href="{{ route('admin.penerimaan.index', 'selesai') }}" class="btn btn-light fw-semibold rounded-pill px-4 shadow-sm border">
                <i class="fas fa-arrow-left me-2"></i> Kembali
            </a>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-5">
        <div class="card-header bg-white border-bottom p-4 d-flex flex-column flex-sm-row align-items-start align-items-sm-center justify-content-between gap-3">
            <h6 class="mb-0 fw-bold d-flex align-items-center text-dark text-uppercase">
                <i class="fas fa-info-circle me-2 text-primary fs-5"></i> Detail Data Keseluruhan
            </h6>
            <span class="badge bg-secondary py-2 px-4 rounded-pill shadow-sm">
                <i class="fas fa-flag-checkered me-1"></i> Telah Setor PAD
            </span>
        </div>
        <div class="card-body p-4">
            <div class="row g-5">
                {{-- Kolom Kiri: Data Manifest & Pengiriman --}}
                <div class="col-12 col-xl-6">
                    <h6 class="fw-bold text-primary text-uppercase border-bottom border-primary border-opacity-25 pb-3 mb-4 small d-flex align-items-center">
                        <i class="fas fa-file-alt me-2"></i> Data Manifest & Pengiriman
                    </h6>

                    <div class="mb-3 row g-2 align-items-center">
                        <label class="col-sm-4 col-form-label text-muted fw-semibold small">NO. MANIFEST</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control bg-light border-0 fw-bold text-primary font-monospace"
                                value="{{ $limbah->no_manifest ?? '-' }}" readonly>
                        </div>
                    </div>
                    <div class="mb-3 row g-2 align-items-center">
                        <label class="col-sm-4 col-form-label text-muted fw-semibold small">NAMA PENGIRIM</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control bg-light border-0 fw-medium text-dark"
                                value="{{ $info->nama_penghasil ?? $limbah->penghasil->nama_user ?? '-' }}" readonly>
                        </div>
                    </div>
                    <div class="mb-3 row g-2 align-items-center">
                        <label class="col-sm-4 col-form-label text-muted fw-semibold small">ALAMAT PENGIRIM</label>
                        <div class="col-sm-8">
                            <textarea class="form-control bg-light border-0 fw-medium text-dark" rows="2" readonly>{{ $info->alamat_penghasil ?? '-' }}</textarea>
                        </div>
                    </div>
                    <div class="mb-3 row g-2 align-items-center">
                        <label class="col-sm-4 col-form-label text-muted fw-semibold small">NAMA TRANSPORTER</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control bg-light border-0 fw-medium text-dark"
                                value="{{ $transInfo->nama_transporter ?? $limbah->transporter->nama_user ?? '-' }}" readonly>
                        </div>
                    </div>
                    <div class="mb-3 row g-2 align-items-center">
                        <label class="col-sm-4 col-form-label text-muted fw-semibold small">ALAMAT TRANSPORTER</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control bg-light border-0 fw-medium text-dark"
                                value="{{ $transInfo->alamat_transporter ?? '-' }}" readonly>
                        </div>
                    </div>
                    <div class="mb-3 row g-2 align-items-center">
                        <label class="col-sm-4 col-form-label text-muted fw-semibold small">TGL ANGKUT</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control bg-light border-0 fw-medium text-dark"
                                value="{{ $limbah->tgl_rencana?->format('d M Y') ?? '-' }}" readonly>
                        </div>
                    </div>
                    <div class="mb-3 row g-2 align-items-center">
                        <label class="col-sm-4 col-form-label text-muted fw-semibold small">TGL DITERIMA</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control bg-light border-0 fw-medium text-dark"
                                value="{{ $limbah->tgl_diterima?->format('d M Y') ?? '-' }}" readonly>
                        </div>
                    </div>
                    <div class="mb-3 row g-2 align-items-center">
                        <label class="col-sm-4 col-form-label text-muted fw-semibold small">TGL DIOLAH</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control bg-light border-0 fw-medium text-dark"
                                value="{{ $limbah->tgl_terolah?->format('d M Y') ?? '-' }}" readonly>
                        </div>
                    </div>
                    <div class="mb-3 row g-2 align-items-center">
                        <label class="col-sm-4 col-form-label text-muted fw-semibold small">BERAT LIMBAH</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control bg-light border-0 fw-medium text-dark"
                                value="{{ $limbah->jumlah_limbah }} {{ $limbah->satuan }}" readonly>
                        </div>
                    </div>
                    <div class="mb-3 row g-2 align-items-center">
                        <label class="col-sm-4 col-form-label text-muted fw-semibold small">NAMA DRIVER</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control bg-light border-0 fw-medium text-dark"
                                value="{{ $limbah->nama_driver ?? '-' }}" readonly>
                        </div>
                    </div>
                    <div class="mb-3 row g-2 align-items-center">
                        <label class="col-sm-4 col-form-label text-muted fw-semibold small">PLAT KENDARAAN</label>
                        <div class="col-sm-8">
                            <div class="d-inline-block bg-dark text-white fw-bold px-3 py-1 rounded font-monospace">
                                {{ $limbah->no_kendaraan ?? '-' }}
                            </div>
                        </div>
                    </div>
                    <div class="row g-2 align-items-center">
                        <label class="col-sm-4 col-form-label text-muted fw-semibold small">KODE LIMBAH</label>
                        <div class="col-sm-8">
                            <div class="d-inline-block bg-secondary bg-opacity-10 border border-secondary text-secondary fw-bold px-3 py-1 rounded font-monospace">
                                {{ $limbah->kode_limbah }}
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Kolom Kanan: Data Kontrak & BA --}}
                <div class="col-12 col-xl-6">
                    <h6 class="fw-bold text-success text-uppercase border-bottom border-success border-opacity-25 pb-3 mb-4 small d-flex align-items-center">
                        <i class="fas fa-receipt me-2"></i> Data Kontrak & Berita Acara
                    </h6>

                    <div class="mb-3 row g-2 align-items-center">
                        <label class="col-sm-4 col-form-label text-muted fw-semibold small">NOMOR MOU</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control bg-light border-0 fw-medium text-dark"
                                value="{{ $kontrak->nomor_kontrak ?? '-' }}" readonly>
                        </div>
                    </div>
                    <div class="mb-3 row g-2 align-items-center">
                        <label class="col-sm-4 col-form-label text-muted fw-semibold small">TGL MOU</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control bg-light border-0 fw-medium text-dark"
                                value="{{ $kontrak?->tgl_terbit?->format('d M Y') ?? '-' }}" readonly>
                        </div>
                    </div>
                    <div class="mb-3 row g-2 align-items-center">
                        <label class="col-sm-4 col-form-label text-muted fw-semibold small">TGL BERITA ACARA</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control bg-light border-0 fw-medium text-dark"
                                value="{{ $ba?->tgl_penyerahan?->format('d M Y') ?? '-' }}" readonly>
                        </div>
                    </div>
                    <div class="mb-3 row g-2 align-items-center">
                        <label class="col-sm-4 col-form-label text-muted fw-semibold small">NAMA PENERIMA BA</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control bg-light border-0 fw-medium text-dark"
                                value="{{ $ba?->nama_penerima ?? '-' }}" readonly>
                        </div>
                    </div>
                    <div class="mb-3 row g-2 align-items-center">
                        <label class="col-sm-4 col-form-label text-muted fw-semibold small">JABATAN PENERIMA</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control bg-light border-0 fw-medium text-dark"
                                value="{{ $ba?->jabatan_penerima ?? '-' }}" readonly>
                        </div>
                    </div>

                    @if($ba?->tandatangan_penerima || $ba?->stempel_penerima)
                        <div class="mb-4 row g-2">
                            @if($ba->tandatangan_penerima)
                                <div class="col-6">
                                    <label class="text-muted fw-semibold small d-block mb-1">TTD PENERIMA</label>
                                    <div class="border rounded p-2 bg-light d-inline-block">
                                        <img src="{{ asset('storage/'.$ba->tandatangan_penerima) }}" alt="TTD"
                                            style="max-height: 70px; max-width: 160px; object-fit: contain;">
                                    </div>
                                </div>
                            @endif
                            @if($ba->stempel_penerima)
                                <div class="col-6">
                                    <label class="text-muted fw-semibold small d-block mb-1">STEMPEL</label>
                                    <div class="border rounded p-2 bg-light d-inline-block">
                                        <img src="{{ asset('storage/'.$ba->stempel_penerima) }}" alt="Stempel"
                                            style="max-height: 70px; max-width: 160px; object-fit: contain;">
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endif

                    <div class="position-relative my-4">
                        <hr class="border-secondary opacity-25">
                        <span class="position-absolute top-50 start-50 translate-middle bg-white px-3 text-muted small fw-semibold text-uppercase">
                            Status Pembayaran
                        </span>
                    </div>

                    <div class="p-3 rounded-4 bg-dark bg-opacity-10 border border-dark-subtle text-center">
                        <div class="fw-bold text-dark mb-1 small text-uppercase">Status</div>
                        <span class="badge bg-dark px-4 py-2 rounded-pill fs-6">
                            <i class="fas fa-flag-checkered me-1"></i> Telah Setor PAD
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer bg-light border-top p-4 d-flex justify-content-center">
            <button class="btn btn-outline-secondary rounded-pill px-4 shadow-sm" onclick="window.print()">
                <i class="fas fa-print me-2"></i> Cetak Rekapitulasi Data
            </button>
        </div>
    </div>

    <style>
        @media print {
            .btn, .card-footer, a, nav { display: none !important; }
            .card { box-shadow: none !important; border: 1px solid #dee2e6 !important; }
            body { background: white; }
        }
    </style>
@endsection
