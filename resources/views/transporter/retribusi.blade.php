@extends('layouts.app')

@section('title', 'Setor RETRIBUSI')

@section('content')
    <div class="container-fluid py-3 px-0">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold mb-0 text-uppercase text-dark">SETOR RETRIBUSI</h4>
        </div>

        @if (session('success'))
            <div class="alert alert-success rounded-3">{{ session('success') }}</div>
        @endif

        <div class="card shadow-sm border-0 p-3">
            <div class="table-responsive">
                <table class="table table-bordered table-striped align-middle text-center mb-0">
                    <thead class="align-middle fw-bold text-uppercase">
                    <tr>
                        <th rowspan="2" class="bg-white align-middle" style="width: 90px;">AKSI</th>
                        <th rowspan="2" class="bg-white align-middle" style="width: 50px;">NO</th>
                        <th rowspan="2" class="bg-white align-middle">PENGHASIL</th>
                        <th rowspan="2" class="bg-white align-middle">KODE<br>MANIFEST</th>
                        <th colspan="2" class="bg-white align-middle">SURAT TAGIHAN</th>
                        <th rowspan="2" class="bg-white align-middle">BERAT<br>LIMBAH<br>B3 (TON)</th>
                        <th rowspan="2" class="bg-white align-middle">JUMLAH<br>RETRIBUSI<br>(RUPIAH)</th>
                        <th rowspan="2" class="bg-white align-middle">STATUS</th>
                    </tr>
                    <tr>
                        <th class="bg-white align-middle">NOMOR</th>
                        <th class="bg-white align-middle">TANGGAL</th>
                    </tr>
                    </thead>
                    <tbody class="bg-white">
                        @forelse($retribusi as $item)
                        @php
                            $limbah = $item->limbah;
                            $lunas = $item->status_pembayaran === 'Lunas';
                        @endphp
                        <tr>
                            <td class="text-center p-2">
                                @if($lunas)
                                    <button class="btn btn-outline-secondary rounded-0 px-2 py-1 fw-bold lh-sm w-100 disabled"
                                            style="font-size: 0.75rem;">SETOR<br>RETRIBUSI</button>
                                @else
                                    <a href="{{ route('transporter.tagihan.setor.form', $item->id_tagihan) }}"
                                       class="btn btn-dark rounded-0 px-2 py-1 fw-bold lh-sm w-100"
                                       style="font-size: 0.75rem;">SETOR<br>RETRIBUSI</a>
                                @endif
                            </td>
                            <td>{{ $loop->iteration + ($retribusi->currentPage() - 1) * $retribusi->perPage() }}</td>
                            <td class="text-start px-2">{{ $limbah?->penghasil?->informasiPenghasil?->nama_penghasil ?? $limbah?->penghasil?->nama_user ?? '-' }}</td>
                            <td class="fw-bold">{{ $limbah?->no_manifest ?? '-' }}</td>
                            <td class="font-monospace">{{ $item->nomor_tagihan }}</td>
                            <td>{{ $item->tgl_tagihan?->format('d/m/Y') ?? '-' }}</td>
                            <td>{{ $limbah?->jumlah_limbah ?? 0 }}</td>
                            <td class="text-end px-2 fw-bold">Rp {{ number_format($item->jumlah_tagihan, 0, ',', '.') }}</td>
                            <td>
                                @if($lunas)
                                    <span class="badge bg-success rounded-0 px-2 py-2 w-100 text-wrap text-uppercase">TELAH SETOR</span>
                                @else
                                    <span class="badge bg-danger rounded-0 px-2 py-2 w-100 text-wrap text-uppercase">BELUM SETOR</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="text-center py-4 text-muted">Belum ada tagihan Retribusi.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-end mt-3 pagination-rounded">
                {{ $retribusi->withQueryString()->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
@endsection
