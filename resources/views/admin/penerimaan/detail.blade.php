@extends('layouts.app')

@section('title', 'Verifikasi Penerimaan Limbah')
@section('subtitle', 'Verifikasi Penerimaan Limbah')

@section('content')
    @php
        $info         = $limbah->penghasil->informasiPenghasil ?? null;
        $transInfo    = $limbah->transporter->informasiTransporter ?? null;
        $ba           = $limbah->beritaAcara;
    @endphp

    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-2 mb-4">
        <h4 class="fw-bold mb-0 text-dark d-flex align-items-center">
            <div class="bg-primary bg-opacity-10 text-primary p-2 rounded-circle me-3 d-inline-flex justify-content-center align-items-center" style="width: 45px; height: 45px;">
                <i class="fas fa-truck-loading"></i>
            </div>
            Verifikasi Penerimaan Limbah B3
        </h4>
        <a href="{{ route('admin.penerimaan.index', 'terkirim') }}" class="btn btn-light fw-semibold rounded-pill px-4 shadow-sm border">
            <i class="fas fa-arrow-left me-2"></i> Kembali
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-4 shadow-sm mb-4" role="alert">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Data Limbah --}}
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
        <div class="card-header bg-white border-bottom p-4">
            <h6 class="mb-0 fw-bold d-flex align-items-center text-dark">
                <i class="fas fa-info-circle me-2 text-primary fs-5"></i> Detail Data Limbah
            </h6>
        </div>
        <div class="card-body p-4">
            <div class="row g-5">
                {{-- Kolom Kiri --}}
                <div class="col-12 col-lg-6">
                    <div class="mb-3 row g-2 align-items-center">
                        <label class="col-sm-4 col-form-label text-muted fw-medium small">NOMOR MANIFEST</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control bg-light border-0 fw-semibold font-monospace text-primary"
                                value="{{ $limbah->no_manifest ?? '-' }}" readonly>
                        </div>
                    </div>
                    <div class="mb-3 row g-2 align-items-center">
                        <label class="col-sm-4 col-form-label text-muted fw-medium small">NAMA PENGIRIM</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control bg-light border-0 fw-semibold text-dark"
                                value="{{ $info->nama_penghasil ?? $limbah->penghasil->nama_user ?? '-' }}" readonly>
                        </div>
                    </div>
                    <div class="mb-3 row g-2 align-items-center">
                        <label class="col-sm-4 col-form-label text-muted fw-medium small">ALAMAT PENGIRIM</label>
                        <div class="col-sm-8">
                            <textarea class="form-control bg-light border-0 fw-semibold text-dark" rows="2" readonly>{{ $info->alamat_penghasil ?? '-' }}</textarea>
                        </div>
                    </div>
                    <div class="mb-3 row g-2 align-items-center">
                        <label class="col-sm-4 col-form-label text-muted fw-medium small">NAMA TRANSPORTER</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control bg-light border-0 fw-semibold text-dark"
                                value="{{ $transInfo->nama_transporter ?? $limbah->transporter->nama_user ?? '-' }}" readonly>
                        </div>
                    </div>
                    <div class="mb-3 row g-2 align-items-center">
                        <label class="col-sm-4 col-form-label text-muted fw-medium small">ALAMAT TRANSPORTER</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control bg-light border-0 fw-semibold text-dark"
                                value="{{ $transInfo->alamat_transporter ?? '-' }}" readonly>
                        </div>
                    </div>
                    <div class="mb-3 row g-2 align-items-center">
                        <label class="col-sm-4 col-form-label text-muted fw-medium small">NOMOR TELEPON</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control bg-light border-0 fw-semibold text-dark"
                                value="{{ $transInfo->telepon_transporter ?? '-' }}" readonly>
                        </div>
                    </div>
                    <div class="mb-3 row g-2 align-items-center">
                        <label class="col-sm-4 col-form-label text-muted fw-medium small">NAMA DRIVER</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control bg-light border-0 fw-semibold text-dark"
                                value="{{ $limbah->nama_driver ?? '-' }}" readonly>
                        </div>
                    </div>
                    <div class="row g-2 align-items-center">
                        <label class="col-sm-4 col-form-label text-muted fw-medium small">NOMOR KENDARAAN</label>
                        <div class="col-sm-8">
                            <div class="d-inline-block bg-dark text-white fw-bold px-3 py-1 rounded font-monospace">
                                {{ $limbah->no_kendaraan ?? '-' }}
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Kolom Kanan --}}
                <div class="col-12 col-lg-6">
                    <div class="mb-3 row g-2 align-items-center">
                        <label class="col-sm-4 col-form-label text-muted fw-medium small">KODE LIMBAH</label>
                        <div class="col-sm-8">
                            <div class="d-inline-block bg-secondary bg-opacity-10 border border-secondary text-secondary fw-bold px-3 py-1 rounded font-monospace">
                                {{ $limbah->kode_limbah }}
                            </div>
                        </div>
                    </div>
                    <div class="mb-3 row g-2 align-items-center">
                        <label class="col-sm-4 col-form-label text-muted fw-medium small">JENIS LIMBAH</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control bg-light border-0 fw-semibold text-dark"
                                value="{{ $limbah->jenis_limbah ?? '-' }}" readonly>
                        </div>
                    </div>
                    <div class="mb-3 row g-2 align-items-center">
                        <label class="col-sm-4 col-form-label text-muted fw-medium small">TANGGAL ANGKUT</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control bg-light border-0 fw-semibold text-dark"
                                value="{{ $limbah->tgl_rencana?->format('d M Y') ?? '-' }}" readonly>
                        </div>
                    </div>
                    <div class="mb-3 row g-2 align-items-center">
                        <label class="col-sm-4 col-form-label text-muted fw-medium small">TANGGAL TERIMA</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control bg-light border-0 fw-medium text-muted"
                                value="{{ now()->format('d M Y') }}" readonly>
                        </div>
                    </div>
                    <div class="mb-3 row g-2 align-items-center">
                        <label class="col-sm-4 col-form-label text-muted fw-medium small">TANGGAL TTD</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control bg-light border-0 fw-medium text-muted"
                                value="{{ $ba?->tgl_penyerahan?->format('d M Y') ?? now()->format('d M Y') }}" readonly>
                        </div>
                    </div>
                    <div class="mb-3 row g-2 align-items-center">
                        <label class="col-sm-4 col-form-label text-muted fw-medium small">BERAT LIMBAH B3</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control bg-light border-0 fw-semibold text-dark"
                                value="{{ $limbah->jumlah_limbah }} {{ $limbah->satuan }}" readonly>
                        </div>
                    </div>
                    <div class="mb-4 row g-2 align-items-center">
                        <label class="col-sm-4 col-form-label text-muted fw-medium small">JENIS KENDARAAN</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control bg-light border-0 fw-semibold text-dark"
                                value="{{ $limbah->jenis_kendaraan ?? '-' }}" readonly>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Data Penyerah (dari Transporter / BA) --}}
    @if($ba && $ba->nama_penyerah)
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
            <div class="card-header bg-white border-bottom p-4">
                <h6 class="mb-0 fw-bold d-flex align-items-center text-dark text-uppercase">
                    <i class="fas fa-user-tag me-2 text-secondary fs-5"></i> Data Penyerah (Transporter)
                </h6>
            </div>
            <div class="card-body p-4">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="text-muted fw-medium small">NAMA</label>
                        <p class="fw-semibold mb-0">{{ $ba->nama_penyerah }}</p>
                    </div>
                    <div class="col-md-4">
                        <label class="text-muted fw-medium small">JABATAN</label>
                        <p class="fw-semibold mb-0">{{ $ba->jabatan_penyerah ?? '-' }}</p>
                    </div>
                    <div class="col-md-4">
                        <label class="text-muted fw-medium small">ALAMAT</label>
                        <p class="fw-semibold mb-0">{{ $ba->alamat_penyerah ?? '-' }}</p>
                    </div>
                    @if($ba->tandatangan_penyerah)
                        <div class="col-md-4">
                            <label class="text-muted fw-medium small">TANDA TANGAN</label>
                            <div class="mt-1 border rounded p-2 bg-light d-inline-block">
                                <img src="{{ asset('storage/'.$ba->tandatangan_penyerah) }}" alt="TTD Penyerah"
                                    style="max-height: 80px; max-width: 200px; object-fit: contain;">
                            </div>
                        </div>
                    @endif
                    @if($ba->stempel_penyerah)
                        <div class="col-md-4">
                            <label class="text-muted fw-medium small">STEMPEL</label>
                            <div class="mt-1 border rounded p-2 bg-light d-inline-block">
                                <img src="{{ asset('storage/'.$ba->stempel_penyerah) }}" alt="Stempel Penyerah"
                                    style="max-height: 80px; max-width: 200px; object-fit: contain;">
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @endif

    {{-- Penandatanganan Berita Acara (Penerima / Admin) --}}
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden mt-4 mb-5">
        <div class="card-header bg-white border-bottom p-4">
            <h6 class="mb-0 fw-bold d-flex align-items-center text-dark text-uppercase">
                <i class="fas fa-pen-nib me-2 text-primary fs-5"></i> Penandatanganan Berita Acara (Penerima)
            </h6>
        </div>
        <div class="card-body p-4 p-md-5">
            <form action="{{ route('admin.penerimaan.terima', $limbah->id_limbah) }}" method="POST"
                enctype="multipart/form-data" id="formPenerimaan">
                @csrf
                <div class="row justify-content-center">
                    <div class="col-12 col-lg-8">
                        <div class="mb-4 row g-2 align-items-center">
                            <label for="nama_penerima" class="col-sm-3 col-form-label text-muted fw-semibold small">
                                NAMA LENGKAP <span class="text-danger">*</span>
                            </label>
                            <div class="col-sm-9">
                                <input type="text" id="nama_penerima" class="form-control px-3 py-2 @error('nama_penerima') is-invalid @enderror"
                                    name="nama_penerima" value="{{ old('nama_penerima', $ba?->nama_penerima) }}"
                                    placeholder="Nama penerima / admin">
                                @error('nama_penerima')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-4 row g-2 align-items-center">
                            <label for="alamat_penerima" class="col-sm-3 col-form-label text-muted fw-semibold small">
                                ALAMAT <span class="text-danger">*</span>
                            </label>
                            <div class="col-sm-9">
                                <input type="text" id="alamat_penerima" class="form-control px-3 py-2 @error('alamat_penerima') is-invalid @enderror"
                                    name="alamat_penerima" value="{{ old('alamat_penerima', $ba?->alamat_penerima) }}"
                                    placeholder="Alamat instansi">
                                @error('alamat_penerima')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-4 row g-2 align-items-center">
                            <label for="jabatan_penerima" class="col-sm-3 col-form-label text-muted fw-semibold small">
                                JABATAN <span class="text-danger">*</span>
                            </label>
                            <div class="col-sm-9">
                                <input type="text" id="jabatan_penerima" class="form-control px-3 py-2 @error('jabatan_penerima') is-invalid @enderror"
                                    name="jabatan_penerima" value="{{ old('jabatan_penerima', $ba?->jabatan_penerima) }}"
                                    placeholder="Jabatan / NIP">
                                @error('jabatan_penerima')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-4 row g-2 align-items-center">
                            <label for="tandatangan_penerima" class="col-sm-3 col-form-label text-muted fw-semibold small">TANDA TANGAN</label>
                            <div class="col-sm-9">
                                @if($ba?->tandatangan_penerima)
                                    <div class="mb-2 border rounded p-2 bg-light d-inline-block">
                                        <img src="{{ asset('storage/'.$ba->tandatangan_penerima) }}" alt="TTD Penerima"
                                            style="max-height: 80px; max-width: 200px; object-fit: contain;">
                                    </div>
                                    <div class="mb-1"></div>
                                @endif
                                <input type="file" id="tandatangan_penerima" class="form-control px-3 py-2 @error('tandatangan_penerima') is-invalid @enderror"
                                    name="tandatangan_penerima" accept="image/*">
                                <small class="text-muted mt-1 d-block"><i class="fas fa-file-image me-1"></i> Maks. 2MB (JPG, PNG, GIF)</small>
                                @error('tandatangan_penerima')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-2 row g-2 align-items-center">
                            <label for="stempel_penerima" class="col-sm-3 col-form-label text-muted fw-semibold small">STEMPEL INSTANSI</label>
                            <div class="col-sm-9">
                                @if($ba?->stempel_penerima)
                                    <div class="mb-2 border rounded p-2 bg-light d-inline-block">
                                        <img src="{{ asset('storage/'.$ba->stempel_penerima) }}" alt="Stempel Penerima"
                                            style="max-height: 80px; max-width: 200px; object-fit: contain;">
                                    </div>
                                    <div class="mb-1"></div>
                                @endif
                                <input type="file" id="stempel_penerima" class="form-control px-3 py-2 @error('stempel_penerima') is-invalid @enderror"
                                    name="stempel_penerima" accept="image/*">
                                <small class="text-muted mt-1 d-block"><i class="fas fa-file-image me-1"></i> Maks. 2MB (JPG, PNG, GIF)</small>
                                @error('stempel_penerima')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="card-footer bg-light border-top p-4">
            <div class="row justify-content-center">
                <div class="col-12 col-lg-8">
                    <div class="row g-3">
                        <div class="col-12 col-sm-6">
                            <button type="button"
                                class="btn btn-outline-danger fw-semibold rounded-pill w-100 py-2 d-flex justify-content-center align-items-center"
                                data-bs-toggle="collapse"
                                data-bs-target="#alasanPengembalian"
                                aria-expanded="false">
                                <i class="fas fa-times-circle me-2"></i> Kembalikan Limbah
                            </button>
                            <div class="collapse mt-3" id="alasanPengembalian">
                                <div class="card card-body border-danger bg-danger bg-opacity-10 rounded-4">
                                    <form action="{{ route('admin.penerimaan.kembalikan', $limbah->id_limbah) }}" method="POST">
                                        @csrf
                                        <label class="fw-bold text-danger mb-2 small">Alasan Pengembalian:</label>
                                        <textarea class="form-control border-danger mb-3" name="alasan_dikembalikan" rows="3"
                                            placeholder="Tuliskan alasan limbah dikembalikan secara detail..."></textarea>
                                        <button type="submit" class="btn btn-danger fw-bold rounded-pill w-100 shadow-sm">
                                            <i class="fas fa-paper-plane me-2"></i> Proses Pengembalian
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6">
                            <button type="submit" form="formPenerimaan"
                                class="btn btn-success fw-bold rounded-pill w-100 py-2 shadow-sm d-flex justify-content-center align-items-center">
                                <i class="fas fa-check-circle me-2 fs-5"></i> Terima Limbah
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .form-control:focus { box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.15); }
    </style>
@endsection
