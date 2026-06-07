@extends('layouts.app')

@section('title', 'Kontrak Kerjasama Transporter')

@section('content')
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-2 mb-4">
        <h4 class="fw-bold mb-0 text-dark d-flex align-items-center">
            <div class="bg-primary bg-opacity-10 text-primary p-2 rounded-circle me-3 d-inline-flex justify-content-center align-items-center" style="width: 45px; height: 45px;">
                <i class="fas fa-handshake"></i>
            </div>
            Kontrak Kerjasama Transporter
        </h4>
        <a href="{{ route('transporter.dashboard') }}" class="btn btn-light fw-semibold rounded-pill px-4 shadow-sm border">
            <i class="fas fa-arrow-left me-2"></i> Kembali
        </a>
    </div>

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
                    <form action="{{ route('transporter.kontrak.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row justify-content-center">
                            <div class="col-12 col-lg-8">

                                {{-- ── BAGIAN 1: Data Penghasil ── --}}
                                <h6 class="fw-bold text-primary text-uppercase border-bottom pb-3 mb-4 d-flex align-items-center">
                                    <i class="fas fa-industry me-2"></i> Data Penghasil Limbah B3
                                </h6>

                                <div class="mb-4 row g-2 align-items-center">
                                    <label class="col-sm-4 col-form-label text-muted fw-semibold small text-uppercase">Nama Penghasil
                                        <span class="text-danger">*</span></label>
                                    <div class="col-sm-8">
                                        <select class="form-select shadow-sm px-3 py-2 @error('id_penghasil') is-invalid @enderror"
                                            name="id_penghasil" id="selectPenghasil">
                                            <option value="" selected disabled>-- Pilih penghasil yang bekerjasama --</option>
                                            @foreach($penghasilList as $p)
                                                <option value="{{ $p->id_user }}"
                                                    {{ old('id_penghasil') == $p->id_user ? 'selected' : '' }}>
                                                    {{ $p->informasiPenghasil->nama_penghasil ?? $p->nama_user }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('id_penghasil')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-4 row g-2 align-items-center">
                                    <label class="col-sm-4 col-form-label text-muted fw-semibold small text-uppercase">Jenis Limbah yang Dihasilkan</label>
                                    <div class="col-sm-8">
                                        <input type="text" id="infoJenisLimbah"
                                            class="form-control bg-light border-0 fw-medium px-3 py-2"
                                            placeholder="Pilih penghasil untuk menampilkan jenis limbah" readonly>
                                    </div>
                                </div>

                                <div class="mb-4 row g-2 align-items-center">
                                    <label class="col-sm-4 col-form-label text-muted fw-semibold small text-uppercase">Nomor SK Izin TPS</label>
                                    <div class="col-sm-8">
                                        <input type="text" id="infoNoPerling"
                                            class="form-control bg-light border-0 fw-medium px-3 py-2 font-monospace"
                                            placeholder="Pilih penghasil untuk menampilkan nomor izin" readonly>
                                    </div>
                                </div>

                                <div class="mb-4 row g-2 align-items-center">
                                    <label class="col-sm-4 col-form-label text-muted fw-semibold small text-uppercase">Masa Berlaku Izin</label>
                                    <div class="col-sm-8">
                                        <div class="input-group">
                                            <input type="text" id="infoMasaDari"
                                                class="form-control bg-light border-0 fw-medium"
                                                placeholder="Dari" readonly>
                                            <span class="input-group-text bg-white fw-bold text-muted border-0">S/D</span>
                                            <input type="text" id="infoMasaSampai"
                                                class="form-control bg-light border-0 fw-medium"
                                                placeholder="Sampai" readonly>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-4 row g-2 align-items-center">
                                    <label class="col-sm-4 col-form-label text-muted fw-semibold small text-uppercase">Lampiran SK Izin</label>
                                    <div class="col-sm-8">
                                        <div id="infoLampiranWrap" class="d-none">
                                            <a id="infoLampiranLink" href="#" target="_blank"
                                                class="btn btn-sm btn-outline-primary rounded-pill px-3">
                                                <i class="fas fa-download me-1"></i> Lihat Dokumen SK Izin
                                            </a>
                                        </div>
                                        <span id="infoLampiranEmpty" class="text-muted small fst-italic">
                                            Pilih penghasil untuk melihat lampiran
                                        </span>
                                    </div>
                                </div>

                                {{-- <div class="text-end mb-5">
                                    <span class="btn btn-outline-primary rounded-pill px-4 fw-semibold" id="btnTambah"
                                        style="pointer-events: none; opacity: 0.4;">
                                        <i class="fas fa-plus me-1"></i> Tambah
                                    </span>
                                </div> --}}

                                {{-- ── BAGIAN 2: Kontrak ── --}}
                                <h6 class="fw-bold text-success text-uppercase border-bottom pb-3 mb-4 d-flex align-items-center">
                                    <i class="fas fa-file-contract me-2"></i> Kontrak
                                </h6>

                                <div class="mb-4 row g-2 align-items-center">
                                    <label class="col-sm-4 col-form-label text-muted fw-semibold small text-uppercase">Nomor
                                        <span class="text-danger">*</span></label>
                                    <div class="col-sm-8">
                                        <input type="text"
                                            class="form-control shadow-sm px-3 py-2 font-monospace text-uppercase @error('nomor_kontrak') is-invalid @enderror"
                                            name="nomor_kontrak" value="{{ old('nomor_kontrak') }}"
                                            placeholder="Contoh: K-001/2026">
                                        @error('nomor_kontrak')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-4 row g-2 align-items-center">
                                    <label class="col-sm-4 col-form-label text-muted fw-semibold small text-uppercase">Terbit</label>
                                    <div class="col-sm-8">
                                        <input type="date"
                                            class="form-control shadow-sm px-3 py-2 @error('tgl_terbit') is-invalid @enderror"
                                            name="tgl_terbit" value="{{ old('tgl_terbit', now()->format('Y-m-d')) }}">
                                        @error('tgl_terbit')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-4 row g-2 align-items-center">
                                    <label class="col-sm-4 col-form-label text-muted fw-semibold small text-uppercase">Berlaku
                                        <span class="text-danger">*</span></label>
                                    <div class="col-sm-8">
                                        <div class="input-group shadow-sm">
                                            <input type="date"
                                                class="form-control @error('masa_berlaku_dari') is-invalid @enderror"
                                                name="masa_berlaku_dari" value="{{ old('masa_berlaku_dari') }}">
                                            <span class="input-group-text bg-white fw-bold text-muted">S/D</span>
                                            <input type="date"
                                                class="form-control @error('masa_berlaku_sampai') is-invalid @enderror"
                                                name="masa_berlaku_sampai" value="{{ old('masa_berlaku_sampai') }}">
                                        </div>
                                        @error('masa_berlaku_dari')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                        @error('masa_berlaku_sampai')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-4 row g-2 align-items-center">
                                    <label class="col-sm-4 col-form-label text-muted fw-semibold small text-uppercase">Status</label>
                                    <div class="col-sm-8">
                                        <select class="form-select shadow-sm px-3 py-2 @error('status') is-invalid @enderror" name="status">
                                            <option value="Aktif" {{ old('status', 'Aktif') === 'Aktif' ? 'selected' : '' }}>Aktif</option>
                                            <option value="Non-Aktif" {{ old('status') === 'Non-Aktif' ? 'selected' : '' }}>Non-Aktif</option>
                                        </select>
                                        @error('status')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-5 row g-2">
                                    <label class="col-sm-4 col-form-label text-muted fw-semibold small text-uppercase pt-2">Lampiran Dokumen</label>
                                    <div class="col-sm-8">
                                        <input type="file" class="form-control shadow-sm px-3 py-2 @error('lampiran') is-invalid @enderror"
                                            name="lampiran" accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx">
                                        <div class="form-text mt-2">
                                            <i class="fas fa-info-circle me-1"></i> Maksimal 2MB. Format: PDF, Word, Excel, PPT.
                                        </div>
                                        @error('lampiran')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="text-center mt-2 mb-2">
                                    <button type="submit" class="btn btn-primary rounded-pill px-5 py-3 fw-bold shadow-sm d-inline-flex align-items-center fs-5">
                                        <i class="fas fa-save me-2"></i> Simpan
                                    </button>
                                </div>

                            </div>
                        </div>
                    </form>
                </div>

                {{-- ===================== TABEL TAB ===================== --}}
                <div class="tab-pane fade {{ request('tab') === 'tabel' ? 'show active' : '' }}" id="tabel" role="tabpanel" aria-labelledby="tabel-tab">

                    <form method="GET" action="{{ route('transporter.kontrak') }}">
                        <input type="hidden" name="tab" value="tabel">
                        <div class="bg-light p-4 rounded-4 mb-4 border">
                            <h6 class="fw-bold mb-3 d-flex align-items-center text-dark">
                                <i class="fas fa-filter me-2 text-primary"></i> Filtering & Sorting
                            </h6>
                            <div class="row g-3 align-items-end">
                                <div class="col-md-5">
                                    <label class="form-label text-muted fw-semibold small">KATA KUNCI</label>
                                    <div class="input-group shadow-sm">
                                        <span class="input-group-text bg-white"><i class="fas fa-search text-muted"></i></span>
                                        <input type="text" class="form-control border-start-0 ps-0"
                                            name="keyword" value="{{ request('keyword') }}"
                                            placeholder="Nama penghasil, nomor kontrak...">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label text-muted fw-semibold small">TAMPILKAN</label>
                                    <select class="form-select shadow-sm" name="sort_by">
                                        <option value="terbaru" {{ request('sort_by', 'terbaru') === 'terbaru' ? 'selected' : '' }}>Terbaru</option>
                                        <option value="nama_az" {{ request('sort_by') === 'nama_az' ? 'selected' : '' }}>A-Z Nama</option>
                                        <option value="nama_za" {{ request('sort_by') === 'nama_za' ? 'selected' : '' }}>Z-A Nama</option>
                                        <option value="berakhir" {{ request('sort_by') === 'berakhir' ? 'selected' : '' }}>Akan Berakhir</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label text-muted fw-semibold small">STATUS</label>
                                    <select class="form-select shadow-sm" name="status_filter">
                                        <option value="">Semua</option>
                                        <option value="Aktif" {{ request('status_filter') === 'Aktif' ? 'selected' : '' }}>Aktif</option>
                                        <option value="Non-Aktif" {{ request('status_filter') === 'Non-Aktif' ? 'selected' : '' }}>Non-Aktif</option>
                                    </select>
                                </div>
                                <div class="col-md-2 d-flex gap-2">
                                    <button type="submit" class="btn btn-primary fw-bold flex-grow-1 shadow-sm rounded-pill px-3">
                                        <i class="fas fa-search me-1"></i> Cari
                                    </button>
                                    <a href="{{ route('transporter.kontrak', ['tab' => 'tabel']) }}"
                                        class="btn btn-light fw-bold shadow-sm rounded-circle border d-flex align-items-center justify-content-center"
                                        style="width: 40px; height: 38px;">
                                        <i class="fas fa-undo text-muted"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>

                    <div class="table-responsive rounded-3 shadow-sm border mb-4">
                        <table class="table table-hover table-striped mb-0 align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th class="text-center" style="width: 90px;">Aksi</th>
                                    <th>Nama Penghasil</th>
                                    <th>Nomor Izin TPS</th>
                                    <th>Nomor Kontrak</th>
                                    <th>Tgl Kontrak</th>
                                    <th>Tgl Berakhir</th>
                                    <th class="text-center">Lampiran</th>
                                    <th class="text-center">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($kontraks as $kontrak)
                                    @php
                                        $isExpired    = $kontrak->masa_berlaku_sampai && $kontrak->masa_berlaku_sampai->isPast();
                                        $penghasilIzin = $kontrak->penghasil?->perizinanPenghasil;
                                    @endphp
                                    <tr class="{{ $isExpired ? 'table-warning' : '' }}">
                                        <td class="text-center">
                                            <button class="btn btn-sm btn-light border rounded-circle shadow-sm me-1 btn-edit-kontrak"
                                                style="width: 32px; height: 32px; padding: 0;"
                                                data-id="{{ $kontrak->id_kontrak_kerjasama }}"
                                                data-id_penghasil="{{ $kontrak->id_penghasil }}"
                                                data-nomor_kontrak="{{ $kontrak->nomor_kontrak }}"
                                                data-tgl_terbit="{{ $kontrak->tgl_terbit?->format('Y-m-d') }}"
                                                data-masa_berlaku_dari="{{ $kontrak->masa_berlaku_dari?->format('Y-m-d') }}"
                                                data-masa_berlaku_sampai="{{ $kontrak->masa_berlaku_sampai?->format('Y-m-d') }}"
                                                data-status="{{ $kontrak->status }}"
                                                title="Edit">
                                                <i class="fas fa-edit text-primary"></i>
                                            </button>
                                            <form action="{{ route('transporter.kontrak.destroy', $kontrak->id_kontrak_kerjasama) }}" method="POST" class="d-inline form-hapus-kontrak">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-light border rounded-circle shadow-sm"
                                                    style="width: 32px; height: 32px; padding: 0;" title="Hapus">
                                                    <i class="fas fa-trash text-danger"></i>
                                                </button>
                                            </form>
                                        </td>
                                        <td class="fw-medium">
                                            {{ $kontrak->penghasil->informasiPenghasil->nama_penghasil ?? ($kontrak->penghasil->nama_user ?? '-') }}
                                        </td>
                                        <td class="font-monospace text-muted small">{{ $penghasilIzin->no_perling ?? '-' }}</td>
                                        <td class="font-monospace fw-semibold">{{ $kontrak->nomor_kontrak ?? '-' }}</td>
                                        <td class="text-nowrap">{{ $kontrak->tgl_terbit?->format('d M Y') ?? '-' }}</td>
                                        <td class="text-nowrap">{{ $kontrak->masa_berlaku_sampai?->format('d M Y') ?? '-' }}</td>
                                        <td class="text-center">
                                            @if($kontrak->lampiran)
                                                <a href="{{ asset('storage/' . $kontrak->lampiran) }}" target="_blank"
                                                    class="btn btn-sm btn-outline-primary rounded-pill px-3">
                                                    <i class="fas fa-download"></i>
                                                </a>
                                            @else
                                                <span class="text-muted small">-</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if($isExpired)
                                                <span class="badge bg-danger rounded-pill px-3 py-2">Habis</span>
                                            @elseif($kontrak->status === 'Aktif')
                                                <span class="badge bg-success rounded-pill px-3 py-2">Aktif</span>
                                            @else
                                                <span class="badge bg-secondary rounded-pill px-3 py-2">{{ $kontrak->status }}</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center py-5 text-muted">
                                            <i class="fas fa-folder-open fa-2x mb-2 d-block opacity-50"></i>
                                            Belum ada kontrak kerjasama yang tersimpan.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-center mb-4">
                        {{ $kontraks->links() }}
                    </div>

                    <div class="alert alert-warning border-0 shadow-sm rounded-4 d-flex align-items-center" role="alert">
                        <i class="fas fa-info-circle fs-4 me-3"></i>
                        <div>
                            <strong>Keterangan:</strong> Baris dengan latar kuning menandakan masa berlaku kontrak kerjasama telah berakhir dan perlu diperbarui.
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    {{-- Modal Edit --}}
    <div class="modal fade" id="modalEditKontrak" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content rounded-4 border-0 shadow">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold">
                        <i class="fas fa-edit me-2 text-primary"></i> Edit Kontrak Kerjasama
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="formEditKontrak" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="modal-body px-4 pt-3">
                        <div class="mb-3">
                            <label class="form-label fw-semibold text-muted small text-uppercase">Nama Penghasil <span class="text-danger">*</span></label>
                            <select class="form-select" name="id_penghasil" id="editIdPenghasil">
                                <option value="" disabled>-- Pilih Penghasil --</option>
                                @foreach($penghasilList as $p)
                                    <option value="{{ $p->id_user }}">
                                        {{ $p->informasiPenghasil->nama_penghasil ?? $p->nama_user }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold text-muted small text-uppercase">Nomor Kontrak <span class="text-danger">*</span></label>
                            <input type="text" class="form-control font-monospace text-uppercase" name="nomor_kontrak" id="editNomorKontrak" placeholder="Contoh: K-001/2026">
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold text-muted small text-uppercase">Tanggal Terbit</label>
                            <input type="date" class="form-control" name="tgl_terbit" id="editTglTerbit">
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold text-muted small text-uppercase">Masa Berlaku <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="date" class="form-control" name="masa_berlaku_dari" id="editMasaBerlakuDari">
                                <span class="input-group-text bg-white fw-bold text-muted">S/D</span>
                                <input type="date" class="form-control" name="masa_berlaku_sampai" id="editMasaBerlakuSampai">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold text-muted small text-uppercase">Status</label>
                            <select class="form-select" name="status" id="editStatus">
                                <option value="Aktif">Aktif</option>
                                <option value="Non-Aktif">Non-Aktif</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold text-muted small text-uppercase">Lampiran Baru (opsional)</label>
                            <input type="file" class="form-control" name="lampiran" accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx">
                            <div class="form-text"><i class="fas fa-info-circle me-1"></i> Biarkan kosong jika tidak mengganti lampiran. Maks. 2MB.</div>
                        </div>
                    </div>
                    <div class="modal-footer border-0 pt-0">
                        <button type="button" class="btn btn-light rounded-pill px-4 fw-semibold" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary rounded-pill px-5 fw-bold shadow-sm">
                            <i class="fas fa-save me-2"></i> Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {

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

            // ── Auto-fill saat pilih penghasil via AJAX ──
            var selectPenghasil = document.getElementById('selectPenghasil');
            var elJenisLimbah   = document.getElementById('infoJenisLimbah');
            var elNoPerling     = document.getElementById('infoNoPerling');
            var elMasaDari      = document.getElementById('infoMasaDari');
            var elMasaSampai    = document.getElementById('infoMasaSampai');
            var elLampiranWrap  = document.getElementById('infoLampiranWrap');
            var elLampiranLink  = document.getElementById('infoLampiranLink');
            var elLampiranEmpty = document.getElementById('infoLampiranEmpty');
            var btnTambah       = document.getElementById('btnTambah');

            function loadPenghasilInfo(id) {
                if (!id) { return; }

                elJenisLimbah.value = 'Memuat...';
                elNoPerling.value   = 'Memuat...';
                elMasaDari.value    = 'Memuat...';
                elMasaSampai.value  = 'Memuat...';

                fetch('/transporter/kontrak/penghasil/' + encodeURIComponent(id) + '/info', {
                    headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' },
                    credentials: 'same-origin'
                })
                .then(function (r) {
                    if (!r.ok) { throw new Error('HTTP ' + r.status); }
                    return r.json();
                })
                .then(function (data) {
                    elJenisLimbah.value = data.limbah_dihasilkan || '(Belum ada data)';
                    elNoPerling.value   = data.no_perling        || '(Belum ada data)';
                    elMasaDari.value    = data.masa_berlaku_perling_dari   || '-';
                    elMasaSampai.value  = data.masa_berlaku_perling_sampai || '-';

                    if (data.lampiran_perling) {
                        elLampiranLink.href = data.lampiran_perling;
                        elLampiranWrap.classList.remove('d-none');
                        elLampiranEmpty.classList.add('d-none');
                    } else {
                        elLampiranWrap.classList.add('d-none');
                        elLampiranEmpty.textContent = '(Tidak ada lampiran SK Izin)';
                        elLampiranEmpty.classList.remove('d-none');
                    }

                    if (btnTambah) {
                        btnTambah.style.opacity       = '1';
                        btnTambah.style.pointerEvents = 'auto';
                    }
                })
                .catch(function (err) {
                    elJenisLimbah.value = '(Gagal memuat)';
                    elNoPerling.value   = '(Gagal memuat)';
                    elMasaDari.value    = '';
                    elMasaSampai.value  = '';
                    console.error('[Kontrak] Gagal memuat info penghasil:', err);
                });
            }

            if (selectPenghasil) {
                selectPenghasil.addEventListener('change', function () {
                    loadPenghasilInfo(this.value);
                });
                if (selectPenghasil.value) {
                    loadPenghasilInfo(selectPenghasil.value);
                }
            }

            // ── Konfirmasi hapus ──
            document.querySelectorAll('.form-hapus-kontrak').forEach(function (form) {
                form.addEventListener('submit', function (e) {
                    e.preventDefault();
                    if (confirm('Yakin ingin menghapus kontrak ini? Data tidak dapat dikembalikan.')) {
                        form.submit();
                    }
                });
            });

            // ── Modal Edit ──
            document.querySelectorAll('.btn-edit-kontrak').forEach(function (btn) {
                btn.addEventListener('click', function () {
                    var id = this.dataset.id;
                    document.getElementById('formEditKontrak').action      = '/transporter/kontrak/' + id;
                    document.getElementById('editIdPenghasil').value       = this.dataset.id_penghasil;
                    document.getElementById('editNomorKontrak').value      = this.dataset.nomor_kontrak;
                    document.getElementById('editTglTerbit').value         = this.dataset.tgl_terbit;
                    document.getElementById('editMasaBerlakuDari').value   = this.dataset.masa_berlaku_dari;
                    document.getElementById('editMasaBerlakuSampai').value = this.dataset.masa_berlaku_sampai;
                    document.getElementById('editStatus').value            = this.dataset.status;
                    new bootstrap.Modal(document.getElementById('modalEditKontrak')).show();
                });
            });

        });
    </script>
@endsection
