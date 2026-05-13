@extends('layouts.app')

@section('title', 'Setor Biaya Pengolahan')

@section('content')
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-2 mb-4">
        <h4 class="fw-bold mb-0 text-dark d-flex align-items-center">
            <div class="bg-success bg-opacity-10 text-success p-2 rounded-circle me-3 d-inline-flex justify-content-center align-items-center"
                style="width: 45px; height: 45px;">
                <i class="fas fa-money-bill-wave"></i>
            </div>
            Setor Biaya Pengolahan
        </h4>
        <a href="{{ route('penghasil.dashboard') }}" class="btn btn-light fw-semibold rounded-pill px-4 shadow-sm border">
            <i class="fas fa-arrow-left me-2"></i> Kembali
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-4 shadow-sm mb-4" role="alert">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-5">
        <div class="card-body p-4 p-md-5">

            {{-- Filter --}}
            <form method="GET" action="{{ route('penghasil.pembayaran') }}">
                <div class="bg-light p-4 rounded-4 mb-4 border">
                    <h6 class="fw-bold mb-3 d-flex align-items-center text-dark">
                        <i class="fas fa-filter me-2 text-primary"></i> Filter Data
                    </h6>
                    <div class="row g-3 align-items-end">
                        <div class="col-md-4">
                            <label class="form-label text-muted fw-semibold small">KODE MANIFEST</label>
                            <input type="text" class="form-control shadow-sm" name="manifest"
                                value="{{ request('manifest') }}" placeholder="Masukkan kode manifest...">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label text-muted fw-semibold small">STATUS</label>
                            <select class="form-select shadow-sm" name="status">
                                <option value="">Semua Status</option>
                                <option value="Terolah" {{ request('status') === 'Terolah' ? 'selected' : '' }}>Belum Setor</option>
                                <option value="Telah Setor PAD" {{ request('status') === 'Telah Setor PAD' ? 'selected' : '' }}>Telah Setor</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label text-muted fw-semibold small">TRANSPORTER</label>
                            <input type="text" class="form-control shadow-sm" name="transporter"
                                value="{{ request('transporter') }}" placeholder="Nama transporter">
                        </div>
                        <div class="col-md-2 d-flex gap-2">
                            <button type="submit" class="btn btn-primary fw-bold flex-grow-1 shadow-sm rounded-pill">
                                <i class="fas fa-search"></i>
                            </button>
                            <a href="{{ route('penghasil.pembayaran') }}"
                                class="btn btn-light fw-bold shadow-sm rounded-circle border d-flex align-items-center justify-content-center"
                                style="width: 40px; height: 38px;">
                                <i class="fas fa-undo text-muted"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </form>

            {{-- Tabel --}}
            <div class="table-responsive rounded-3 shadow-sm border mb-4">
                <table class="table table-bordered table-hover align-middle mb-0">
                    <thead class="table-light text-center align-middle">
                        <tr>
                            <th rowspan="2" style="width: 70px;">#</th>
                            <th rowspan="2" style="width: 40px;">NO</th>
                            <th rowspan="2">TRANSPORTER</th>
                            <th rowspan="2">KODE MANIFEST</th>
                            <th colspan="2">BA PENERIMAAN LIMBAH B3</th>
                            <th colspan="2">SURAT TAGIHAN</th>
                            <th rowspan="2">BERAT LIMBAH B3</th>
                            <th rowspan="2">JUMLAH TAGIHAN</th>
                            <th rowspan="2">STATUS</th>
                        </tr>
                        <tr>
                            <th class="border-top-0">NOMOR</th>
                            <th class="border-top-0">TANGGAL</th>
                            <th class="border-top-0">NOMOR</th>
                            <th class="border-top-0">TANGGAL</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($dataLimbah as $i => $limbah)
                            @php
                                $transNama  = $limbah->transporter->informasiTransporter->nama_transporter
                                    ?? $limbah->transporter->nama_user
                                    ?? '-';
                                $ba         = $limbah->beritaAcara;
                                $tagihanRow = $limbah->tagihan;
                                $sudahSetor = $limbah->status === 'Telah Setor PAD';
                            @endphp
                            <tr class="{{ !$sudahSetor ? 'table-warning bg-opacity-25' : '' }}">
                                <td class="text-center">
                                    @if($sudahSetor)
                                        <span class="badge bg-success rounded-pill px-3 py-2 small fw-bold">
                                            <i class="fas fa-check me-1"></i> LUNAS
                                        </span>
                                    @else
                                        <a href="{{ route('penghasil.pembayaran.form', $limbah->id_limbah) }}"
                                            class="btn btn-sm btn-primary fw-bold rounded-pill px-3">
                                            <i class="fas fa-paper-plane me-1"></i> SETOR
                                        </a>
                                    @endif
                                </td>
                                <td class="text-center text-muted">{{ $dataLimbah->firstItem() + $i }}</td>
                                <td class="fw-medium">{{ $transNama }}</td>
                                <td class="text-center fw-bold text-primary font-monospace">
                                    {{ $limbah->no_manifest ?? '-' }}
                                </td>
                                <td class="text-center font-monospace small">
                                    {{ $ba ? strtoupper(substr($ba->id_berita_acara, 0, 8)) : '-' }}
                                </td>
                                <td class="text-center text-nowrap">
                                    {{ $ba?->tgl_penyerahan?->format('d M Y') ?? '-' }}
                                </td>
                                <td class="text-center font-monospace small">
                                    {{ $tagihanRow?->nomor_tagihan ?? '-' }}
                                </td>
                                <td class="text-center text-nowrap">
                                    {{ $tagihanRow?->tgl_tagihan?->format('d M Y') ?? '-' }}
                                </td>
                                <td class="text-center fw-semibold text-nowrap">
                                    {{ $limbah->jumlah_limbah }} {{ $limbah->satuan }}
                                </td>
                                <td class="text-end fw-bold text-nowrap">
                                    @if($tagihanRow)
                                        Rp {{ number_format($tagihanRow->jumlah_tagihan, 0, ',', '.') }}
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td class="text-center text-nowrap">
                                    @if($sudahSetor)
                                        <div class="small text-muted fw-semibold">DIOLAH</div>
                                        <span class="badge bg-dark rounded-pill px-3 py-1 mt-1">
                                            <i class="fas fa-flag-checkered me-1"></i> TELAH SETOR
                                        </span>
                                    @else
                                        <div class="small text-muted fw-semibold">DIOLAH</div>
                                        <span class="badge bg-warning text-dark rounded-pill px-3 py-1 mt-1">
                                            <i class="fas fa-clock me-1"></i> BELUM SETOR
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="11" class="text-center py-5 text-muted">
                                    <i class="fas fa-folder-open fa-2x mb-2 d-block opacity-50"></i>
                                    Belum ada data pembayaran.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-center">
                {{ $dataLimbah->links() }}
            </div>

        </div>
    </div>

@endsection
