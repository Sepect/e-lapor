@extends('layouts.app')

@section('title', 'Setor PAD')

@section('content')
    <div class="container-fluid py-3 px-0">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold mb-0 text-uppercase text-dark">SETOR PAD</h4>
            <a href="#" class="btn btn-outline-dark btn-sm">
                <i class="fas fa-arrow-left me-1"></i> KEMBALI
            </a>
        </div>
        <div class="card shadow-sm border-0 p-3">
            <form action="" method="GET" class="mb-4">
                <div class="row g-3 align-items-center">
                    <div class="col-12 col-md-4">
                        <input type="text" class="form-control rounded-0 py-2 fw-bold"
                               placeholder="Masukkan Kode Manifest">
                    </div>

                    <div class="col-12 col-md-3">
                        <select class="form-select rounded-0 py-2 fw-bold">
                            <option selected>Status</option>
                            <option value="Telah Setor">Telah Setor</option>
                            <option value="Belum Setor">Belum Setor</option>
                        </select>
                    </div>

                    <div class="col-12 col-md-3">
                        <input type="text" class="form-control rounded-0 py-2 fw-bold" placeholder="Penghasil">
                    </div>

                    <div class="col-12 col-md-2 d-flex gap-2">
                        <button type="submit" class="btn btn-light rounded-0 px-3" title="Refresh">
                            <i class="fas fa-redo-alt fs-5 text-dark"></i>
                        </button>
                        <button type="reset" class="btn btn-light rounded-0 px-3" title="Sync/Reset">
                            <i class="fas fa-sync fs-5 text-dark"></i>
                        </button>
                    </div>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table table-bordered table-striped align-middle text-center mb-0">
                    <thead class="align-middle fw-bold text-uppercase">
                    <tr>
                        <th rowspan="2" class="bg-white align-middle" style="width: 80px;">#</th>
                        <th rowspan="2" class="bg-white align-middle" style="width: 50px;">NO</th>
                        <th rowspan="2" class="bg-white align-middle">PENGHASIL</th>
                        <th rowspan="2" class="bg-white align-middle">KODE<br>MANIFEST</th>
                        <th colspan="2" class="bg-white align-middle">BA PENERIMAAN<br>LIMBAH B3</th>
                        <th colspan="2" class="bg-white align-middle">SURAT TAGIHAN</th>
                        <th rowspan="2" class="bg-white align-middle">BERAT<br>LIMBAH<br>B3(TON)</th>
                        <th rowspan="2" class="bg-white align-middle">JUMLAH<br>TAGIHAN<br>PAD<br>(RUPIAH)</th>
                        <th rowspan="2" class="bg-white align-middle">STATUS</th>
                    </tr>
                    <tr>
                        <th class="bg-white align-middle">NOMOR</th>
                        <th class="bg-white align-middle">TANGGAL</th>
                        <th class="bg-white align-middle">NOMOR</th>
                        <th class="bg-white align-middle">TANGGAL</th>
                    </tr>
                    </thead>
                    <tbody class="bg-white">
                        @forelse($pad as $index => $item)
                        <tr>
                            <td class="text-center p-2">
                                @if($item->status == 'Telah Setor PAD')
                                    <button class="btn btn-outline-dark rounded-0 px-2 py-1 fw-bold lh-sm w-100 disabled"
                                            style="font-size: 0.75rem;">
                                        SETOR<br>PAD
                                    </button>
                                @else
                                    <a href="#" class="btn btn-dark rounded-0 px-2 py-1 fw-bold lh-sm w-100"
                                       style="font-size: 0.75rem;">
                                        SETOR<br>PAD
                                    </a>
                                @endif
                            </td>
                            <td>{{ $loop->iteration + ($pad->currentPage() - 1) * $pad->perPage() }}</td>
                            <td class="text-start px-2">{{ $item->penghasil->informasiPenghasil->nama_penghasil ?? 'N/A' }}</td>
                            <td class="fw-bold">{{ $item->no_manifest ?? '-' }}</td>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                            <td>{{ $item->jumlah_limbah ?? 0 }}</td>
                            <td class="text-end px-2 fw-bold">-</td>
                            <td>
                                @if($item->status == 'Telah Setor PAD')
                                    <span class="badge bg-success rounded-0 px-2 py-2 w-100 text-wrap text-uppercase">
                                        TELAH SETOR PAD
                                    </span>
                                @else
                                    <span class="badge bg-danger rounded-0 px-2 py-2 w-100 text-wrap text-uppercase">
                                        BELUM SETOR PAD
                                    </span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="11" class="text-center py-4 text-muted">Belum ada data PAD.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-end mt-3 pagination-rounded">
                {{ $pad->withQueryString()->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
@endsection
