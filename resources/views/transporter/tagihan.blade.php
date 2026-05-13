@extends('layouts.app')

@section('title', 'Surat Tagihan')

@section('content')
    <div class="container-fluid py-3 px-0">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold mb-0 text-uppercase text-dark">SURAT TAGIHAN</h4>
            <a href="#" class="btn btn-outline-dark btn-sm">
                <i class="fas fa-arrow-left me-1"></i> KEMBALI
            </a>
        </div>
        <div class="card shadow-sm border-0 p-3">
            <form action="" method="GET" class="mb-4">
                <div class="row g-3 align-items-center">
                    <div class="col-12 col-md-4">
                        <input type="text" class="form-control  rounded-0 py-2 fw-bold"
                               placeholder="Masukkan Kode Manifest">
                    </div>

                    <div class="col-12 col-md-3">
                        <select class="form-select  rounded-0 py-2 fw-bold">
                            <option selected>Status</option>
                            <option value="Diterima">Diterima</option>
                            <option value="Dikirim">Dikirim</option>
                        </select>
                    </div>

                    <div class="col-12 col-md-3">
                        <input type="text" class="form-control  rounded-0 py-2 fw-bold" placeholder="Penghasil">
                    </div>

                    <div class="col-12 col-md-2 d-flex gap-2">
                        <button type="submit" class="btn btn-light  rounded-0 px-3" title="Refresh">
                            <i class="fas fa-redo-alt fs-5"></i>
                        </button>
                        <button type="reset" class="btn btn-light  rounded-0 px-3" title="Sync/Reset">
                            <i class="fas fa-sync fs-5"></i>
                        </button>
                    </div>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table table-bordered table-striped align-middle text-center mb-0">
                    <tr>
                        <th class="bg-white" style="width: 60px;">#</th>
                        <th class="bg-white" style="width: 50px;">NO</th>
                        <th class="bg-white">PERIODE</th>
                        <th class="bg-white">TOTAL BERAT</th>
                        <th class="bg-white">TOTAL TAGIHAN</th>
                        <th class="bg-white">TGL TERBIT</th>
                        <th class="bg-white">JATUH TEMPO</th>
                        <th class="bg-white">STATUS</th>
                    </tr>
                    </thead>
                    <tbody class="bg-white">
                        @forelse($tagihan as $index => $item)
                        <tr>
                            <td class="text-center p-2">
                                <button class="btn btn-outline-dark rounded-0 px-2 py-1" title="Lihat Tagihan">
                                    <i class="fas fa-eye fs-5"></i>
                                </button>
                            </td>
                            <td>{{ $loop->iteration + ($tagihan->currentPage() - 1) * $tagihan->perPage() }}</td>
                            <td class="text-start px-3">{{ $item->periode ?? '-' }}</td>
                            <td>{{ $item->total_berat ?? 0 }} Kg</td>
                            <td>Rp {{ number_format($item->total_tagihan ?? 0, 0, ',', '.') }}</td>
                            <td>{{ $item->tgl_terbit ? $item->tgl_terbit->format('d M Y') : '-' }}</td>
                            <td>{{ $item->tgl_jatuh_tempo ? $item->tgl_jatuh_tempo->format('d M Y') : '-' }}</td>
                            <td>
                                @if($item->status == 'Lunas')
                                    <span class="badge bg-success rounded-0 px-3 py-2 w-100">LUNAS</span>
                                @elseif($item->status == 'Proses')
                                    <span class="badge bg-warning text-dark rounded-0 px-3 py-2 w-100">PROSES</span>
                                @else
                                    <span class="badge bg-danger rounded-0 px-3 py-2 w-100">{{ strtoupper($item->status ?? 'BELUM BAYAR') }}</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-4 text-muted">Belum ada data Tagihan.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-end mt-3 pagination-rounded">
                {{ $tagihan->withQueryString()->links('pagination::bootstrap-5') }}
            </div>
        </div>

    </div>
@endsection
