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
                        <p class="mb-0 opacity-75 fs-6">Pantau dan kelola data pelaporan limbah B3 serta realisasi
                            Pendapatan Asli Daerah dengan mudah dan cepat.</p>
                    </div>
                    <!-- Decorative Icon -->
                    <i class="fas fa-chart-pie position-absolute text-white opacity-25"
                        style="font-size: 8rem; right: 5%; top: 50%; transform: translateY(-50%);"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Section: Quick Stats -->
    <div class="row g-3 mb-4">
        <div class="col-6 col-xl-3">
            <div class="card border-0 shadow-sm rounded-4 h-100 hover-lift">
                <div class="card-body p-3 d-flex align-items-center gap-3">
                    <div class="bg-primary bg-opacity-10 text-primary rounded-3 p-3">
                        <i class="fas fa-industry fs-4"></i>
                    </div>
                    <div>
                        <p class="text-muted fw-semibold mb-0 small">Penghasil</p>
                        <h5 class="fw-bold text-dark mb-0">{{ $totalPenghasil }}</h5>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-xl-3">
            <div class="card border-0 shadow-sm rounded-4 h-100 hover-lift">
                <div class="card-body p-3 d-flex align-items-center gap-3">
                    <div class="bg-secondary bg-opacity-10 text-secondary rounded-3 p-3">
                        <i class="fas fa-truck fs-4"></i>
                    </div>
                    <div>
                        <p class="text-muted fw-semibold mb-0 small">Transporter</p>
                        <h5 class="fw-bold text-dark mb-0">{{ $totalTransporter }}</h5>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-xl-3">
            <div class="card border-0 shadow-sm rounded-4 h-100 hover-lift">
                <div class="card-body p-3 d-flex align-items-center gap-3">
                    <div class="bg-info bg-opacity-10 text-info rounded-3 p-3">
                        <i class="fas fa-boxes-stacked fs-4"></i>
                    </div>
                    <div>
                        <p class="text-muted fw-semibold mb-0 small">Total Limbah</p>
                        <h5 class="fw-bold text-dark mb-0">{{ array_sum($statusCounts) }}</h5>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-xl-3">
            <div class="card border-0 shadow-sm rounded-4 h-100 hover-lift">
                <div class="card-body p-3 d-flex align-items-center gap-3">
                    <div class="bg-success bg-opacity-10 text-success rounded-3 p-3">
                        <i class="fas fa-check-double fs-4"></i>
                    </div>
                    <div>
                        <p class="text-muted fw-semibold mb-0 small">Selesai PAD</p>
                        <h5 class="fw-bold text-dark mb-0">{{ $statusCounts['selesai'] }}</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Section: Limbah B3 -->
    <div class="d-flex align-items-center mb-3">
        <div class="bg-success bg-opacity-10 text-success rounded-circle d-flex justify-content-center align-items-center me-3 shadow-sm"
            style="width: 45px; height: 45px;">
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
                            <h3 class="fw-bold text-dark mb-0">{{ number_format($totalLimbahDiterima, 2, ',', '.') }} <span
                                    class="fs-6 text-muted fw-normal">Ton</span></h3>
                        </div>
                        <div class="bg-info bg-opacity-10 text-info rounded-3 p-3">
                            <i class="fas fa-truck-loading fs-4"></i>
                        </div>
                    </div>
                    <a href="{{ route('admin.penerimaan.index', 'diterima') }}"
                        class="text-decoration-none text-info fw-semibold small d-inline-flex align-items-center">
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
                            <h3 class="fw-bold text-dark mb-0">{{ number_format($totalLimbahTerolah, 2, ',', '.') }} <span
                                    class="fs-6 text-muted fw-normal">Ton</span></h3>
                        </div>
                        <div class="bg-success bg-opacity-10 text-success rounded-3 p-3">
                            <i class="fas fa-recycle fs-4"></i>
                        </div>
                    </div>
                    <a href="{{ route('admin.penerimaan.index', 'diolah') }}"
                        class="text-decoration-none text-success fw-semibold small d-inline-flex align-items-center">
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
                            <h3 class="fw-bold text-dark mb-0">{{ number_format($totalLimbahBelumDiolah, 2, ',', '.') }}
                                <span class="fs-6 text-muted fw-normal">Ton</span></h3>
                        </div>
                        <div class="bg-warning bg-opacity-10 text-warning rounded-3 p-3">
                            <i class="fas fa-hourglass-half fs-4"></i>
                        </div>
                    </div>
                    <a href="{{ route('admin.penerimaan.index', 'diterima') }}"
                        class="text-decoration-none text-warning fw-semibold small d-inline-flex align-items-center">
                        Lihat Detail <i class="fas fa-arrow-right ms-2 fs-7"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Section: PAD -->
    <div class="d-flex align-items-center mb-3">
        <div class="bg-warning bg-opacity-10 text-warning rounded-circle d-flex justify-content-center align-items-center me-3 shadow-sm"
            style="width: 45px; height: 45px;">
            <i class="fas fa-coins fs-5"></i>
        </div>
        <h5 class="fw-bold mb-0 text-dark">Pendapatan Asli Daerah (PAD)</h5>
    </div>

    <div class="row g-4 mb-5">
        <div class="col-12 col-md-6 col-xl-4">
            <div class="card border-0 shadow-sm rounded-4 h-100 hover-lift bg-primary text-white">
                <div class="card-body p-4 position-relative overflow-hidden">
                    <i class="fas fa-chart-line position-absolute text-white opacity-25"
                        style="font-size: 5rem; right: -10px; bottom: -10px;"></i>
                    <p class="fw-semibold mb-1 opacity-75">Jumlah Potensi PAD</p>
                    <h3 class="fw-bold mb-0">Rp {{ number_format($potensiPad, 0, ',', '.') }}</h3>
                    <div class="mt-4">
                        <a href="{{ route('admin.laporan.potensi_pad') }}"
                            class="text-decoration-none text-white fw-semibold small d-inline-flex align-items-center">
                            Lihat Detail <i class="fas fa-arrow-right ms-2 fs-7"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-6 col-xl-4">
            <div class="card border-0 shadow-sm rounded-4 h-100 hover-lift bg-success text-white">
                <div class="card-body p-4 position-relative overflow-hidden">
                    <i class="fas fa-money-bill-wave position-absolute text-white opacity-25"
                        style="font-size: 5rem; right: -10px; bottom: -10px;"></i>
                    <p class="fw-semibold mb-1 opacity-75">Jumlah Realisasi PAD</p>
                    <h3 class="fw-bold mb-0">Rp {{ number_format($realisasiPad, 0, ',', '.') }}</h3>
                    <div class="mt-4">
                        <a href="{{ route('admin.laporan.penerimaan_pad') }}"
                            class="text-decoration-none text-white fw-semibold small d-inline-flex align-items-center">
                            Lihat Detail <i class="fas fa-arrow-right ms-2 fs-7"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-6 col-xl-4">
            <div class="card border-0 shadow-sm rounded-4 h-100 hover-lift bg-danger text-white">
                <div class="card-body p-4 position-relative overflow-hidden">
                    <i class="fas fa-file-invoice-dollar position-absolute text-white opacity-25"
                        style="font-size: 5rem; right: -10px; bottom: -10px;"></i>
                    <p class="fw-semibold mb-1 opacity-75">Jumlah Piutang</p>
                    <h3 class="fw-bold mb-0">Rp {{ number_format($piutangPad, 0, ',', '.') }}</h3>
                    <div class="mt-4">
                        <a href="{{ route('admin.laporan.piutang_pad') }}"
                            class="text-decoration-none text-white fw-semibold small d-inline-flex align-items-center">
                            Lihat Detail <i class="fas fa-arrow-right ms-2 fs-7"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Section: Rekap Table -->
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
                            <th class="py-3 fw-semibold text-start ps-4">Penghasil</th>
                            <th class="py-3 fw-semibold">Total Limbah B3 (Ton)</th>
                            <th class="py-3 fw-semibold">Telah Setor Retribusi PAD</th>
                            <th class="py-3 fw-semibold">Belum Setor Retribusi PAD</th>
                        </tr>
                    </thead>
                    <tbody class="border-top-0">
                        @forelse ($rekapPenghasil as $rekap)
                            <tr>
                                <td class="py-3 fw-semibold text-dark text-start ps-4">{{ $rekap->nama }}</td>
                                <td class="py-3 fw-semibold text-dark">{{ number_format($rekap->total_limbah, 2, ',', '.') }}
                                    Ton</td>
                                <td class="py-3 text-success fw-bold bg-success bg-opacity-10">
                                    {{ number_format($rekap->limbah_sudah_setor, 2, ',', '.') }} Ton
                                    <br>
                                    <small class="text-muted fw-normal">Rp
                                        {{ number_format($rekap->sudah_setor, 0, ',', '.') }}</small>
                                </td>
                                <td class="py-3 text-danger fw-bold bg-danger bg-opacity-10">
                                    {{ number_format($rekap->limbah_belum_setor, 2, ',', '.') }} Ton
                                    <br>
                                    <small class="text-muted fw-normal">Rp
                                        {{ number_format($rekap->belum_setor, 0, ',', '.') }}</small>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="py-4 text-muted">
                                    <i class="fas fa-inbox fs-3 d-block mb-2"></i>
                                    Belum ada data limbah yang diterima.
                                </td>
                            </tr>
                        @endforelse

                        @if ($rekapPenghasil->isNotEmpty())
                            <tr class="table-light fw-bold">
                                <td class="py-3 text-start ps-4">TOTAL</td>
                                <td class="py-3">{{ number_format($totalLimbahDiterima, 2, ',', '.') }} Ton</td>
                                <td class="py-3 text-success">Rp {{ number_format($realisasiPad, 0, ',', '.') }}</td>
                                <td class="py-3 text-danger">Rp {{ number_format($piutangPad, 0, ',', '.') }}</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Section: Aktivitas Terbaru -->
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
        <div class="card-header bg-white border-bottom p-4 d-flex align-items-center justify-content-between">
            <h6 class="mb-0 fw-bold d-flex align-items-center text-dark">
                <i class="fas fa-clock-rotate-left me-2 text-primary fs-5"></i>
                Aktivitas Limbah Terbaru
            </h6>
            <a href="{{ route('admin.penerimaan.index') }}" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                Lihat Semua <i class="fas fa-arrow-right ms-1"></i>
            </a>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0 align-middle">
                    <thead class="table-light text-muted">
                        <tr>
                            <th class="py-3 fw-semibold ps-4">Kode Limbah</th>
                            <th class="py-3 fw-semibold">Penghasil</th>
                            <th class="py-3 fw-semibold">Jumlah</th>
                            <th class="py-3 fw-semibold">Status</th>
                            <th class="py-3 fw-semibold">Tanggal</th>
                        </tr>
                    </thead>
                    <tbody class="border-top-0">
                        @forelse ($aktivitasTerbaru as $limbah)
                            <tr>
                                <td class="py-3 ps-4">
                                    <span class="fw-semibold text-dark">{{ $limbah->kode_limbah }}</span>
                                </td>
                                <td class="py-3">
                                    {{ $limbah->penghasil->informasiPenghasil->nama_perusahaan ?? $limbah->penghasil->nama_user ?? '-' }}
                                </td>
                                <td class="py-3 fw-semibold">{{ number_format($limbah->jumlah_limbah, 2, ',', '.') }}
                                    {{ $limbah->satuan }}</td>
                                <td class="py-3">
                                    @php
                                        $statusBadge = match ($limbah->status) {
                                            'Rencana' => 'bg-secondary',
                                            'Terangkut' => 'bg-info',
                                            'Diterima' => 'bg-primary',
                                            'Terolah' => 'bg-warning text-dark',
                                            'Telah Setor PAD' => 'bg-success',
                                            default => 'bg-secondary',
                                        };
                                    @endphp
                                    <span class="badge {{ $statusBadge }} rounded-pill px-3 py-2">{{ $limbah->status }}</span>
                                </td>
                                <td class="py-3 text-muted small">{{ $limbah->created_at->format('d M Y H:i') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-4 text-center text-muted">
                                    <i class="fas fa-inbox fs-3 d-block mb-2"></i>
                                    Belum ada data limbah.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
