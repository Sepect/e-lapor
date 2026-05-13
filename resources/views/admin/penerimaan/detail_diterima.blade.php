@extends('layouts.app')

@section('title', 'Proses Pengolahan Limbah')
@section('subtitle', 'Proses Pengolahan Limbah')

@section('content')
    @php
        $info      = $limbah->penghasil->informasiPenghasil ?? null;
        $transInfo = $limbah->transporter->informasiTransporter ?? null;
        $ba        = $limbah->beritaAcara;
        $kontrak   = $limbah->kontrak;
    @endphp

    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-2 mb-4">
        <h4 class="fw-bold mb-0 text-dark d-flex align-items-center">
            <div class="bg-success bg-opacity-10 text-success p-2 rounded-circle me-3 d-inline-flex justify-content-center align-items-center" style="width: 45px; height: 45px;">
                <i class="fas fa-check-circle"></i>
            </div>
            Proses Pengolahan Limbah B3
        </h4>
        <a href="{{ route('admin.penerimaan.index', 'diterima') }}" class="btn btn-light fw-semibold rounded-pill px-4 shadow-sm border">
            <i class="fas fa-arrow-left me-2"></i> Kembali
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-4 shadow-sm mb-4" role="alert">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <form action="{{ route('admin.penerimaan.olah', $limbah->id_limbah) }}" method="POST" id="formDiterima">
        @csrf

        {{-- Detail Data --}}
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
            <div class="card-header bg-white border-bottom p-4">
                <h6 class="mb-0 fw-bold d-flex align-items-center text-dark">
                    <i class="fas fa-info-circle me-2 text-primary fs-5"></i> Detail Data Limbah
                </h6>
            </div>
            <div class="card-body p-4">
                <div class="row g-5">
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
                            <label class="col-sm-4 col-form-label text-muted fw-medium small">NAMA TRANSPORTER</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control bg-light border-0 fw-semibold text-dark"
                                    value="{{ $transInfo->nama_transporter ?? $limbah->transporter->nama_user ?? '-' }}" readonly>
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
                            <label class="col-sm-4 col-form-label text-muted fw-medium small">TANGGAL DITERIMA</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control bg-light border-0 fw-semibold text-dark"
                                    value="{{ $limbah->tgl_diterima?->format('d M Y') ?? '-' }}" readonly>
                            </div>
                        </div>
                        <div class="mb-3 row g-2 align-items-center">
                            <label class="col-sm-4 col-form-label text-muted fw-medium small">BERAT LIMBAH B3</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control bg-light border-0 fw-semibold text-dark"
                                    value="{{ $limbah->jumlah_limbah }} {{ $limbah->satuan }}" readonly>
                            </div>
                        </div>
                        <div class="row g-2 align-items-center">
                            <label class="col-sm-4 col-form-label text-muted fw-medium small">KODE LIMBAH</label>
                            <div class="col-sm-8">
                                <div class="d-inline-block bg-secondary bg-opacity-10 border border-secondary text-secondary fw-bold px-3 py-1 rounded font-monospace">
                                    {{ $limbah->kode_limbah }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-lg-6">
                        <div class="p-3 bg-light rounded-4 border">
                            <div class="mb-3 row g-2 align-items-center">
                                <label class="col-sm-4 col-form-label text-muted fw-medium small">NOMOR MOU</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control bg-white border-0 fw-semibold text-dark shadow-sm"
                                        value="{{ $kontrak->nomor_kontrak ?? '-' }}" readonly>
                                </div>
                            </div>
                            <div class="mb-3 row g-2 align-items-center">
                                <label class="col-sm-4 col-form-label text-muted fw-medium small">TANGGAL MOU</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control bg-white border-0 fw-semibold text-dark shadow-sm"
                                        value="{{ $kontrak?->tgl_terbit?->format('d M Y') ?? '-' }}" readonly>
                                </div>
                            </div>
                            <div class="mb-3 row g-2 align-items-center">
                                <label for="tgl_diolah" class="col-sm-4 col-form-label fw-bold text-primary small">
                                    TGL DIOLAH <span class="text-danger">*</span>
                                </label>
                                <div class="col-sm-8">
                                    <input type="date" id="tgl_diolah"
                                        class="form-control border-primary shadow-sm @error('tgl_diolah') is-invalid @enderror"
                                        name="tgl_diolah" value="{{ old('tgl_diolah') }}" required>
                                    @error('tgl_diolah')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="text-primary opacity-75 fst-italic mt-1 d-block">
                                        <i class="fas fa-info-circle me-1"></i> Wajib diisi oleh admin
                                    </small>
                                </div>
                            </div>
                            <div class="mb-3 row g-2 align-items-center">
                                <label class="col-sm-4 col-form-label text-muted fw-medium small">TGL TANDATANGAN</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control bg-white border-0 fw-semibold text-muted shadow-sm"
                                        value="{{ now()->format('d M Y') }}" readonly>
                                </div>
                            </div>
                            <div class="mb-3 row g-2 align-items-center">
                                <label for="total_tagihan" class="col-sm-4 col-form-label fw-bold text-success small">
                                    TOTAL TAGIHAN <span class="text-danger">*</span>
                                </label>
                                <div class="col-sm-8">
                                    <div class="input-group shadow-sm">
                                        <span class="input-group-text bg-success text-white border-success fw-bold">Rp</span>
                                        <input type="number" id="total_tagihan"
                                            class="form-control border-success @error('total_tagihan') is-invalid @enderror"
                                            name="total_tagihan" value="{{ old('total_tagihan') }}" placeholder="0" required>
                                        @error('total_tagihan')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <small class="text-success opacity-75 fst-italic mt-1 d-block">
                                        <i class="fas fa-info-circle me-1"></i> Masukkan angka tanpa titik/koma
                                    </small>
                                </div>
                            </div>
                            <div class="mb-3 row g-2 align-items-center">
                                <label class="col-sm-4 col-form-label text-muted fw-medium small">NO. BERITA ACARA</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control bg-white border-0 fw-semibold text-dark shadow-sm font-monospace"
                                        value="{{ $ba ? strtoupper(substr($ba->id_berita_acara, 0, 8)) : '-' }}" readonly>
                                </div>
                            </div>
                            <div class="row g-2 align-items-center">
                                <label class="col-sm-4 col-form-label text-muted fw-medium small">NO. SURAT TAGIHAN</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control bg-white border-0 fw-semibold text-muted shadow-sm"
                                        value="Digenerate saat simpan" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Penandatanganan Surat Tagihan --}}
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-5">
            <div class="card-header bg-white border-bottom p-4">
                <h6 class="mb-0 fw-bold d-flex align-items-center text-dark text-uppercase">
                    <i class="fas fa-pen-nib me-2 text-primary fs-5"></i> Penandatanganan Surat Tagihan
                </h6>
            </div>
            <div class="card-body p-4 p-md-5">
                <div class="row justify-content-center">
                    <div class="col-12 col-lg-8">

                        {{-- Penyerah dari BA (read-only) --}}
                        @if($ba && $ba->nama_penerima)
                            <div class="alert alert-light border rounded-4 mb-4 p-3">
                                <p class="small fw-bold text-muted mb-2 text-uppercase">Data Penerima (dari Berita Acara)</p>
                                <div class="row g-2">
                                    <div class="col-sm-4 small text-muted">Nama</div>
                                    <div class="col-sm-8 fw-semibold small">{{ $ba->nama_penerima }}</div>
                                    <div class="col-sm-4 small text-muted">Jabatan</div>
                                    <div class="col-sm-8 fw-semibold small">{{ $ba->jabatan_penerima ?? '-' }}</div>
                                    <div class="col-sm-4 small text-muted">Alamat</div>
                                    <div class="col-sm-8 fw-semibold small">{{ $ba->alamat_penerima ?? '-' }}</div>
                                </div>
                            </div>
                        @endif

                        <div class="mb-4 row g-2 align-items-center">
                            <label for="nama_penandatangan" class="col-sm-3 col-form-label text-muted fw-semibold small">NAMA LENGKAP</label>
                            <div class="col-sm-9">
                                <input type="text" id="nama_penandatangan" class="form-control px-3 py-2 shadow-sm"
                                    name="nama_penandatangan" value="{{ old('nama_penandatangan', $ba?->nama_penerima) }}"
                                    placeholder="Nama penandatangan">
                            </div>
                        </div>
                        <div class="mb-4 row g-2 align-items-center">
                            <label for="alamat_penandatangan" class="col-sm-3 col-form-label text-muted fw-semibold small">ALAMAT</label>
                            <div class="col-sm-9">
                                <input type="text" id="alamat_penandatangan" class="form-control px-3 py-2 shadow-sm"
                                    name="alamat_penandatangan" value="{{ old('alamat_penandatangan', $ba?->alamat_penerima) }}"
                                    placeholder="Alamat instansi">
                            </div>
                        </div>
                        <div class="mb-4 row g-2 align-items-center">
                            <label for="jabatan_penandatangan" class="col-sm-3 col-form-label text-muted fw-semibold small">JABATAN</label>
                            <div class="col-sm-9">
                                <input type="text" id="jabatan_penandatangan" class="form-control px-3 py-2 shadow-sm"
                                    name="jabatan_penandatangan" value="{{ old('jabatan_penandatangan', $ba?->jabatan_penerima) }}"
                                    placeholder="Jabatan / NIP">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-light border-top p-4 d-flex justify-content-end gap-3">
                <a href="{{ route('admin.penerimaan.index', 'diterima') }}" class="btn btn-light border fw-semibold rounded-pill px-4 shadow-sm">
                    Batal
                </a>
                <button type="submit" form="formDiterima" class="btn btn-success fw-bold rounded-pill px-5 shadow-sm">
                    <i class="fas fa-paper-plane me-2"></i> Simpan & Terbitkan Tagihan
                </button>
            </div>
        </div>

    </form>

    <style>
        .form-control:focus { box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.15); }
    </style>
@endsection
