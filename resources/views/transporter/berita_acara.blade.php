@extends('layouts.app')

@section('title', 'BA Penerimaan Limbah B3')

@section('content')
    <div class="container-fluid py-3 px-0">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold mb-0 text-uppercase text-dark">BA Penerimaan Limbah B3</h4>
            <a href="{{ route('transporter.dashboard') }}" class="btn btn-outline-dark btn-sm">
                <i class="fas fa-arrow-left me-1"></i> Kembali
            </a>
        </div>
        <div class="card shadow-sm border-0 p-3">
            <form action="{{ route('transporter.beritaAcara') }}" method="GET" class="mb-4">
                <div class="row g-3 align-items-center">
                    <div class="col-12 col-md-4">
                        <input type="text" class="form-control rounded-0 py-2 fw-bold"
                               name="manifest" value="{{ request('manifest') }}"
                               placeholder="Masukkan Kode Manifest">
                    </div>

                    <div class="col-12 col-md-3">
                        <select class="form-select rounded-0 py-2 fw-bold" name="status">
                            <option value="">-- Semua Status --</option>
                            <option value="Terangkut" @selected(request('status') === 'Terangkut')>Dikirim</option>
                            <option value="Diterima" @selected(request('status') === 'Diterima')>Diterima</option>
                            <option value="Terolah" @selected(request('status') === 'Terolah')>Diolah</option>
                            <option value="Selesai" @selected(request('status') === 'Selesai')>Selesai</option>
                        </select>
                    </div>

                    <div class="col-12 col-md-3">
                        <input type="text" class="form-control rounded-0 py-2 fw-bold"
                               name="penghasil" value="{{ request('penghasil') }}"
                               placeholder="Nama Penghasil">
                    </div>

                    <div class="col-12 col-md-2 d-flex gap-2">
                        <button type="submit" class="btn btn-primary rounded-0 px-3" title="Cari">
                            <i class="fas fa-search fs-5"></i>
                        </button>
                        <a href="{{ route('transporter.beritaAcara') }}" class="btn btn-light rounded-0 px-3" title="Reset">
                            <i class="fas fa-undo fs-5"></i>
                        </a>
                    </div>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table table-bordered table-striped align-middle text-center mb-0">
                    <thead class="align-middle fw-bold text-uppercase">
                    <tr>
                        <th rowspan="2" class="bg-white" style="width: 60px;">#</th>
                        <th rowspan="2" class="bg-white" style="width: 50px;">NO</th>
                        <th rowspan="2" class="bg-white">PENGHASIL</th>
                        <th colspan="2" class="bg-white">TANGGAL</th>
                        <th rowspan="2" class="bg-white">KODE<br>MANIFEST</th>
                        <th rowspan="2" class="bg-white">KODE<br>LIMBAH B3</th>
                        <th rowspan="2" class="bg-white">JENIS<br>LIMBAH B3</th>
                        <th rowspan="2" class="bg-white">BERAT<br>DIKIRIM</th>
                        <th rowspan="2" class="bg-white">BERAT<br>DITERIMA</th>
                        <th rowspan="2" class="bg-white">STATUS</th>
                    </tr>
                    <tr>
                        <th class="bg-white">ANGKUT</th>
                        <th class="bg-white">TERIMA</th>
                    </tr>
                    </thead>
                    <tbody class="bg-white">
                        @forelse($dataBA as $index => $ba)
                        <tr>
                            <td class="text-center p-2">
                                <button class="btn btn-outline-dark rounded-0 px-2 py-1" title="Cetak Berita Acara">
                                    <i class="fas fa-print fs-5"></i>
                                </button>
                            </td>
                            <td>{{ $loop->iteration + ($dataBA->currentPage() - 1) * $dataBA->perPage() }}</td>
                            <td class="text-start px-3">{{ $ba->limbah->penghasil->informasiPenghasil->nama_penghasil ?? 'N/A' }}</td>
                            <td>{{ $ba->limbah->tgl_rencana ? $ba->limbah->tgl_rencana->format('d M Y') : '-' }}</td>
                            <td>{{ $ba->created_at ? $ba->created_at->format('d M Y') : '-' }}</td>
                            <td class="fw-bold">{{ $ba->limbah->no_manifest ?? '-' }}</td>
                            <td>{{ $ba->limbah->kode_limbah ?? '-' }}</td>
                            <td>-</td>
                            <td>{{ $ba->limbah->jumlah_limbah ?? '-' }} {{ $ba->limbah->satuan ?? '' }}</td>
                            <td>{{ $ba->limbah->jumlah_limbah ?? '-' }} {{ $ba->limbah->satuan ?? '' }}</td>
                            <td>
                                @if($ba->limbah->status == 'Terangkut' || $ba->limbah->status == 'Terkirim')
                                    <span class="badge bg-warning text-dark rounded-0 px-3 py-2 w-100">DIKIRIM</span>
                                @else
                                    <span class="badge bg-success rounded-0 px-3 py-2 w-100">{{ strtoupper($ba->limbah->status ?? 'DITERIMA') }}</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="11" class="text-center py-4 text-muted">Belum ada data Berita Acara.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-end mt-3 pagination-rounded">
                {{ $dataBA->withQueryString()->links('pagination::bootstrap-5') }}
            </div>
        </div>

    </div>
@endsection
