@extends('layouts.app')

@section('title', 'Detail Surat Tagihan')

@section('content')
    @php
        $transInfo = $limbah->transporter->informasiTransporter ?? null;
        $kontrak   = $limbah->kontrak;
        $sudahSetor = $limbah->status === 'Telah Setor PAD';
    @endphp

    {{-- Navigasi --}}
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-2 mb-4 no-print">
        <h4 class="fw-bold mb-0 text-dark d-flex align-items-center">
            <div class="bg-primary bg-opacity-10 text-primary p-2 rounded-circle me-3 d-inline-flex justify-content-center align-items-center"
                style="width: 45px; height: 45px;">
                <i class="fas fa-file-invoice-dollar"></i>
            </div>
            Detail Surat Tagihan
        </h4>
        <div class="d-flex gap-2">
            <button onclick="window.print()" class="btn btn-primary fw-semibold rounded-pill px-4 shadow-sm">
                <i class="fas fa-print me-2"></i> Cetak
            </button>
            <a href="{{ route('penghasil.tagihan') }}" class="btn btn-light fw-semibold rounded-pill px-4 shadow-sm border">
                <i class="fas fa-arrow-left me-2"></i> Kembali
            </a>
        </div>
    </div>

    {{-- Dokumen Surat Tagihan --}}
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-5" id="suratTagihan">
        <div class="card-body p-4 p-md-5">

            {{-- Kop Surat --}}
            <div class="border-bottom border-2 border-dark pb-4 mb-4">
                <div class="d-flex align-items-center gap-4">
                    <img src="{{ asset('assets/img/logo_pemprov.png') }}" alt="Logo"
                        style="height: 80px; width: auto;">
                    <div>
                        <div class="fw-bold text-uppercase" style="font-size: 0.8rem; letter-spacing: 1px; color: #555;">
                            Pemerintah Provinsi Sulawesi Selatan
                        </div>
                        <div class="fw-bold text-uppercase" style="font-size: 1.05rem;">
                            Dinas Pengelolaan Lingkungan Hidup
                        </div>
                        <div class="fw-semibold" style="font-size: 0.85rem; color: #333;">
                            Unit Pelaksana Teknis Pengelolaan Limbah B3
                        </div>
                        <div class="text-muted small mt-1">
                            Jl. Perintis Kemerdekaan No. 1, Makassar &nbsp;|&nbsp;
                            Telp. (0411) 123456
                        </div>
                    </div>
                </div>
            </div>

            {{-- Judul --}}
            <div class="text-center mb-4">
                <h5 class="fw-bold text-uppercase mb-1" style="letter-spacing: 2px;">Surat Tagihan</h5>
                @if($tagihanRecord)
                    <div class="font-monospace fw-bold text-primary">{{ $tagihanRecord->nomor_tagihan }}</div>
                @endif
            </div>

            {{-- Info Tagihan & Penerima --}}
            <div class="row g-4 mb-4">
                <div class="col-12 col-md-6">
                    <table class="w-100" style="font-size: 0.9rem;">
                        <tr>
                            <td class="text-muted py-1" style="width: 140px;">Tanggal Tagihan</td>
                            <td class="fw-medium">:&nbsp; {{ $tagihanRecord?->tgl_tagihan?->format('d M Y') ?? $limbah->tgl_terolah?->format('d M Y') ?? now()->format('d M Y') }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted py-1">Jatuh Tempo</td>
                            <td class="fw-medium">:&nbsp;
                                @if($tagihanRecord?->tgl_jatuh_tempo)
                                    <span class="{{ $tagihanRecord->tgl_jatuh_tempo->isPast() && $tagihanRecord->status_pembayaran === 'Belum Dibayar' ? 'text-danger fw-bold' : '' }}">
                                        {{ $tagihanRecord->tgl_jatuh_tempo->format('d M Y') }}
                                    </span>
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="text-muted py-1">Jenis Tagihan</td>
                            <td class="fw-medium">:&nbsp; {{ $tagihanRecord?->jenis_tagihan ?? 'Retribusi' }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted py-1">Status</td>
                            <td class="fw-medium">:&nbsp;
                                @php
                                    $status    = $tagihanRecord?->status_pembayaran ?? 'Belum Dibayar';
                                    $badgeColor = $status === 'Lunas' ? 'bg-success' : 'bg-warning text-dark';
                                @endphp
                                <span class="badge rounded-pill px-3 py-1 {{ $badgeColor }}">{{ $status }}</span>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="col-12 col-md-6">
                    <div class="bg-light rounded-3 p-3 border" style="font-size: 0.9rem;">
                        <div class="fw-bold text-uppercase small text-muted mb-2">Ditagihkan Kepada:</div>
                        <div class="fw-bold text-dark" style="font-size: 1rem;">
                            {{ $info?->nama_penghasil ?? auth()->user()->nama_user }}
                        </div>
                        @if($info?->alamat_penghasil)
                            <div class="text-muted mt-1">{{ $info->alamat_penghasil }}</div>
                        @endif
                        @if($info?->kota_penghasil)
                            <div class="text-muted">{{ $info->kota_penghasil }}</div>
                        @endif
                        @if($info?->telepon_penghasil)
                            <div class="text-muted mt-1">
                                <i class="fas fa-phone me-1"></i> {{ $info->telepon_penghasil }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Tabel Detail Limbah --}}
            <div class="table-responsive rounded-3 border mb-4">
                <table class="table table-bordered align-middle mb-0" style="font-size: 0.9rem;">
                    <thead class="table-light text-center text-uppercase">
                        <tr>
                            <th style="width: 30px;">No</th>
                            <th>Keterangan Limbah</th>
                            <th>Transporter</th>
                            <th>Tgl Angkut</th>
                            <th>Tgl Diterima</th>
                            <th>Tgl Diolah</th>
                            <th>Berat / Satuan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="text-center text-muted">1</td>
                            <td>
                                <div class="fw-bold">
                                    <span class="badge bg-secondary bg-opacity-10 text-dark border font-monospace me-2">
                                        {{ $limbah->kode_limbah }}
                                    </span>
                                    {{ $limbah->jenis_limbah ?? '-' }}
                                </div>
                                @if($limbah->sifat_limbah)
                                    <div class="small text-muted mt-1">Sifat: {{ $limbah->sifat_limbah }}</div>
                                @endif
                                @if($limbah->no_manifest)
                                    <div class="small text-muted mt-1">
                                        Manifest: <span class="font-monospace text-primary">{{ $limbah->no_manifest }}</span>
                                    </div>
                                @endif
                                @if($kontrak)
                                    <div class="small text-muted mt-1">MOU: {{ $kontrak->nomor_kontrak }}</div>
                                @endif
                            </td>
                            <td class="fw-medium">
                                {{ $transInfo->nama_transporter ?? $limbah->transporter->nama_user ?? '-' }}
                                @if($limbah->no_kendaraan)
                                    <div class="small text-muted mt-1 font-monospace">{{ $limbah->no_kendaraan }}</div>
                                @endif
                            </td>
                            <td class="text-center text-nowrap">
                                {{ $limbah->tgl_rencana?->format('d M Y') ?? '-' }}
                            </td>
                            <td class="text-center text-nowrap">
                                {{ $limbah->tgl_diterima?->format('d M Y') ?? '-' }}
                            </td>
                            <td class="text-center text-nowrap">
                                {{ $limbah->tgl_terolah?->format('d M Y') ?? '-' }}
                            </td>
                            <td class="text-center fw-bold text-nowrap">
                                {{ $limbah->jumlah_limbah }} {{ $limbah->satuan }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            {{-- Total Tagihan --}}
            <div class="row justify-content-end mb-5">
                <div class="col-12 col-md-5">
                    <table class="w-100" style="font-size: 0.95rem;">
                        @if($tagihanRecord)
                            <tr>
                                <td class="py-2 text-muted">Subtotal</td>
                                <td class="py-2 text-end fw-medium">
                                    Rp {{ number_format($tagihanRecord->jumlah_tagihan, 0, ',', '.') }}
                                </td>
                            </tr>
                            <tr class="border-top">
                                <td class="py-2 fw-bold text-dark fs-6">TOTAL</td>
                                <td class="py-2 text-end fw-bold text-primary fs-6">
                                    Rp {{ number_format($tagihanRecord->jumlah_tagihan, 0, ',', '.') }}
                                </td>
                            </tr>
                            @if($tagihanRecord->status_pembayaran === 'Lunas')
                                <tr>
                                    <td colspan="2" class="pt-2 text-center">
                                        <span class="badge bg-success px-4 py-2 rounded-pill fw-bold">
                                            <i class="fas fa-check-circle me-1"></i> LUNAS
                                        </span>
                                    </td>
                                </tr>
                            @endif
                        @else
                            <tr class="border-top">
                                <td colspan="2" class="py-2 text-center text-muted small fst-italic">
                                    Nominal tagihan belum ditetapkan
                                </td>
                            </tr>
                        @endif
                    </table>
                </div>
            </div>

            {{-- Tanda Tangan --}}
            <div class="row mt-2">
                <div class="col-6 col-md-4 offset-md-4 text-center">
                    <div class="fw-semibold mb-1" style="font-size: 0.9rem;">Makassar, {{ now()->format('d M Y') }}</div>
                    <div class="text-muted small mb-5">Pejabat Penerbit Tagihan</div>
                    <div class="border-bottom border-dark mb-1 mx-4"></div>
                    <div class="fw-bold small text-uppercase" style="font-size: 0.8rem;">(................................)</div>
                    <div class="text-muted" style="font-size: 0.75rem;">NIP. ................................</div>
                </div>
                <div class="col-6 col-md-4 text-center">
                    <div class="fw-semibold mb-1" style="font-size: 0.9rem;">Makassar, {{ now()->format('d M Y') }}</div>
                    <div class="text-muted small mb-5">Penerima Tagihan</div>
                    <div class="border-bottom border-dark mb-1 mx-4"></div>
                    <div class="fw-bold small text-uppercase" style="font-size: 0.8rem;">
                        {{ $info?->nama_penanggung_jawab ?? auth()->user()->nama_user }}
                    </div>
                    <div class="text-muted" style="font-size: 0.75rem;">
                        {{ $info?->nama_penghasil ?? '' }}
                    </div>
                </div>
            </div>

        </div>
    </div>

    <style>
        @media print {
            .no-print, nav, .sidebar { display: none !important; }
            .card { box-shadow: none !important; border: none !important; }
            body, html { background: white !important; }
            #suratTagihan { margin: 0; }
        }
        @media screen {
            #suratTagihan { max-width: 900px; margin: 0 auto; }
        }
    </style>
@endsection
