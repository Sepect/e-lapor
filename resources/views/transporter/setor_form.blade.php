@extends('layouts.app')

@section('title', 'Setor '.$tagihan->jenis_tagihan)

@section('content')
    @php
        $limbah = $tagihan->limbah;
        $penghasilNama = $limbah?->penghasil?->informasiPenghasil?->nama_penghasil
            ?? $limbah?->penghasil?->nama_user
            ?? '-';
        $backRoute = $tagihan->jenis_tagihan === 'PAD' ? 'transporter.pad' : 'transporter.retribusi';
    @endphp

    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-2 mb-4">
        <h4 class="fw-bold mb-0 text-dark d-flex align-items-center">
            <div class="bg-success bg-opacity-10 text-success p-2 rounded-circle me-3 d-inline-flex justify-content-center align-items-center"
                style="width: 45px; height: 45px;">
                <i class="fas fa-money-bill-wave"></i>
            </div>
            Setor {{ $tagihan->jenis_tagihan }}
        </h4>
        <a href="{{ route($backRoute) }}" class="btn btn-light fw-semibold rounded-pill px-4 shadow-sm border">
            <i class="fas fa-arrow-left me-2"></i> Kembali
        </a>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger rounded-3 mb-4">
            <ul class="mb-0 ps-3">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="row g-4">

        {{-- Kolom Kiri: Ringkasan --}}
        <div class="col-12 col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-header bg-primary text-white rounded-top-4 px-4 py-3 border-0">
                    <h6 class="mb-0 fw-bold"><i class="fas fa-file-invoice-dollar me-2"></i> Ringkasan Setoran</h6>
                </div>
                <div class="card-body p-4">
                    <div class="text-center mb-4">
                        <div class="text-muted small fw-semibold text-uppercase mb-1">Jumlah {{ $tagihan->jenis_tagihan }}</div>
                        <div class="fw-bold text-success" style="font-size: 1.6rem;">
                            Rp {{ number_format($tagihan->jumlah_tagihan, 0, ',', '.') }}
                        </div>
                        <div class="font-monospace text-muted small mt-1">{{ $tagihan->nomor_tagihan }}</div>
                    </div>
                    <hr class="my-3">
                    <div class="d-flex flex-column gap-2 small">
                        <div class="d-flex justify-content-between">
                            <span class="text-muted">Penghasil</span>
                            <span class="fw-medium text-end" style="max-width: 60%;">{{ $penghasilNama }}</span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span class="text-muted">Berat Limbah</span>
                            <span class="fw-bold">{{ $limbah?->jumlah_limbah }} {{ $limbah?->satuan }}</span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span class="text-muted">Jatuh Tempo</span>
                            <span class="fw-medium {{ $tagihan->tgl_jatuh_tempo?->isPast() ? 'text-danger fw-bold' : '' }}">
                                {{ $tagihan->tgl_jatuh_tempo?->format('d M Y') ?? '-' }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-light rounded-top-4 px-4 py-3 border-0">
                    <h6 class="mb-0 fw-bold text-dark"><i class="fas fa-university me-2 text-secondary"></i> Rekening Tujuan (UPT)</h6>
                </div>
                <div class="card-body p-4 small">
                    <div class="d-flex flex-column gap-2">
                        <div class="d-flex gap-3"><span class="text-muted" style="width:110px;">Bank</span><span class="fw-bold">{{ $instansi['bank_nama'] }}</span></div>
                        <div class="d-flex gap-3"><span class="text-muted" style="width:110px;">No. Rekening</span><span class="fw-bold font-monospace">{{ $instansi['bank_rekening'] }}</span></div>
                        <div class="d-flex gap-3"><span class="text-muted" style="width:110px;">Atas Nama</span><span class="fw-bold">{{ $instansi['bank_atas_nama'] }}</span></div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Kolom Kanan: Form --}}
        <div class="col-12 col-lg-8">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-white rounded-top-4 px-4 pt-4 pb-0 border-0">
                    <h5 class="fw-bold text-dark mb-0"><i class="fas fa-credit-card me-2 text-success"></i> Bukti Setoran {{ $tagihan->jenis_tagihan }}</h5>
                    <p class="text-muted small mt-1 mb-3">Lengkapi data setoran dan unggah bukti transfer ke rekening UPT.</p>
                    <hr class="mt-0">
                </div>
                <div class="card-body px-4 pb-4 pt-2">
                    <form action="{{ route('transporter.tagihan.setor', $tagihan->id_tagihan) }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-4">
                            <label class="form-label fw-bold">Metode Pembayaran <span class="text-danger">*</span></label>
                            <div class="row g-3">
                                @foreach (['Transfer Bank', 'Virtual Account', 'Tunai', 'Lainnya'] as $metode)
                                    <div class="col-6 col-md-3">
                                        <input type="radio" class="btn-check" name="metode_pembayaran"
                                            id="metode_{{ Str::slug($metode) }}" value="{{ $metode }}"
                                            {{ old('metode_pembayaran', 'Transfer Bank') === $metode ? 'checked' : '' }} required>
                                        <label class="btn btn-outline-secondary w-100 rounded-3 py-3 d-flex flex-column align-items-center gap-2"
                                            for="metode_{{ Str::slug($metode) }}">
                                            <i class="fas fa-university fa-lg"></i>
                                            <span class="small fw-semibold">{{ $metode }}</span>
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-12 col-md-6">
                                <label for="no_referensi" class="form-label fw-bold">Nomor Bukti Setor <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="no_referensi" name="no_referensi"
                                    value="{{ old('no_referensi') }}" placeholder="Contoh: TRF20260629001">
                            </div>
                            <div class="col-12 col-md-6">
                                <label for="tgl_bayar" class="form-label fw-bold">Tanggal Setor <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="tgl_bayar" name="tgl_bayar"
                                    value="{{ old('tgl_bayar', now()->format('Y-m-d')) }}" max="{{ now()->format('Y-m-d') }}">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="bukti_pembayaran" class="form-label fw-bold">Upload Bukti Setor <span class="text-danger">*</span></label>
                            <input type="file" class="form-control" id="bukti_pembayaran" name="bukti_pembayaran" accept=".jpg,.jpeg,.png,.pdf">
                            <div class="form-text text-muted">JPG, PNG, atau PDF &bull; Maks. 2MB</div>
                        </div>

                        <div class="mb-4">
                            <label for="catatan_pembayaran" class="form-label fw-bold">Catatan <span class="text-muted fw-normal small">(opsional)</span></label>
                            <textarea class="form-control" id="catatan_pembayaran" name="catatan_pembayaran" rows="3" maxlength="500"
                                placeholder="Tambahkan catatan jika diperlukan...">{{ old('catatan_pembayaran') }}</textarea>
                        </div>

                        <div class="alert alert-warning rounded-3 small py-2 mb-4">
                            <i class="fas fa-exclamation-triangle me-1"></i>
                            Pastikan data sesuai. Status setoran {{ $tagihan->jenis_tagihan }} akan menjadi
                            <strong>Lunas</strong> setelah dikirim.
                        </div>

                        <div class="d-flex gap-3 justify-content-end">
                            <a href="{{ route($backRoute) }}" class="btn btn-light border rounded-pill px-4 fw-semibold">Batal</a>
                            <button type="submit" class="btn btn-success fw-bold rounded-pill px-5 shadow-sm">
                                <i class="fas fa-paper-plane me-2"></i> Kirim Setoran
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
@endsection
