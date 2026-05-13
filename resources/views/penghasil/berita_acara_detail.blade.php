@extends('layouts.app')

@section('title', 'Detail Berita Acara')

@section('content')
    @php
        $ba        = $limbah->beritaAcara;
        $transInfo = $limbah->transporter->informasiTransporter ?? null;
        $info      = $limbah->penghasil->informasiPenghasil ?? null;
        $kontrak   = $limbah->kontrak;

        $badgeClass = match($limbah->status) {
            'Terangkut'       => 'bg-info text-dark',
            'Diterima'        => 'bg-primary',
            'Terolah'         => 'bg-warning text-dark',
            'Telah Setor PAD' => 'bg-dark',
            default           => 'bg-secondary',
        };
    @endphp

    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-2 mb-4">
        <h4 class="fw-bold mb-0 text-dark d-flex align-items-center">
            <div class="bg-primary bg-opacity-10 text-primary p-2 rounded-circle me-3 d-inline-flex justify-content-center align-items-center"
                style="width: 45px; height: 45px;">
                <i class="fas fa-file-contract"></i>
            </div>
            Detail Berita Acara
        </h4>
        <div class="d-flex gap-2">
            <button class="btn btn-light border fw-semibold rounded-pill px-4 shadow-sm" onclick="window.print()">
                <i class="fas fa-print me-2"></i> Cetak
            </button>
            <a href="{{ route('penghasil.beritaAcara') }}" class="btn btn-light fw-semibold rounded-pill px-4 shadow-sm border">
                <i class="fas fa-arrow-left me-2"></i> Kembali
            </a>
        </div>
    </div>

    {{-- Info Limbah --}}
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
        <div class="card-header bg-white border-bottom p-4 d-flex align-items-center justify-content-between gap-2 flex-wrap">
            <h6 class="mb-0 fw-bold d-flex align-items-center text-dark">
                <i class="fas fa-info-circle me-2 text-primary fs-5"></i> Informasi Pengiriman Limbah
            </h6>
            <span class="badge rounded-pill px-3 py-2 {{ $badgeClass }}">
                {{ strtoupper($limbah->status) }}
            </span>
        </div>
        <div class="card-body p-4">
            <div class="row g-4">
                <div class="col-12 col-lg-6">
                    <div class="mb-3 row g-2 align-items-center">
                        <label class="col-sm-4 col-form-label text-muted fw-medium small">NOMOR MANIFEST</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control bg-light border-0 fw-bold font-monospace text-primary"
                                value="{{ $limbah->no_manifest ?? '-' }}" readonly>
                        </div>
                    </div>
                    <div class="mb-3 row g-2 align-items-center">
                        <label class="col-sm-4 col-form-label text-muted fw-medium small">TRANSPORTER</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control bg-light border-0 fw-semibold text-dark"
                                value="{{ $transInfo->nama_transporter ?? $limbah->transporter->nama_user ?? '-' }}" readonly>
                        </div>
                    </div>
                    <div class="mb-3 row g-2 align-items-center">
                        <label class="col-sm-4 col-form-label text-muted fw-medium small">ALAMAT TRANSPORTER</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control bg-light border-0 fw-semibold text-dark"
                                value="{{ $transInfo->alamat_transporter ?? '-' }}" readonly>
                        </div>
                    </div>
                    <div class="mb-3 row g-2 align-items-center">
                        <label class="col-sm-4 col-form-label text-muted fw-medium small">NAMA DRIVER</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control bg-light border-0 fw-semibold text-dark"
                                value="{{ $limbah->nama_driver ?? '-' }}" readonly>
                        </div>
                    </div>
                    <div class="mb-3 row g-2 align-items-center">
                        <label class="col-sm-4 col-form-label text-muted fw-medium small">NOMOR KENDARAAN</label>
                        <div class="col-sm-8">
                            <div class="d-inline-block bg-dark text-white fw-bold px-3 py-1 rounded font-monospace">
                                {{ $limbah->no_kendaraan ?? '-' }}
                            </div>
                        </div>
                    </div>
                    @if($kontrak)
                        <div class="row g-2 align-items-center">
                            <label class="col-sm-4 col-form-label text-muted fw-medium small">NOMOR MOU</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control bg-light border-0 fw-semibold text-dark"
                                    value="{{ $kontrak->nomor_kontrak }}" readonly>
                            </div>
                        </div>
                    @endif
                </div>

                <div class="col-12 col-lg-6">
                    <div class="mb-3 row g-2 align-items-center">
                        <label class="col-sm-4 col-form-label text-muted fw-medium small">KODE LIMBAH</label>
                        <div class="col-sm-8">
                            <div class="d-inline-block bg-secondary bg-opacity-10 border border-secondary text-secondary fw-bold px-3 py-1 rounded font-monospace">
                                {{ $limbah->kode_limbah }}
                            </div>
                        </div>
                    </div>
                    <div class="mb-3 row g-2 align-items-center">
                        <label class="col-sm-4 col-form-label text-muted fw-medium small">JENIS LIMBAH</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control bg-light border-0 fw-semibold text-dark"
                                value="{{ $limbah->jenis_limbah ?? '-' }}" readonly>
                        </div>
                    </div>
                    <div class="mb-3 row g-2 align-items-center">
                        <label class="col-sm-4 col-form-label text-muted fw-medium small">SIFAT LIMBAH</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control bg-light border-0 fw-semibold text-dark"
                                value="{{ $limbah->sifat_limbah ?? '-' }}" readonly>
                        </div>
                    </div>
                    <div class="mb-3 row g-2 align-items-center">
                        <label class="col-sm-4 col-form-label text-muted fw-medium small">BERAT KELUAR</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control bg-light border-0 fw-bold text-dark"
                                value="{{ $limbah->jumlah_limbah }} {{ $limbah->satuan }}" readonly>
                        </div>
                    </div>
                    <div class="mb-3 row g-2 align-items-center">
                        <label class="col-sm-4 col-form-label text-muted fw-medium small">TGL ANGKUT</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control bg-light border-0 fw-semibold text-dark"
                                value="{{ $limbah->tgl_rencana?->format('d M Y') ?? '-' }}" readonly>
                        </div>
                    </div>
                    <div class="mb-3 row g-2 align-items-center">
                        <label class="col-sm-4 col-form-label text-muted fw-medium small">TGL DITERIMA</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control bg-light border-0 fw-semibold text-dark"
                                value="{{ $limbah->tgl_diterima?->format('d M Y') ?? '-' }}" readonly>
                        </div>
                    </div>
                    @if(in_array($limbah->status, ['Terolah', 'Telah Setor PAD']))
                        <div class="row g-2 align-items-center">
                            <label class="col-sm-4 col-form-label text-muted fw-medium small">TGL DIOLAH</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control bg-light border-0 fw-semibold text-dark"
                                    value="{{ $limbah->tgl_terolah?->format('d M Y') ?? '-' }}" readonly>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Berita Acara --}}
    @if($ba)
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-5">
            <div class="card-header bg-white border-bottom p-4">
                <h6 class="mb-0 fw-bold d-flex align-items-center text-dark text-uppercase">
                    <i class="fas fa-file-signature me-2 text-primary fs-5"></i> Berita Acara Penerimaan Limbah B3
                </h6>
            </div>
            <div class="card-body p-4 p-md-5">
                <div class="row g-5">

                    {{-- Penyerah --}}
                    <div class="col-12 col-lg-6">
                        <h6 class="fw-bold text-dark border-bottom pb-3 mb-4 small text-uppercase d-flex align-items-center">
                            <i class="fas fa-user-tag me-2 text-secondary"></i> Pihak Penyerah (Transporter)
                        </h6>
                        <div class="mb-3 row g-2 align-items-center">
                            <label class="col-sm-4 col-form-label text-muted fw-medium small">NAMA</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control bg-light border-0 fw-semibold text-dark"
                                    value="{{ $ba->nama_penyerah ?? '-' }}" readonly>
                            </div>
                        </div>
                        <div class="mb-3 row g-2 align-items-center">
                            <label class="col-sm-4 col-form-label text-muted fw-medium small">JABATAN</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control bg-light border-0 fw-semibold text-dark"
                                    value="{{ $ba->jabatan_penyerah ?? '-' }}" readonly>
                            </div>
                        </div>
                        <div class="mb-4 row g-2 align-items-center">
                            <label class="col-sm-4 col-form-label text-muted fw-medium small">ALAMAT</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control bg-light border-0 fw-semibold text-dark"
                                    value="{{ $ba->alamat_penyerah ?? '-' }}" readonly>
                            </div>
                        </div>
                        <div class="row g-3">
                            @if($ba->tandatangan_penyerah)
                                <div class="col-6">
                                    <label class="text-muted fw-medium small d-block mb-1">TANDA TANGAN</label>
                                    <div class="border rounded-3 p-2 bg-light d-inline-block shadow-sm">
                                        <img src="{{ asset('storage/'.$ba->tandatangan_penyerah) }}"
                                            alt="TTD Penyerah"
                                            style="max-height: 80px; max-width: 180px; object-fit: contain;">
                                    </div>
                                </div>
                            @endif
                            @if($ba->stempel_penyerah)
                                <div class="col-6">
                                    <label class="text-muted fw-medium small d-block mb-1">STEMPEL</label>
                                    <div class="border rounded-3 p-2 bg-light d-inline-block shadow-sm">
                                        <img src="{{ asset('storage/'.$ba->stempel_penyerah) }}"
                                            alt="Stempel Penyerah"
                                            style="max-height: 80px; max-width: 180px; object-fit: contain;">
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- Penerima --}}
                    <div class="col-12 col-lg-6">
                        <h6 class="fw-bold text-dark border-bottom pb-3 mb-4 small text-uppercase d-flex align-items-center">
                            <i class="fas fa-user-check me-2 text-primary"></i> Pihak Penerima (UPT)
                        </h6>
                        @if($ba->nama_penerima)
                            <div class="mb-3 row g-2 align-items-center">
                                <label class="col-sm-4 col-form-label text-muted fw-medium small">NAMA</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control bg-light border-0 fw-semibold text-dark"
                                        value="{{ $ba->nama_penerima }}" readonly>
                                </div>
                            </div>
                            <div class="mb-3 row g-2 align-items-center">
                                <label class="col-sm-4 col-form-label text-muted fw-medium small">JABATAN</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control bg-light border-0 fw-semibold text-dark"
                                        value="{{ $ba->jabatan_penerima ?? '-' }}" readonly>
                                </div>
                            </div>
                            <div class="mb-4 row g-2 align-items-center">
                                <label class="col-sm-4 col-form-label text-muted fw-medium small">ALAMAT</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control bg-light border-0 fw-semibold text-dark"
                                        value="{{ $ba->alamat_penerima ?? '-' }}" readonly>
                                </div>
                            </div>
                            <div class="row g-3">
                                @if($ba->tandatangan_penerima)
                                    <div class="col-6">
                                        <label class="text-muted fw-medium small d-block mb-1">TANDA TANGAN</label>
                                        <div class="border rounded-3 p-2 bg-light d-inline-block shadow-sm">
                                            <img src="{{ asset('storage/'.$ba->tandatangan_penerima) }}"
                                                alt="TTD Penerima"
                                                style="max-height: 80px; max-width: 180px; object-fit: contain;">
                                        </div>
                                    </div>
                                @endif
                                @if($ba->stempel_penerima)
                                    <div class="col-6">
                                        <label class="text-muted fw-medium small d-block mb-1">STEMPEL</label>
                                        <div class="border rounded-3 p-2 bg-light d-inline-block shadow-sm">
                                            <img src="{{ asset('storage/'.$ba->stempel_penerima) }}"
                                                alt="Stempel Penerima"
                                                style="max-height: 80px; max-width: 180px; object-fit: contain;">
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @else
                            <div class="text-center py-4 text-muted">
                                <i class="fas fa-clock fa-2x mb-2 d-block opacity-50"></i>
                                <small>Belum ditandatangani oleh penerima (UPT)</small>
                            </div>
                        @endif

                        @if($ba->tgl_penyerahan)
                            <div class="mt-4 p-3 bg-light rounded-3 border text-center">
                                <div class="small text-muted fw-medium mb-1">TANGGAL PENYERAHAN</div>
                                <div class="fw-bold text-dark">{{ $ba->tgl_penyerahan->format('d M Y') }}</div>
                            </div>
                        @endif
                    </div>

                </div>
            </div>
        </div>
    @else
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-5">
            <div class="card-body text-center py-5 text-muted">
                <i class="fas fa-file-contract fa-3x mb-3 d-block opacity-25"></i>
                <h6 class="fw-bold text-dark mb-1">Berita Acara Belum Tersedia</h6>
                <p class="mb-0 small">Berita acara akan muncul setelah transporter mengisi data penyerahan.</p>
            </div>
        </div>
    @endif

    <style>
        @media print {
            .btn, nav, .sidebar { display: none !important; }
            .card { box-shadow: none !important; border: 1px solid #dee2e6 !important; }
            body { background: white; }
        }
    </style>
@endsection
