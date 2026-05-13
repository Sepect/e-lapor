@extends('layouts.app')

@section('title', 'Form Pembayaran')

@section('content')
    @php
        $transNama = $limbah->transporter->informasiTransporter->nama_transporter
            ?? $limbah->transporter->nama_user
            ?? '-';
        $ba = $limbah->beritaAcara;
    @endphp

    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-2 mb-4">
        <h4 class="fw-bold mb-0 text-dark d-flex align-items-center">
            <div class="bg-success bg-opacity-10 text-success p-2 rounded-circle me-3 d-inline-flex justify-content-center align-items-center"
                style="width: 45px; height: 45px;">
                <i class="fas fa-money-bill-wave"></i>
            </div>
            Form Pembayaran
        </h4>
        <a href="{{ route('penghasil.pembayaran') }}" class="btn btn-light fw-semibold rounded-pill px-4 shadow-sm border">
            <i class="fas fa-arrow-left me-2"></i> Kembali
        </a>
    </div>

    <div class="row g-4">

        {{-- Kolom Kiri: Ringkasan Tagihan --}}
        <div class="col-12 col-lg-4">

            {{-- Info Tagihan --}}
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-header bg-primary text-white rounded-top-4 px-4 py-3 border-0">
                    <h6 class="mb-0 fw-bold">
                        <i class="fas fa-file-invoice-dollar me-2"></i> Ringkasan Tagihan
                    </h6>
                </div>
                <div class="card-body p-4">
                    @if($tagihanRecord)
                        <div class="text-center mb-4">
                            <div class="text-muted small fw-semibold text-uppercase mb-1">Jumlah Tagihan</div>
                            <div class="fw-bold text-success" style="font-size: 1.6rem;">
                                Rp {{ number_format($tagihanRecord->jumlah_tagihan, 0, ',', '.') }}
                            </div>
                            <div class="font-monospace text-muted small mt-1">{{ $tagihanRecord->nomor_tagihan }}</div>
                        </div>

                        <hr class="my-3">

                        <div class="d-flex flex-column gap-2 small">
                            <div class="d-flex justify-content-between">
                                <span class="text-muted">Tanggal Tagihan</span>
                                <span class="fw-medium">{{ $tagihanRecord->tgl_tagihan?->format('d M Y') ?? '-' }}</span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span class="text-muted">Jatuh Tempo</span>
                                <span class="fw-medium {{ $tagihanRecord->tgl_jatuh_tempo?->isPast() ? 'text-danger fw-bold' : '' }}">
                                    {{ $tagihanRecord->tgl_jatuh_tempo?->format('d M Y') ?? '-' }}
                                </span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span class="text-muted">Jenis</span>
                                <span class="fw-medium">{{ $tagihanRecord->jenis_tagihan }}</span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span class="text-muted">Status</span>
                                <span class="badge bg-warning text-dark rounded-pill px-2">Belum Dibayar</span>
                            </div>
                        </div>

                        @if($tagihanRecord->tgl_jatuh_tempo?->isPast())
                            <div class="alert alert-danger rounded-3 small py-2 mt-3 mb-0">
                                <i class="fas fa-exclamation-circle me-1"></i>
                                Tagihan ini telah melewati jatuh tempo.
                            </div>
                        @endif
                    @else
                        <div class="text-center text-muted py-3">
                            <i class="fas fa-info-circle fa-2x mb-2 d-block opacity-50"></i>
                            <small>Nominal tagihan belum ditetapkan oleh admin.</small>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Info Limbah --}}
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-light rounded-top-4 px-4 py-3 border-0">
                    <h6 class="mb-0 fw-bold text-dark">
                        <i class="fas fa-boxes me-2 text-secondary"></i> Detail Limbah
                    </h6>
                </div>
                <div class="card-body p-4">
                    <div class="d-flex flex-column gap-2 small">
                        <div class="d-flex justify-content-between">
                            <span class="text-muted">No. Manifest</span>
                            <span class="fw-bold font-monospace text-primary">{{ $limbah->no_manifest ?? '-' }}</span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span class="text-muted">Kode Limbah</span>
                            <span class="fw-medium font-monospace">{{ $limbah->kode_limbah }}</span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span class="text-muted">Jenis Limbah</span>
                            <span class="fw-medium text-end" style="max-width: 60%;">{{ $limbah->jenis_limbah ?? '-' }}</span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span class="text-muted">Berat</span>
                            <span class="fw-bold">{{ $limbah->jumlah_limbah }} {{ $limbah->satuan }}</span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span class="text-muted">Transporter</span>
                            <span class="fw-medium text-end" style="max-width: 60%;">{{ $transNama }}</span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span class="text-muted">Tgl Diolah</span>
                            <span class="fw-medium">{{ $limbah->tgl_terolah?->format('d M Y') ?? '-' }}</span>
                        </div>
                        @if($ba)
                            <div class="d-flex justify-content-between">
                                <span class="text-muted">BA Penerimaan</span>
                                <span class="fw-medium font-monospace text-uppercase small">
                                    {{ strtoupper(substr($ba->id_berita_acara, 0, 8)) }}
                                </span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

        </div>

        {{-- Kolom Kanan: Form Pembayaran --}}
        <div class="col-12 col-lg-8">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-white rounded-top-4 px-4 pt-4 pb-0 border-0">
                    <h5 class="fw-bold text-dark mb-0">
                        <i class="fas fa-credit-card me-2 text-success"></i> Informasi Pembayaran
                    </h5>
                    <p class="text-muted small mt-1 mb-3">Lengkapi data pembayaran dan unggah bukti transfer.</p>
                    <hr class="mt-0">
                </div>
                <div class="card-body px-4 pb-4 pt-2">

                    <form action="{{ route('penghasil.pembayaran.setor', $limbah->id_limbah) }}"
                        method="POST" enctype="multipart/form-data">
                        @csrf

                        {{-- Metode Pembayaran --}}
                        <div class="mb-4">
                            <label class="form-label fw-bold">
                                Metode Pembayaran <span class="text-danger">*</span>
                            </label>
                            <div class="row g-3">
                                @foreach(['Transfer Bank', 'Virtual Account', 'Tunai', 'Lainnya'] as $metode)
                                    <div class="col-6 col-md-3">
                                        <input type="radio" class="btn-check" name="metode_pembayaran"
                                            id="metode_{{ Str::slug($metode) }}"
                                            value="{{ $metode }}"
                                            {{ old('metode_pembayaran') === $metode ? 'checked' : '' }}
                                            required>
                                        <label class="btn btn-outline-secondary w-100 rounded-3 py-3 d-flex flex-column align-items-center gap-2"
                                            for="metode_{{ Str::slug($metode) }}">
                                            @if($metode === 'Transfer Bank')
                                                <i class="fas fa-university fa-lg"></i>
                                            @elseif($metode === 'Virtual Account')
                                                <i class="fas fa-mobile-alt fa-lg"></i>
                                            @elseif($metode === 'Tunai')
                                                <i class="fas fa-money-bill-wave fa-lg"></i>
                                            @else
                                                <i class="fas fa-ellipsis-h fa-lg"></i>
                                            @endif
                                            <span class="small fw-semibold">{{ $metode }}</span>
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                            @error('metode_pembayaran')
                                <div class="text-danger small mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Info Rekening (shown dynamically) --}}
                        <div id="infoRekening" class="bg-info bg-opacity-10 border border-info rounded-3 p-3 mb-4 d-none">
                            <div class="fw-bold text-info small mb-2">
                                <i class="fas fa-info-circle me-1"></i> Informasi Rekening Tujuan
                            </div>
                            <div class="d-flex flex-column gap-1 small" id="rekeningDetail">
                                <div class="d-flex gap-3">
                                    <span class="text-muted" style="width: 120px;">Bank</span>
                                    <span class="fw-bold">Bank Sulselbar</span>
                                </div>
                                <div class="d-flex gap-3">
                                    <span class="text-muted" style="width: 120px;">No. Rekening</span>
                                    <span class="fw-bold font-monospace">0101-01-000001-1</span>
                                </div>
                                <div class="d-flex gap-3">
                                    <span class="text-muted" style="width: 120px;">Atas Nama</span>
                                    <span class="fw-bold">UPT PLB3 Prov. Sulsel</span>
                                </div>
                                <div class="d-flex gap-3">
                                    <span class="text-muted" style="width: 120px;">Keterangan</span>
                                    <span class="fw-semibold">{{ $tagihanRecord?->nomor_tagihan ?? 'Setor Biaya Pengolahan' }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="row g-3 mb-3">
                            {{-- Nomor Referensi --}}
                            <div class="col-12 col-md-6">
                                <label for="no_referensi" class="form-label fw-bold">
                                    Nomor Referensi / Bukti Transfer <span class="text-danger">*</span>
                                </label>
                                <input type="text"
                                    class="form-control @error('no_referensi') is-invalid @enderror"
                                    id="no_referensi" name="no_referensi"
                                    value="{{ old('no_referensi') }}"
                                    placeholder="Contoh: TRF20260512001">
                                <div class="form-text text-muted">Nomor unik dari bukti transfer/kuitansi.</div>
                                @error('no_referensi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Tanggal Bayar --}}
                            <div class="col-12 col-md-6">
                                <label for="tgl_bayar" class="form-label fw-bold">
                                    Tanggal Pembayaran <span class="text-danger">*</span>
                                </label>
                                <input type="date"
                                    class="form-control @error('tgl_bayar') is-invalid @enderror"
                                    id="tgl_bayar" name="tgl_bayar"
                                    value="{{ old('tgl_bayar', now()->format('Y-m-d')) }}"
                                    max="{{ now()->format('Y-m-d') }}">
                                @error('tgl_bayar')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Upload Bukti --}}
                        <div class="mb-3">
                            <label for="bukti_pembayaran" class="form-label fw-bold">
                                Bukti Pembayaran <span class="text-danger">*</span>
                            </label>
                            <div class="border rounded-3 p-4 text-center bg-light position-relative" id="dropZone">
                                <input type="file"
                                    class="position-absolute top-0 start-0 w-100 h-100 opacity-0"
                                    style="cursor: pointer; z-index: 2;"
                                    id="bukti_pembayaran" name="bukti_pembayaran"
                                    accept=".jpg,.jpeg,.png,.pdf"
                                    onchange="previewFile(this)">
                                <div id="uploadPlaceholder">
                                    <i class="fas fa-cloud-upload-alt fa-2x text-muted mb-2"></i>
                                    <div class="fw-semibold text-muted">Klik atau seret file ke sini</div>
                                    <div class="small text-muted mt-1">JPG, PNG, atau PDF &bull; Maks. 2MB</div>
                                </div>
                                <div id="uploadPreview" class="d-none">
                                    <i class="fas fa-file-check fa-2x text-success mb-2"></i>
                                    <div class="fw-semibold text-success" id="uploadFileName">-</div>
                                    <div class="small text-muted" id="uploadFileSize">-</div>
                                </div>
                            </div>
                            @error('bukti_pembayaran')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Catatan --}}
                        <div class="mb-4">
                            <label for="catatan_pembayaran" class="form-label fw-bold">
                                Catatan <span class="text-muted fw-normal small">(opsional)</span>
                            </label>
                            <textarea class="form-control @error('catatan_pembayaran') is-invalid @enderror"
                                id="catatan_pembayaran" name="catatan_pembayaran"
                                rows="3" maxlength="500"
                                placeholder="Tambahkan catatan jika diperlukan...">{{ old('catatan_pembayaran') }}</textarea>
                            @error('catatan_pembayaran')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="alert alert-warning rounded-3 small py-2 mb-4">
                            <i class="fas fa-exclamation-triangle me-1"></i>
                            Pastikan data yang diisi sesuai. Status akan berubah menjadi
                            <strong>Telah Setor PAD</strong> dan tidak dapat dibatalkan setelah dikirim.
                        </div>

                        <div class="d-flex gap-3 justify-content-end">
                            <a href="{{ route('penghasil.pembayaran') }}"
                                class="btn btn-light border rounded-pill px-4 fw-semibold">
                                Batal
                            </a>
                            <button type="submit" class="btn btn-success fw-bold rounded-pill px-5 shadow-sm">
                                <i class="fas fa-paper-plane me-2"></i> Kirim Pembayaran
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>

    </div>

    <script>
        // Show bank info for bank transfer and virtual account methods
        const radioButtons = document.querySelectorAll('input[name="metode_pembayaran"]');
        const infoRekening = document.getElementById('infoRekening');

        radioButtons.forEach(radio => {
            radio.addEventListener('change', () => {
                infoRekening.classList.toggle('d-none', !['Transfer Bank', 'Virtual Account'].includes(radio.value));
            });
        });

        // File upload preview
        function previewFile(input) {
            const placeholder = document.getElementById('uploadPlaceholder');
            const preview = document.getElementById('uploadPreview');
            const fileName = document.getElementById('uploadFileName');
            const fileSize = document.getElementById('uploadFileSize');

            if (input.files && input.files[0]) {
                const file = input.files[0];
                const sizeKB = (file.size / 1024).toFixed(1);
                placeholder.classList.add('d-none');
                preview.classList.remove('d-none');
                fileName.textContent = file.name;
                fileSize.textContent = sizeKB + ' KB';
            }
        }
    </script>
@endsection
