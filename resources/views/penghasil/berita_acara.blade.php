@extends('layouts.app')

@section('title', 'BA Penerimaan Limbah B3')

@section('content')
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-2 mb-4">
        <h4 class="fw-bold mb-0 text-dark d-flex align-items-center">
            <div class="bg-primary bg-opacity-10 text-primary p-2 rounded-circle me-3 d-inline-flex justify-content-center align-items-center" style="width: 45px; height: 45px;">
                <i class="fas fa-file-contract"></i>
            </div>
            BA Penerimaan Limbah B3
        </h4>
        <a href="{{ route('penghasil.dashboard') }}" class="btn btn-light fw-semibold rounded-pill px-4 shadow-sm border">
            <i class="fas fa-arrow-left me-2"></i> Kembali
        </a>
    </div>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-5">
        <div class="card-body p-4 p-md-5">

            {{-- Filter --}}
            <form method="GET" action="{{ route('penghasil.beritaAcara') }}">
                <div class="bg-light p-4 rounded-4 mb-4 border">
                    <h6 class="fw-bold mb-3 d-flex align-items-center text-dark">
                        <i class="fas fa-filter me-2 text-primary"></i> Filter Data
                    </h6>
                    <div class="row g-3 align-items-end">
                        <div class="col-md-4">
                            <label class="form-label text-muted fw-semibold small">KODE MANIFEST</label>
                            <input type="text" class="form-control shadow-sm" name="manifest"
                                value="{{ request('manifest') }}" placeholder="Cari nomor manifest...">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label text-muted fw-semibold small">STATUS</label>
                            <select class="form-select shadow-sm" name="status">
                                <option value="">Semua Status</option>
                                <option value="Terangkut" {{ request('status') === 'Terangkut' ? 'selected' : '' }}>Terangkut</option>
                                <option value="Diterima" {{ request('status') === 'Diterima' ? 'selected' : '' }}>Diterima</option>
                                <option value="Terolah" {{ request('status') === 'Terolah' ? 'selected' : '' }}>Terolah</option>
                                <option value="Telah Setor PAD" {{ request('status') === 'Telah Setor PAD' ? 'selected' : '' }}>Telah Setor PAD</option>
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
                            <a href="{{ route('penghasil.beritaAcara') }}"
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
                            <th rowspan="2" style="width: 50px;">#</th>
                            <th rowspan="2" style="width: 40px;">NO</th>
                            <th rowspan="2">TRANSPORTER</th>
                            <th colspan="2">TANGGAL</th>
                            <th rowspan="2">KODE MANIFEST</th>
                            <th rowspan="2">KODE LIMBAH B3</th>
                            <th rowspan="2">JENIS LIMBAH B3</th>
                            <th rowspan="2">BERAT KELUAR</th>
                            <th rowspan="2">BERAT TELAH DIOLAH</th>
                            <th rowspan="2">STATUS</th>
                        </tr>
                        <tr>
                            <th class="border-top-0">ANGKUT</th>
                            <th class="border-top-0">TERIMA</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($dataLimbah as $i => $limbah)
                            @php
                                $transNama   = $limbah->transporter->informasiTransporter->nama_transporter
                                    ?? $limbah->transporter->nama_user
                                    ?? '-';
                                $hasBA       = $limbah->beritaAcara !== null;
                                $sudahDiolah = in_array($limbah->status, ['Terolah', 'Telah Setor PAD']);

                                $badgeClass = match($limbah->status) {
                                    'Terangkut'       => 'bg-info text-dark',
                                    'Diterima'        => 'bg-primary',
                                    'Terolah'         => 'bg-warning text-dark',
                                    'Telah Setor PAD' => 'bg-dark',
                                    default           => 'bg-secondary',
                                };
                            @endphp
                            <tr>
                                <td class="text-center">
                                    <a href="{{ route('penghasil.beritaAcara.show', $limbah->id_limbah) }}"
                                        class="btn btn-sm btn-outline-primary rounded-pill px-3" title="Lihat Detail">
                                        <i class="fas fa-eye me-1"></i> Detail
                                    </a>
                                </td>
                                <td class="text-center text-muted">{{ $dataLimbah->firstItem() + $i }}</td>
                                <td class="fw-medium">{{ $transNama }}</td>
                                <td class="text-center text-nowrap">
                                    {{ $limbah->tgl_rencana?->format('d M Y') ?? '-' }}
                                </td>
                                <td class="text-center text-nowrap">
                                    {{ $limbah->tgl_terangkut?->format('d M Y') ?? '-' }}
                                </td>
                                <td class="text-center fw-bold text-primary font-monospace">
                                    {{ $limbah->no_manifest ?? '-' }}
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-light text-dark border font-monospace">
                                        {{ $limbah->kode_limbah }}
                                    </span>
                                </td>
                                <td>{{ $limbah->jenis_limbah ?? '-' }}</td>
                                <td class="text-center text-nowrap fw-semibold">
                                    {{ $limbah->jumlah_limbah }} {{ $limbah->satuan }}
                                </td>
                                <td class="text-center text-nowrap">
                                    @if ($sudahDiolah)
                                        <span class="fw-semibold text-success">
                                            {{ $limbah->jumlah_limbah }} {{ $limbah->satuan }}
                                        </span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <span class="badge rounded-pill px-3 py-2 {{ $badgeClass }}">
                                        {{ strtoupper($limbah->status) }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="11" class="text-center py-5 text-muted">
                                    <i class="fas fa-folder-open fa-2x mb-2 d-block opacity-50"></i>
                                    Belum ada data berita acara.
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
