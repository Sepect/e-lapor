@extends('layouts.app')

@section('title', 'Penerimaan Limbah B3')
@section('subtitle', 'Penerimaan Limbah B3')

@section('content')
    {{-- Page Header --}}
    <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden">
        <div class="card-body p-4 d-flex flex-column flex-md-row align-items-start align-items-md-center gap-3 bg-white position-relative">
            <!-- Decorative Background -->
            <div class="position-absolute top-0 start-0 w-100 h-100 bg-success opacity-10" style="pointer-events: none;"></div>
            <div class="position-absolute top-0 start-0 h-100 bg-success" style="width: 6px;"></div>

            <div class="bg-success bg-gradient text-white rounded-circle d-flex justify-content-center align-items-center flex-shrink-0 shadow-sm z-1"
                 style="width: 55px; height: 55px;">
                <i class="fas fa-truck-loading fs-4"></i>
            </div>
            <div class="flex-grow-1 z-1">
                <h5 class="fw-bold mb-1 text-dark">Penerimaan Limbah B3</h5>
                <p class="text-muted mb-0 small">Pantau status penerimaan dan pengolahan limbah B3 dari transporter ke fasilitas UPT.</p>
            </div>
        </div>
    </div>

    {{-- Filter Status --}}
    <div class="row g-4 mb-4 text-center">
        <div class="col-6 col-lg-3">
            <a href="{{ route('admin.penerimaan.index', 'terkirim') }}" class="text-decoration-none h-100 d-block">
                <div class="card h-100 shadow-sm rounded-4 border-0 {{ $status == 'terkirim' ? 'bg-primary text-white' : 'bg-white hover-lift' }} transition-all">
                    <div class="card-body p-4 position-relative overflow-hidden">
                        @if($status == 'terkirim')
                            <i class="fas fa-truck position-absolute text-white opacity-25" style="font-size: 5rem; right: -10px; bottom: -10px;"></i>
                        @else
                            <i class="fas fa-truck position-absolute text-primary opacity-10" style="font-size: 5rem; right: -10px; bottom: -10px;"></i>
                        @endif
                        <div class="display-5 fw-bold mb-2 {{ $status == 'terkirim' ? 'text-white' : 'text-primary' }}">{{ $statusCounts['terkirim'] }}</div>
                        <div class="small fw-semibold text-uppercase letter-spacing-1 {{ $status == 'terkirim' ? 'text-white-50' : 'text-muted' }}">Limbah Diangkut</div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-6 col-lg-3">
            <a href="{{ route('admin.penerimaan.index', 'diterima') }}" class="text-decoration-none h-100 d-block">
                <div class="card h-100 shadow-sm rounded-4 border-0 {{ $status == 'diterima' ? 'bg-success text-white' : 'bg-white hover-lift' }} transition-all">
                    <div class="card-body p-4 position-relative overflow-hidden">
                        @if($status == 'diterima')
                            <i class="fas fa-box-open position-absolute text-white opacity-25" style="font-size: 5rem; right: -10px; bottom: -10px;"></i>
                        @else
                            <i class="fas fa-box-open position-absolute text-success opacity-10" style="font-size: 5rem; right: -10px; bottom: -10px;"></i>
                        @endif
                        <div class="display-5 fw-bold mb-2 {{ $status == 'diterima' ? 'text-white' : 'text-success' }}">{{ $statusCounts['diterima'] }}</div>
                        <div class="small fw-semibold text-uppercase letter-spacing-1 {{ $status == 'diterima' ? 'text-white-50' : 'text-muted' }}">Limbah Diterima</div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-6 col-lg-3">
            <a href="{{ route('admin.penerimaan.index', 'diolah') }}" class="text-decoration-none h-100 d-block">
                <div class="card h-100 shadow-sm rounded-4 border-0 {{ $status == 'diolah' ? 'bg-warning text-dark' : 'bg-white hover-lift' }} transition-all">
                    <div class="card-body p-4 position-relative overflow-hidden">
                        @if($status == 'diolah')
                            <i class="fas fa-recycle position-absolute text-dark opacity-25" style="font-size: 5rem; right: -10px; bottom: -10px;"></i>
                        @else
                            <i class="fas fa-recycle position-absolute text-warning opacity-10" style="font-size: 5rem; right: -10px; bottom: -10px;"></i>
                        @endif
                        <div class="display-5 fw-bold mb-2 {{ $status == 'diolah' ? 'text-dark' : 'text-warning' }}">{{ $statusCounts['diolah'] }}</div>
                        <div class="small fw-semibold text-uppercase letter-spacing-1 {{ $status == 'diolah' ? 'text-dark-50' : 'text-muted' }}" style="{{ $status == 'diolah' ? 'opacity: 0.7;' : '' }}">Limbah Diolah</div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-6 col-lg-3">
            <a href="{{ route('admin.penerimaan.index', 'selesai') }}" class="text-decoration-none h-100 d-block">
                <div class="card h-100 shadow-sm rounded-4 border-0 {{ $status == 'selesai' ? 'bg-secondary text-white' : 'bg-white hover-lift' }} transition-all">
                    <div class="card-body p-4 position-relative overflow-hidden">
                        @if($status == 'selesai')
                            <i class="fas fa-check-double position-absolute text-white opacity-25" style="font-size: 5rem; right: -10px; bottom: -10px;"></i>
                        @else
                            <i class="fas fa-check-double position-absolute text-secondary opacity-10" style="font-size: 5rem; right: -10px; bottom: -10px;"></i>
                        @endif
                        <div class="display-5 fw-bold mb-2 {{ $status == 'selesai' ? 'text-white' : 'text-secondary' }}">{{ $statusCounts['selesai'] }}</div>
                        <div class="small fw-semibold text-uppercase letter-spacing-1 {{ $status == 'selesai' ? 'text-white-50' : 'text-muted' }}">Selesai Diolah</div>
                    </div>
                </div>
            </a>
        </div>
    </div>

    @if(empty($status) || !in_array($status, ['terkirim', 'diterima', 'diolah', 'selesai']))

        <div class="text-center py-5 my-4 bg-white rounded-4 shadow-sm border-0 position-relative overflow-hidden">
            <div class="position-absolute top-0 start-0 w-100 h-100 bg-light opacity-50" style="pointer-events: none;"></div>
            <div class="position-relative z-1 px-4">
                <div class="bg-white p-3 rounded-circle shadow-sm d-inline-flex mb-4">
                    <img src="{{ asset('assets/img/logo_pemprov.png') }}"
                         alt="Logo Sulawesi Selatan"
                         style="max-height: 100px;">
                </div>
                <h5 class="fw-bold text-uppercase lh-base text-dark mb-3">
                    Unit Pelaksana Teknis Pengelolaan Limbah Bahan Berbahaya dan Beracun<br>
                    <span class="text-success">Dinas Pengelolaan Lingkungan Hidup</span><br>
                    Provinsi Sulawesi Selatan
                </h5>
                <p class="text-muted mx-auto" style="max-width: 500px;">
                    Silakan klik pada salah satu kartu filter di atas untuk melihat daftar spesifik penerimaan limbah B3.
                </p>
            </div>
        </div>

    @else

        <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-5">
            <div class="card-header bg-white border-bottom p-4 d-flex align-items-center justify-content-between flex-wrap gap-2">
                <h6 class="mb-0 fw-bold d-flex align-items-center text-dark">
                    <div class="bg-secondary bg-opacity-10 text-secondary rounded p-2 me-3">
                        <i class="fas fa-list"></i>
                    </div>
                    Daftar Limbah B3
                </h6>
                <span class="badge rounded-pill px-3 py-2
                    @if($status == 'terkirim') bg-primary bg-opacity-10 text-primary border border-primary-subtle
                    @elseif($status == 'diterima') bg-success bg-opacity-10 text-success border border-success-subtle
                    @elseif($status == 'diolah') bg-warning bg-opacity-10 text-warning-emphasis border border-warning-subtle
                    @else bg-secondary bg-opacity-10 text-secondary border border-secondary-subtle
                    @endif text-uppercase letter-spacing-1 fs-7">
                    <i class="fas fa-circle me-1" style="font-size: 8px;"></i> Status: {{ $status }}
                </span>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle text-nowrap mb-0 w-100">
                        <thead class="table-light text-muted">
                            <tr>
                                <th rowspan="2" class="sticky-col first-col text-center align-middle py-3 border-end">Aksi</th>
                                <th rowspan="2" class="align-middle py-3">Tanggal Angkut</th>
                                <th rowspan="2" class="align-middle py-3">Transporter</th>
                                <th rowspan="2" class="align-middle py-3 border-end">Nama Penghasil</th>
                                <th colspan="2" class="text-center py-2 border-end">Limbah B3</th>
                                <th rowspan="2" class="align-middle py-3">Kode</th>
                                <th rowspan="2" class="align-middle py-3 text-end">Jumlah</th>
                                <th rowspan="2" class="align-middle py-3 border-end">Kemasan</th>
                                <th rowspan="2" class="align-middle py-3 border-end">No. Manifest</th>
                                <th colspan="3" class="text-center py-2 border-end">Kendaraan</th>
                                <th rowspan="2" class="sticky-col last-col text-center align-middle py-3">Status</th>
                            </tr>
                            <tr>
                                <th class="py-2 text-center">Jenis</th>
                                <th class="py-2 text-center border-end">Sifat</th>
                                <th class="py-2 text-center">Jenis</th>
                                <th class="py-2 text-center">Nomor</th>
                                <th class="py-2 text-center border-end">Driver</th>
                            </tr>
                        </thead>
                        <tbody class="border-top-0">
                            @forelse($dataLimbah as $item)
                                <tr>
                                    <td class="sticky-col first-col bg-white">
                                        <div class="d-flex flex-column gap-1">
                                            @if($item->status == 'Terangkut')
                                                <a href="{{ route('admin.penerimaan.show', $item->id_limbah) }}"
                                                   class="btn btn-primary btn-sm rounded-pill shadow-sm px-3 w-100">
                                                    <i class="fas fa-check-double me-1"></i> Verifikasi
                                                </a>
                                            @elseif($item->status == 'Diterima')
                                                <a href="{{ route('admin.penerimaan.show', $item->id_limbah) }}"
                                                   class="btn btn-light btn-sm rounded-pill border fw-semibold px-3 w-100 text-dark">
                                                    <i class="fas fa-eye me-1 text-primary"></i> Detail
                                                </a>
                                                <a href="#" class="btn btn-outline-secondary btn-sm rounded-pill mt-1 w-100">
                                                    <i class="fas fa-print"></i>
                                                </a>
                                            @elseif($item->status == 'Terolah')
                                                <a href="{{ route('admin.penerimaan.show', $item->id_limbah) }}"
                                                   class="btn btn-light btn-sm rounded-pill border fw-semibold px-3 w-100 text-dark">
                                                    <i class="fas fa-eye me-1 text-primary"></i> Detail
                                                </a>
                                                <a href="#" class="btn btn-outline-secondary btn-sm rounded-pill mt-1 w-100">
                                                    <i class="fas fa-print me-1"></i> Cetak
                                                </a>
                                            @else
                                                <a href="{{ route('admin.penerimaan.show', $item->id_limbah) }}"
                                                   class="btn btn-light btn-sm rounded-pill border fw-semibold px-3 w-100 text-dark">
                                                    <i class="fas fa-eye me-1 text-primary"></i> Detail
                                                </a>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="text-muted fw-medium py-3">{{ $item->tgl_rencana ? $item->tgl_rencana->format('d M Y') : '-' }}</td>
                                    <td class="fw-semibold text-dark">{{ $item->transporter->informasiTransporter->nama_transporter ?? '-' }}</td>
                                    <td class="border-end text-muted">{{ $item->penghasil->informasiPenghasil->nama_perusahaan ?? '-' }}</td>
                                    <td class="text-center">{{ $item->jenis_limbah ?? '-' }}</td>
                                    <td class="text-center border-end">{{ $item->sifat_limbah ?? '-' }}</td>
                                    <td class="text-center">
                                        <span class="badge bg-light text-secondary border px-2 py-1">{{ $item->kode_limbah ?? '-' }}</span>
                                    </td>
                                    <td class="fw-bold text-end text-dark">{{ $item->jumlah_limbah }}</td>
                                    <td class="border-end">{{ $item->satuan }}</td>
                                    <td class="border-end">
                                        <span class="font-monospace text-primary bg-primary bg-opacity-10 px-2 py-1 rounded">{{ $item->no_manifest ?? '-' }}</span>
                                    </td>
                                    <td class="text-center">{{ $item->jenis_kendaraan ?? '-' }}</td>
                                    <td class="text-center">
                                        <span class="badge bg-dark bg-opacity-10 text-dark border border-dark-subtle">{{ $item->no_kendaraan ?? '-' }}</span>
                                    </td>
                                    <td class="border-end text-center">{{ $item->nama_driver ?? '-' }}</td>
                                    <td class="sticky-col last-col text-center bg-white">
                                        @if($item->status == 'Terangkut')
                                            <span class="badge bg-primary w-100 py-2 rounded-pill shadow-sm">
                                                <i class="fas fa-truck me-1"></i> Terangkut
                                            </span>
                                        @elseif($item->status == 'Diterima')
                                            <span class="badge bg-success w-100 py-2 rounded-pill shadow-sm">
                                                <i class="fas fa-check-circle me-1"></i> Diterima
                                            </span>
                                        @elseif($item->status == 'Terolah')
                                            <span class="badge bg-warning text-dark w-100 py-2 rounded-pill shadow-sm">
                                                <i class="fas fa-cog me-1"></i> Diolah
                                            </span>
                                        @else
                                            <span class="badge bg-secondary w-100 py-2 rounded-pill shadow-sm">
                                                <i class="fas fa-flag-checkered me-1"></i> {{ $item->status ?? 'Selesai' }}
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="14" class="text-center py-5 text-muted">
                                        <div class="d-inline-flex justify-content-center align-items-center bg-light rounded-circle mb-3" style="width: 80px; height: 80px;">
                                            <i class="fas fa-folder-open fa-2x text-secondary"></i>
                                        </div>
                                        <h6 class="fw-bold text-dark mb-1">Data Kosong</h6>
                                        <p class="mb-0 small">Belum ada data limbah untuk status ini.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card-footer bg-light border-top-0 py-3 px-4">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-3">
                    <span class="text-muted small fw-medium">
                        Menampilkan <span class="fw-bold text-dark">{{ $dataLimbah->firstItem() ?? 0 }}</span> s/d
                        <span class="fw-bold text-dark">{{ $dataLimbah->lastItem() ?? 0 }}</span>
                        dari total <span class="fw-bold text-dark">{{ $dataLimbah->total() }}</span> data
                    </span>
                    <div class="m-0 pagination-rounded">
                        {{ $dataLimbah->withQueryString()->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>
        
        <style>
            .hover-lift { transition: transform 0.2s ease, box-shadow 0.2s ease; }
            .hover-lift:hover { transform: translateY(-5px); box-shadow: 0 .5rem 1rem rgba(0,0,0,.15)!important; }
            .letter-spacing-1 { letter-spacing: 0.5px; }
            .sticky-col.first-col { z-index: 10; left: 0; box-shadow: 2px 0 5px -2px rgba(0,0,0,0.1); }
            .sticky-col.last-col { z-index: 10; right: 0; box-shadow: -2px 0 5px -2px rgba(0,0,0,0.1); }
            .pagination-rounded .pagination { margin-bottom: 0; }
            .pagination-rounded .page-link { border-radius: 50%; width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; margin: 0 3px; border: none; color: #495057; font-weight: 500; }
            .pagination-rounded .page-item.active .page-link { background-color: #0d6efd; color: white; box-shadow: 0 4px 6px rgba(13,110,253,0.2); }
            .pagination-rounded .page-item.disabled .page-link { background-color: transparent; }
        </style>

    @endif
@endsection
