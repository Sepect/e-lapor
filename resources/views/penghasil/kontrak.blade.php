@extends('layouts.app')

@section('title', 'Kontrak Kerjasama')

@section('content')
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-2 mb-4">
        <h4 class="fw-bold mb-0 text-dark d-flex align-items-center">
            <div class="bg-primary bg-opacity-10 text-primary p-2 rounded-circle me-3 d-inline-flex justify-content-center align-items-center" style="width: 45px; height: 45px;">
                <i class="fas fa-handshake"></i>
            </div>
            Kontrak Kerjasama
        </h4>
        <a href="{{ route('penghasil.dashboard') }}" class="btn btn-light fw-semibold rounded-pill px-4 shadow-sm border">
            <i class="fas fa-arrow-left me-2"></i> Kembali
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-3 mb-4" role="alert">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-5">
        <div class="card-header bg-white border-bottom p-0">
            <ul class="nav nav-tabs nav-fill border-0" id="kontrakTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link {{ request('tab') !== 'tabel' ? 'active text-dark' : 'text-muted' }} rounded-0 py-3 fw-bold text-uppercase border-top-0 border-start-0 border-end-0 border-bottom border-3"
                        id="form-tab" data-bs-toggle="tab" data-bs-target="#form" type="button" role="tab"
                        style="border-bottom-color: {{ request('tab') !== 'tabel' ? '#0d6efd' : 'transparent' }} !important;">
                        <i class="fas fa-edit me-2"></i> Form Isian
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link {{ request('tab') === 'tabel' ? 'active text-dark' : 'text-muted' }} rounded-0 py-3 fw-bold text-uppercase border-top-0 border-start-0 border-end-0 border-bottom border-3"
                        id="tabel-tab" data-bs-toggle="tab" data-bs-target="#tabel" type="button" role="tab"
                        style="border-bottom-color: {{ request('tab') === 'tabel' ? '#0d6efd' : 'transparent' }} !important;">
                        <i class="fas fa-table me-2"></i> Tabel Data
                    </button>
                </li>
            </ul>
        </div>

        <div class="card-body p-4 p-md-5">
            <div class="tab-content" id="kontrakTabContent">

                {{-- ===================== FORM TAB ===================== --}}
                <div class="tab-pane fade {{ request('tab') !== 'tabel' ? 'show active' : '' }}" id="form" role="tabpanel" aria-labelledby="form-tab">

                    @if ($errors->any())
                        <div class="alert alert-danger rounded-3 mb-4">
                            <ul class="mb-0 ps-3">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('penghasil.kontrak.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row justify-content-center">
                            <div class="col-12 col-lg-9">

                                <h6 class="fw-bold text-primary text-uppercase border-bottom pb-3 mb-4 d-flex align-items-center">
                                    <i class="fas fa-truck me-2"></i> Data Transporter Limbah B3
                                </h6>

                                <div class="mb-4 row g-2 align-items-center">
                                    <label class="col-sm-4 col-form-label text-muted fw-semibold small text-uppercase">Nama Transporter</label>
                                    <div class="col-sm-8">
                                        <select class="form-select px-3 py-2 shadow-sm @error('id_transporter') is-invalid @enderror"
                                            name="id_transporter" id="selectTransporter">
                                            <option value="" selected disabled>Pilih transporter yang bekerjasama...</option>
                                            @foreach ($transporterList as $t)
                                                <option value="{{ $t->id_user }}"
                                                    {{ old('id_transporter') == $t->id_user ? 'selected' : '' }}>
                                                    {{ $t->informasiTransporter->nama_transporter ?? $t->nama_user }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('id_transporter')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-4 row g-2 align-items-center">
                                    <label class="col-sm-4 col-form-label text-muted fw-semibold small text-uppercase">Nomor Izin Pengangkutan</label>
                                    <div class="col-sm-8">
                                        <input type="text" id="infoNoPerling"
                                            class="form-control bg-light border-0 fw-medium px-3 py-2"
                                            value="(Otomatis terisi)" readonly>
                                    </div>
                                </div>

                                <div class="mb-5 row g-2 align-items-center">
                                    <label class="col-sm-4 col-form-label text-muted fw-semibold small text-uppercase">Masa Berlaku</label>
                                    <div class="col-sm-8">
                                        <input type="text" id="infoMasaBerlaku"
                                            class="form-control bg-light border-0 fw-medium px-3 py-2 mb-2"
                                            value="(Otomatis terisi)" readonly>
                                    </div>
                                </div>

                                <h6 class="fw-bold text-success text-uppercase border-bottom pb-3 mb-4 mt-5 d-flex align-items-center">
                                    <i class="fas fa-file-contract me-2"></i> Isian Kontrak Kerjasama Tripartid
                                </h6>

                                <div class="card bg-light border-0 rounded-4 mb-4">
                                    <div class="card-body p-4">
                                        <h6 class="fw-bold mb-3 text-dark">A. Penandatanganan Kontrak</h6>
                                        <div class="row g-3 mb-4">
                                            <div class="col-md-6">
                                                <label class="form-label text-muted fw-semibold small">Hari</label>
                                                <input type="text" class="form-control shadow-sm" name="hari" value="{{ old('hari') }}" placeholder="Tulis dengan huruf">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label text-muted fw-semibold small">Tanggal</label>
                                                <input type="text" class="form-control shadow-sm" name="tanggal_ttd" value="{{ old('tanggal_ttd') }}" placeholder="Tulis dengan huruf">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label text-muted fw-semibold small">Bulan</label>
                                                <input type="text" class="form-control shadow-sm" name="bulan" value="{{ old('bulan') }}" placeholder="Tulis dengan huruf">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label text-muted fw-semibold small">Tahun</label>
                                                <input type="text" class="form-control shadow-sm" name="tahun" value="{{ old('tahun') }}" placeholder="Tulis dengan huruf">
                                            </div>
                                            <div class="col-12 mt-3">
                                                <label class="form-label text-muted fw-semibold small">Nomor Kontrak <span class="text-danger">*</span></label>
                                                <input type="text"
                                                    class="form-control shadow-sm font-monospace text-uppercase @error('nomor_kontrak') is-invalid @enderror"
                                                    name="nomor_kontrak" value="{{ old('nomor_kontrak') }}" placeholder="Masukkan nomor kontrak">
                                                @error('nomor_kontrak')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <h6 class="fw-bold mb-3 text-dark mt-4 border-top pt-4">B. Masa Kontrak Kerjasama</h6>
                                        <div class="row g-3 mb-4">
                                            <div class="col-12">
                                                <label class="form-label text-muted fw-semibold small">Jangka Waktu</label>
                                                <input type="text" class="form-control shadow-sm" name="jangka_waktu" id="inputJangkaWaktu"
                                                    value="{{ old('jangka_waktu') }}" placeholder="Contoh: 12 (Dua Belas) Bulan">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label text-muted fw-semibold small">Mulai Kontrak <span class="text-danger">*</span></label>
                                                <input type="date"
                                                    class="form-control shadow-sm @error('masa_berlaku_dari') is-invalid @enderror"
                                                    name="masa_berlaku_dari" id="inputMulaiKontrak" value="{{ old('masa_berlaku_dari') }}">
                                                @error('masa_berlaku_dari')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label text-muted fw-semibold small">Akhir Kontrak <span class="text-danger">*</span></label>
                                                <input type="date"
                                                    class="form-control shadow-sm @error('masa_berlaku_sampai') is-invalid @enderror"
                                                    name="masa_berlaku_sampai" id="inputAkhirKontrak" value="{{ old('masa_berlaku_sampai') }}">
                                                @error('masa_berlaku_sampai')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <h6 class="fw-bold mb-3 text-dark mt-4 border-top pt-4">C. Identitas Penandatanganan Kontrak</h6>
                                        <div class="row g-3">
                                            <div class="col-12">
                                                <label class="form-label text-muted fw-semibold small">Nama Perusahaan</label>
                                                <input type="text" class="form-control shadow-sm" name="nama_perusahaan" value="{{ old('nama_perusahaan') }}" placeholder="Masukkan nama perusahaan">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label text-muted fw-semibold small">Jenis Usaha</label>
                                                <select class="form-select shadow-sm" name="jenis_usaha">
                                                    <option value="" selected disabled>Pilih jenis usaha...</option>
                                                    <option {{ old('jenis_usaha') === 'Rumah Sakit' ? 'selected' : '' }}>Rumah Sakit</option>
                                                    <option {{ old('jenis_usaha') === 'Puskesmas' ? 'selected' : '' }}>Puskesmas</option>
                                                    <option {{ old('jenis_usaha') === 'Klinik' ? 'selected' : '' }}>Klinik</option>
                                                    <option {{ old('jenis_usaha') === 'Perusahaan' ? 'selected' : '' }}>Perusahaan</option>
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label text-muted fw-semibold small">Perizinan</label>
                                                <select class="form-select shadow-sm" name="perizinan">
                                                    <option value="" selected disabled>Pilih perizinan...</option>
                                                    <option {{ old('perizinan') === 'Akta Pendirian' ? 'selected' : '' }}>Akta Pendirian</option>
                                                    <option {{ old('perizinan') === 'SK Kepala Daerah' ? 'selected' : '' }}>SK Kepala Daerah</option>
                                                    <option {{ old('perizinan') === 'Perling' ? 'selected' : '' }}>Perling</option>
                                                </select>
                                            </div>
                                            <div class="col-12">
                                                <label class="form-label text-muted fw-semibold small">Alamat / Kelurahan / Kecamatan</label>
                                                <input type="text" class="form-control shadow-sm" name="alamat_ttd" value="{{ old('alamat_ttd') }}" placeholder="Masukkan alamat lengkap">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label text-muted fw-semibold small">Kabupaten / Kota</label>
                                                <input type="text" class="form-control shadow-sm" name="kota_ttd" value="{{ old('kota_ttd') }}" placeholder="Masukkan kabupaten/kota">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label text-muted fw-semibold small">Provinsi</label>
                                                <input type="text" class="form-control shadow-sm" name="provinsi_ttd" value="{{ old('provinsi_ttd') }}" placeholder="Masukkan provinsi">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label text-muted fw-semibold small">Nama yang Bertandatangan</label>
                                                <input type="text" class="form-control shadow-sm" name="nama_ttd" value="{{ old('nama_ttd') }}" placeholder="Masukkan nama terang">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label text-muted fw-semibold small">Jabatan</label>
                                                <input type="text" class="form-control shadow-sm" name="jabatan_ttd" value="{{ old('jabatan_ttd') }}" placeholder="Masukkan jabatan">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="text-center mb-5 mt-4">
                                    <p class="text-muted small mb-3">
                                        <i class="fas fa-info-circle me-1"></i>
                                        Simpan kontrak terlebih dahulu, lalu klik ikon
                                        <i class="fas fa-print text-success"></i> pada tabel daftar kontrak untuk mencetak
                                        Draft Kerjasama Tripartid yang sudah terisi otomatis.
                                    </p>
                                </div>

                                <h6 class="fw-bold text-info text-uppercase border-bottom pb-3 mb-4 mt-5 d-flex align-items-center">
                                    <i class="fas fa-file-signature me-2"></i> Upload Kontrak Tertanda Tangan
                                </h6>

                                <div class="mb-4 row g-2 align-items-center">
                                    <label class="col-sm-4 col-form-label text-muted fw-semibold small text-uppercase">Nomor</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control shadow-sm px-3 py-2 font-monospace bg-light border-0"
                                            id="displayNomor" value="{{ old('nomor_kontrak') ? old('nomor_kontrak') : '(Dari nomor kontrak di atas)' }}" readonly>
                                    </div>
                                </div>

                                <div class="mb-4 row g-2 align-items-center">
                                    <label class="col-sm-4 col-form-label text-muted fw-semibold small text-uppercase">Terbit</label>
                                    <div class="col-sm-8">
                                        <input type="date" class="form-control shadow-sm px-3 py-2 @error('tgl_terbit') is-invalid @enderror"
                                            name="tgl_terbit" id="inputTglTerbit"
                                            value="{{ old('tgl_terbit', now()->format('Y-m-d')) }}">
                                        @error('tgl_terbit')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-4 row g-2 align-items-center">
                                    <label class="col-sm-4 col-form-label text-muted fw-semibold small text-uppercase">Masa Berlaku</label>
                                    <div class="col-sm-8">
                                        <div class="input-group shadow-sm">
                                            <input type="text" class="form-control bg-light border-0" id="displayMulai"
                                                value="{{ old('masa_berlaku_dari') ?? '(Otomatis)' }}" readonly>
                                            <span class="input-group-text bg-white fw-bold">S/D</span>
                                            <input type="text" class="form-control bg-light border-0" id="displayAkhir"
                                                value="{{ old('masa_berlaku_sampai') ?? '(Otomatis)' }}" readonly>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-5 row g-2">
                                    <label class="col-sm-4 col-form-label text-muted fw-semibold small text-uppercase pt-2">Lampiran Dokumen</label>
                                    <div class="col-sm-8">
                                        <input type="file" class="form-control shadow-sm px-3 py-2 @error('lampiran') is-invalid @enderror"
                                            name="lampiran" accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx">
                                        <div class="form-text mt-2"><i class="fas fa-info-circle me-1"></i> Maksimal 2MB. Format: Word, PDF, PPT, Excel.</div>
                                        @error('lampiran')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="text-end">
                                    <button type="submit" class="btn btn-primary fw-bold rounded-pill px-5 py-2 shadow-sm">
                                        <i class="fas fa-save me-2"></i> Simpan Data Kontrak
                                    </button>
                                </div>

                            </div>
                        </div>
                    </form>
                </div>

                {{-- ===================== TABEL TAB ===================== --}}
                <div class="tab-pane fade {{ request('tab') === 'tabel' ? 'show active' : '' }}" id="tabel" role="tabpanel" aria-labelledby="tabel-tab">

                    {{-- Filter --}}
                    <form method="GET" action="{{ route('penghasil.kontrak') }}">
                        <input type="hidden" name="tab" value="tabel">
                        <div class="bg-light p-4 rounded-4 mb-4 border">
                            <h6 class="fw-bold mb-3 d-flex align-items-center text-dark">
                                <i class="fas fa-filter me-2 text-primary"></i> Filtering & Sorting
                            </h6>
                            <div class="row g-3 align-items-end">
                                <div class="col-md-5">
                                    <label class="form-label text-muted fw-semibold small">MASUKKAN KATA KUNCI</label>
                                    <div class="input-group shadow-sm">
                                        <span class="input-group-text bg-white"><i class="fas fa-search text-muted"></i></span>
                                        <input type="text" class="form-control border-start-0 ps-0" name="keyword"
                                            value="{{ request('keyword') }}" placeholder="Nama transporter atau nomor kontrak...">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label text-muted fw-semibold small">PENCARIAN</label>
                                    <select class="form-select shadow-sm" name="status_filter">
                                        <option value="">Semua Status</option>
                                        <option value="Aktif" {{ request('status_filter') === 'Aktif' ? 'selected' : '' }}>Aktif</option>
                                        <option value="Non-Aktif" {{ request('status_filter') === 'Non-Aktif' ? 'selected' : '' }}>Non-Aktif</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label text-muted fw-semibold small">TAMPILKAN</label>
                                    <select class="form-select shadow-sm" name="sort_by">
                                        <option value="terbaru" {{ request('sort_by', 'terbaru') === 'terbaru' ? 'selected' : '' }}>Terbaru</option>
                                        <option value="berakhir" {{ request('sort_by') === 'berakhir' ? 'selected' : '' }}>Akan Berakhir</option>
                                    </select>
                                </div>
                                <div class="col-md-3 d-flex gap-2">
                                    <button type="submit" class="btn btn-primary fw-bold flex-grow-1 shadow-sm rounded-pill">
                                        <i class="fas fa-search me-1"></i> Search
                                    </button>
                                    <a href="{{ route('penghasil.kontrak', ['tab' => 'tabel']) }}"
                                        class="btn btn-light fw-bold shadow-sm rounded-pill border px-3">
                                        Reset
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>

                    {{-- Tabel --}}
                    <div class="table-responsive rounded-3 shadow-sm border mb-4">
                        <table class="table table-hover table-striped mb-0 align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th class="text-center" style="width: 60px;">Edit</th>
                                    <th>Nama Transporter</th>
                                    <th class="text-nowrap">Nomor Izin TPS</th>
                                    <th class="text-nowrap">Nomor Kontrak</th>
                                    <th class="text-center text-nowrap">Tanggal Kontrak</th>
                                    <th class="text-center text-nowrap">Tanggal Habis Berlaku</th>
                                    <th class="text-center">Lampiran</th>
                                    <th class="text-center">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($kontraks as $kontrak)
                                    @php
                                        $transInfo = $kontrak->transporter->informasiTransporter ?? null;
                                        $transIzin = $kontrak->transporter->perizinanTransporter ?? null;
                                        $isExpiring = $kontrak->status === 'Aktif'
                                            && $kontrak->masa_berlaku_sampai
                                            && $kontrak->masa_berlaku_sampai->isFuture()
                                            && $kontrak->masa_berlaku_sampai->diffInDays(now()) <= 30;
                                    @endphp
                                    <tr class="{{ $kontrak->status === 'Non-Aktif' ? 'table-warning' : '' }}">
                                        <td class="text-center">
                                            <button type="button"
                                                class="btn btn-sm btn-light border rounded-circle shadow-sm btn-edit-kontrak"
                                                style="width: 32px; height: 32px; padding: 0;"
                                                title="Edit"
                                                data-id="{{ $kontrak->id_kontrak_kerjasama }}"
                                                data-transporter="{{ $kontrak->id_transporter }}"
                                                data-nama="{{ $transInfo->nama_transporter ?? $kontrak->transporter->nama_user }}"
                                                data-nomor="{{ $kontrak->nomor_kontrak }}"
                                                data-terbit="{{ $kontrak->tgl_terbit?->format('Y-m-d') }}"
                                                data-dari="{{ $kontrak->masa_berlaku_dari?->format('Y-m-d') }}"
                                                data-sampai="{{ $kontrak->masa_berlaku_sampai?->format('Y-m-d') }}"
                                                data-status="{{ $kontrak->status }}"
                                                data-no-perling="{{ $transIzin->no_perling ?? '' }}"
                                                data-bs-toggle="modal" data-bs-target="#modalEditKontrak">
                                                <i class="fas fa-edit text-primary"></i>
                                            </button>
                                            <a href="{{ route('penghasil.kontrak.cetak', $kontrak->id_kontrak_kerjasama) }}"
                                                target="_blank"
                                                class="btn btn-sm btn-light border rounded-circle shadow-sm mt-1"
                                                style="width: 32px; height: 32px; padding: 0; display: inline-flex; align-items: center; justify-content: center;"
                                                title="Cetak Draft Kerjasama Tripartid">
                                                <i class="fas fa-print text-success"></i>
                                            </a>
                                        </td>
                                        <td class="fw-medium">
                                            {{ $transInfo->nama_transporter ?? $kontrak->transporter->nama_user ?? '-' }}
                                        </td>
                                        <td class="font-monospace text-muted text-nowrap">
                                            {{ $transIzin->no_perling ?? '-' }}
                                        </td>
                                        <td class="font-monospace fw-semibold text-nowrap">{{ $kontrak->nomor_kontrak }}</td>
                                        <td class="text-center text-nowrap">
                                            {{ $kontrak->tgl_terbit?->format('d M Y') ?? '-' }}
                                        </td>
                                        <td class="text-center text-nowrap">
                                            {{ $kontrak->masa_berlaku_sampai?->format('d M Y') ?? '-' }}
                                            @if ($isExpiring)
                                                <div>
                                                    <span class="badge bg-warning text-dark rounded-pill" style="font-size: 0.68rem;">
                                                        <i class="fas fa-exclamation-triangle me-1"></i> Segera berakhir
                                                    </span>
                                                </div>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if ($kontrak->lampiran)
                                                <a href="{{ asset('storage/' . $kontrak->lampiran) }}" target="_blank"
                                                    class="btn btn-sm btn-outline-primary rounded-pill px-3">
                                                    <i class="fas fa-download me-1"></i> Download
                                                </a>
                                            @else
                                                <span class="text-muted small">—</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if ($kontrak->status === 'Aktif')
                                                <span class="badge bg-success rounded-pill px-3 py-2">Aktif</span>
                                            @else
                                                <span class="badge bg-secondary rounded-pill px-3 py-2">Non-Aktif</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center py-5 text-muted">
                                            <i class="fas fa-folder-open fa-2x mb-2 d-block opacity-50"></i>
                                            Belum ada kontrak kerjasama yang terdaftar.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- Keterangan --}}
                    <div class="alert alert-warning border-0 shadow-sm rounded-3 d-flex align-items-center mb-4" role="alert">
                        <i class="fas fa-info-circle fs-5 me-3"></i>
                        <div class="small">
                            <strong>Keterangan:</strong> Warna latar kuning menandakan masa berlaku Kontrak Kerjasama telah berakhir.
                        </div>
                    </div>

                    <div class="d-flex justify-content-center">
                        {{ $kontraks->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>

    {{-- Modal Edit Kontrak --}}
    <div class="modal fade" id="modalEditKontrak" tabindex="-1" aria-labelledby="modalEditKontrakLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content rounded-4 border-0 shadow">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold" id="modalEditKontrakLabel">
                        <i class="fas fa-edit me-2 text-primary"></i> Edit Kontrak Kerjasama
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="formEditKontrak" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="modal-body p-4">

                        <div class="mb-3 row align-items-center">
                            <label class="col-sm-4 col-form-label text-muted fw-semibold small text-uppercase">Transporter</label>
                            <div class="col-sm-8">
                                <input type="text" id="editNamaTransporter" class="form-control bg-light" readonly>
                            </div>
                        </div>

                        <div class="mb-3 row align-items-center">
                            <label class="col-sm-4 col-form-label text-muted fw-semibold small text-uppercase">No. Izin Pengangkutan</label>
                            <div class="col-sm-8">
                                <input type="text" id="editNoPerling" class="form-control bg-light font-monospace" readonly>
                            </div>
                        </div>

                        <hr class="my-3">

                        <div class="mb-3 row align-items-center">
                            <label class="col-sm-4 col-form-label text-muted fw-semibold small text-uppercase">Nomor Kontrak <span class="text-danger">*</span></label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control font-monospace text-uppercase" name="nomor_kontrak" id="editNomor" required>
                            </div>
                        </div>

                        <div class="mb-3 row align-items-center">
                            <label class="col-sm-4 col-form-label text-muted fw-semibold small text-uppercase">Tanggal Terbit <span class="text-danger">*</span></label>
                            <div class="col-sm-8">
                                <input type="date" class="form-control" name="tgl_terbit" id="editTerbit" required>
                            </div>
                        </div>

                        <div class="mb-3 row align-items-center">
                            <label class="col-sm-4 col-form-label text-muted fw-semibold small text-uppercase">Masa Berlaku <span class="text-danger">*</span></label>
                            <div class="col-sm-8">
                                <div class="input-group">
                                    <input type="date" class="form-control" name="masa_berlaku_dari" id="editDari" required>
                                    <span class="input-group-text bg-white fw-bold text-muted">s/d</span>
                                    <input type="date" class="form-control" name="masa_berlaku_sampai" id="editSampai" required>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3 row align-items-center">
                            <label class="col-sm-4 col-form-label text-muted fw-semibold small text-uppercase">Status</label>
                            <div class="col-sm-8">
                                <select class="form-select" name="status" id="editStatus">
                                    <option value="Aktif">Aktif</option>
                                    <option value="Non-Aktif">Non-Aktif</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-sm-4 col-form-label text-muted fw-semibold small text-uppercase pt-2">Lampiran Baru</label>
                            <div class="col-sm-8">
                                <input type="file" class="form-control" name="lampiran" accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx">
                                <div class="form-text">Biarkan kosong jika tidak ingin mengubah lampiran. Maks 2MB.</div>
                            </div>
                        </div>

                        {{-- pass id_transporter agar validasi backend tidak gagal --}}
                        <input type="hidden" name="id_penghasil" id="editIdPenghasil">
                        <input type="hidden" name="id_transporter" id="editIdTransporter">

                    </div>
                    <div class="modal-footer border-0 pt-0">
                        <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary rounded-pill px-4 fw-bold shadow-sm">
                            <i class="fas fa-save me-2"></i> Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {

            // ── Tab Management ──
            document.querySelectorAll('#kontrakTab button').forEach(function (triggerEl) {
                triggerEl.addEventListener('shown.bs.tab', function (event) {
                    document.querySelectorAll('#kontrakTab button').forEach(function (el) {
                        el.style.borderBottomColor = 'transparent';
                        el.classList.remove('text-dark');
                        el.classList.add('text-muted');
                    });
                    event.target.style.borderBottomColor = '#0d6efd';
                    event.target.classList.remove('text-muted');
                    event.target.classList.add('text-dark');
                });
            });

            // ── AJAX Auto-fill Transporter Info ──
            const selectTransporter = document.getElementById('selectTransporter');
            const infoNoPerling     = document.getElementById('infoNoPerling');
            const infoMasaBerlaku   = document.getElementById('infoMasaBerlaku');

            const btnDownload = document.getElementById('btnDownloadPerjanjian');

            if (selectTransporter) {
                selectTransporter.addEventListener('change', function () {
                    const id = this.value;
                    if (!id) { return; }

                    fetch(`{{ url('/penghasil/kontrak/transporter') }}/${id}/info`, {
                        credentials: 'same-origin',
                        headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
                    })
                    .then(r => r.json())
                    .then(data => {
                        infoNoPerling.value = data.no_perling || '(Belum tersedia)';
                        const fmt = d => d
                            ? new Date(d).toLocaleDateString('id-ID', { day: '2-digit', month: 'long', year: 'numeric' })
                            : '';
                        const dari   = fmt(data.masa_berlaku_perling_dari);
                        const sampai = fmt(data.masa_berlaku_perling_sampai);
                        infoMasaBerlaku.value = (dari && sampai) ? `${dari} s/d ${sampai}` : '(Belum tersedia)';

                        if (btnDownload) {
                            if (data.lampiran_url) {
                                btnDownload.href = data.lampiran_url;
                                btnDownload.setAttribute('target', '_blank');
                                btnDownload.classList.remove('disabled');
                            } else {
                                btnDownload.href = '#';
                                btnDownload.removeAttribute('target');
                                btnDownload.classList.add('disabled');
                            }
                        }
                    })
                    .catch(() => {
                        infoNoPerling.value   = '(Gagal memuat)';
                        infoMasaBerlaku.value = '(Gagal memuat)';
                        if (btnDownload) { btnDownload.classList.add('disabled'); }
                    });
                });
            }

            // ── Sinkronisasi Nomor Kontrak → display Upload ──
            const inputNomor   = document.querySelector('[name="nomor_kontrak"]');
            const displayNomor = document.getElementById('displayNomor');
            if (inputNomor && displayNomor) {
                inputNomor.addEventListener('input', function () {
                    displayNomor.value = this.value || '(Dari nomor kontrak di atas)';
                });
            }

            // ── Sinkronisasi Masa Berlaku → display Upload ──
            const inputMulai   = document.getElementById('inputMulaiKontrak');
            const inputAkhir   = document.getElementById('inputAkhirKontrak');
            const displayMulai = document.getElementById('displayMulai');
            const displayAkhir = document.getElementById('displayAkhir');

            function fmtDate(val) {
                if (!val) { return '(Otomatis)'; }
                return new Date(val).toLocaleDateString('id-ID', { day: '2-digit', month: 'long', year: 'numeric' });
            }

            if (inputMulai && displayMulai) {
                inputMulai.addEventListener('change', function () {
                    displayMulai.value = fmtDate(this.value);
                });
            }
            if (inputAkhir && displayAkhir) {
                inputAkhir.addEventListener('change', function () {
                    displayAkhir.value = fmtDate(this.value);
                });
            }

            // ── Edit Modal: Isi data ──
            document.querySelectorAll('.btn-edit-kontrak').forEach(function (btn) {
                btn.addEventListener('click', function () {
                    const id = this.dataset.id;
                    document.getElementById('formEditKontrak').action = `/penghasil/kontrak/${id}`;
                    document.getElementById('editNamaTransporter').value = this.dataset.nama;
                    document.getElementById('editNoPerling').value       = this.dataset.noPerling;
                    document.getElementById('editNomor').value           = this.dataset.nomor;
                    document.getElementById('editTerbit').value          = this.dataset.terbit;
                    document.getElementById('editDari').value            = this.dataset.dari;
                    document.getElementById('editSampai').value          = this.dataset.sampai;
                    document.getElementById('editStatus').value          = this.dataset.status;
                    document.getElementById('editIdTransporter').value   = this.dataset.transporter;
                });
            });

        });
    </script>
@endsection
