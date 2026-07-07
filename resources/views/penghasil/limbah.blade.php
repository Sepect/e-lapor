@extends('layouts.app')

@section('title', 'Jumlah Limbah B3')

@section('content')
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-2 mb-4">
        <h4 class="fw-bold mb-0 text-dark d-flex align-items-center">
            <div class="bg-primary bg-opacity-10 text-primary p-2 rounded-circle me-3 d-inline-flex justify-content-center align-items-center" style="width: 45px; height: 45px;">
                <i class="fas fa-recycle"></i>
            </div>
            Jumlah Limbah B3
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
            <ul class="nav nav-tabs nav-fill border-0" id="limbahTab" role="tablist">
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
            <div class="tab-content" id="limbahTabContent">

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

                    <form action="{{ route('penghasil.limbah.store') }}" method="POST">
                        @csrf
                        <div class="row justify-content-center">
                            <div class="col-12 col-lg-8">
                                <h6 class="fw-bold text-primary text-uppercase border-bottom pb-3 mb-4 d-flex align-items-center">
                                    <i class="fas fa-file-alt me-2"></i> Data Limbah B3
                                </h6>

                                <input type="hidden" name="id_master_limbah" id="inputMasterLimbah" value="{{ old('id_master_limbah') }}">

                                @if ($masterLimbah->isEmpty())
                                    <div class="alert alert-warning rounded-3 mb-4">
                                        <i class="fas fa-exclamation-triangle me-2"></i>
                                        Master limbah B3 belum tersedia. Hubungi admin untuk menambahkan data jenis & sifat limbah.
                                    </div>
                                @endif

                                <div class="mb-4 row g-2 align-items-center">
                                    <label class="col-sm-4 col-form-label text-muted fw-semibold small text-uppercase">Jenis Limbah B3 <span class="text-danger">*</span></label>
                                    <div class="col-sm-8">
                                        <select class="form-select px-3 py-2 shadow-sm @error('id_master_limbah') is-invalid @enderror"
                                            id="selectJenisLimbah">
                                            <option value="" selected disabled>Pilih jenis limbah</option>
                                            @foreach ($masterLimbah->pluck('jenis_limbah')->unique() as $jenis)
                                                <option value="{{ $jenis }}">{{ $jenis }}</option>
                                            @endforeach
                                        </select>
                                        @error('id_master_limbah')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-4 row g-2 align-items-center">
                                    <label class="col-sm-4 col-form-label text-muted fw-semibold small text-uppercase">Sifat Limbah B3 <span class="text-danger">*</span></label>
                                    <div class="col-sm-8">
                                        <select class="form-select px-3 py-2 shadow-sm" id="selectSifatLimbah" disabled>
                                            <option value="" selected disabled>Pilih jenis limbah dahulu</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="mb-4 row g-2 align-items-center">
                                    <label class="col-sm-4 col-form-label text-muted fw-semibold small text-uppercase">Kode</label>
                                    <div class="col-sm-8">
                                        <input type="text" id="inputKodeLimbah"
                                            class="form-control bg-light border-0 px-3 py-2 font-monospace text-uppercase fw-semibold"
                                            value="" placeholder="(Otomatis terisi)" readonly>
                                        <small class="text-muted mt-1 d-block"><i class="fas fa-info-circle me-1"></i> Kode terisi otomatis dari jenis &amp; sifat limbah</small>
                                    </div>
                                </div>

                                <div class="mb-4 row g-2 align-items-center">
                                    <label class="col-sm-4 col-form-label text-muted fw-semibold small text-uppercase">Berat Limbah B3 <span class="text-danger">*</span></label>
                                    <div class="col-sm-8">
                                        <div class="input-group shadow-sm">
                                            <input type="number" step="0.01" min="0.01"
                                                class="form-control px-3 py-2 @error('jumlah_limbah') is-invalid @enderror"
                                                name="jumlah_limbah" value="{{ old('jumlah_limbah') }}" placeholder="0">
                                            <span class="input-group-text bg-light fw-bold text-secondary">TON</span>
                                            @error('jumlah_limbah')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <small class="text-muted mt-1 d-block"><i class="fas fa-info-circle me-1"></i> Gunakan titik (.) untuk desimal</small>
                                    </div>
                                </div>

                                <div class="mb-4 row g-2 align-items-center">
                                    <label class="col-sm-4 col-form-label text-muted fw-semibold small text-uppercase">Jumlah Kemasan</label>
                                    <div class="col-sm-8">
                                        <div class="input-group shadow-sm">
                                            <input type="number" class="form-control px-3 py-2" name="jumlah_kemasan"
                                                value="{{ old('jumlah_kemasan') }}" placeholder="0">
                                            <span class="input-group-text bg-light fw-bold text-secondary">PLASTIK/DOS</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-4 row g-2 align-items-center">
                                    <label class="col-sm-4 col-form-label text-muted fw-semibold small text-uppercase">Tanggal Keluar</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control bg-light border-0 fw-medium px-3 py-2"
                                            value="{{ now()->translatedFormat('d F Y') }}" readonly>
                                    </div>
                                </div>

                                <h6 class="fw-bold text-success text-uppercase border-bottom pb-3 mb-4 mt-5 d-flex align-items-center">
                                    <i class="fas fa-truck me-2"></i> Data Transporter & Kendaraan
                                </h6>

                                @if ($transporterList->isEmpty())
                                    <div class="alert alert-warning rounded-3 mb-4">
                                        <i class="fas fa-exclamation-triangle me-2"></i>
                                        Belum ada kontrak aktif dengan transporter manapun.
                                        <a href="{{ route('penghasil.kontrak') }}" class="fw-bold">Lihat halaman kontrak.</a>
                                    </div>
                                @endif

                                <div class="mb-4 row g-2 align-items-center">
                                    <label class="col-sm-4 col-form-label text-muted fw-semibold small text-uppercase">Nama Transporter <span class="text-danger">*</span></label>
                                    <div class="col-sm-8">
                                        <select class="form-select px-3 py-2 shadow-sm @error('id_transporter') is-invalid @enderror"
                                            name="id_transporter" id="selectTransporter">
                                            <option value="" selected disabled>Pilih Transporter</option>
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
                                    <label class="col-sm-4 col-form-label text-muted fw-semibold small text-uppercase">Nama Driver</label>
                                    <div class="col-sm-8">
                                        <input type="text" id="inputNamaDriver"
                                            class="form-control px-3 py-2 shadow-sm @error('nama_driver') is-invalid @enderror"
                                            name="nama_driver" value="{{ old('nama_driver') }}" placeholder="(Otomatis terisi)">
                                        @error('nama_driver')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-4 row g-2 align-items-center">
                                    <label class="col-sm-4 col-form-label text-muted fw-semibold small text-uppercase">Jenis Kendaraan</label>
                                    <div class="col-sm-8">
                                        <input type="text"
                                            class="form-control px-3 py-2 shadow-sm @error('jenis_kendaraan') is-invalid @enderror"
                                            name="jenis_kendaraan" value="{{ old('jenis_kendaraan') }}" placeholder="Contoh: Box, Tangki, Van">
                                        @error('jenis_kendaraan')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-5 row g-2 align-items-center">
                                    <label class="col-sm-4 col-form-label text-muted fw-semibold small text-uppercase">Nomor Kendaraan</label>
                                    <div class="col-sm-8">
                                        <input type="text"
                                            class="form-control px-3 py-2 shadow-sm font-monospace text-uppercase @error('no_kendaraan') is-invalid @enderror"
                                            name="no_kendaraan" value="{{ old('no_kendaraan') }}" placeholder="Contoh: DD 1234 XX">
                                        @error('no_kendaraan')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="text-end">
                                    <button type="submit" class="btn btn-primary fw-bold rounded-pill px-5 shadow-sm">
                                        <i class="fas fa-paper-plane me-2"></i> Simpan Data
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                {{-- ===================== TABEL TAB ===================== --}}
                <div class="tab-pane fade {{ request('tab') === 'tabel' ? 'show active' : '' }}" id="tabel" role="tabpanel" aria-labelledby="tabel-tab">

                    {{-- Filter --}}
                    <form method="GET" action="{{ route('penghasil.limbah') }}">
                        <input type="hidden" name="tab" value="tabel">
                        <div class="bg-light p-4 rounded-4 mb-4 border">
                            <h6 class="fw-bold mb-3 d-flex align-items-center text-dark">
                                <i class="fas fa-filter me-2 text-primary"></i> Filter Data
                            </h6>
                            <div class="row g-3 align-items-end">
                                <div class="col-md-3">
                                    <label class="form-label text-muted fw-semibold small">KODE LIMBAH</label>
                                    <input type="text" class="form-control shadow-sm" name="kode"
                                        value="{{ request('kode') }}" placeholder="Contoh: A337-1">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label text-muted fw-semibold small">TANGGAL KELUAR</label>
                                    <div class="input-group shadow-sm">
                                        <input type="date" class="form-control" name="dari" value="{{ request('dari') }}">
                                        <span class="input-group-text bg-white border-start-0 border-end-0">s/d</span>
                                        <input type="date" class="form-control" name="sampai" value="{{ request('sampai') }}">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label text-muted fw-semibold small">TRANSPORTER</label>
                                    <input type="text" class="form-control shadow-sm" name="transporter"
                                        value="{{ request('transporter') }}" placeholder="Nama transporter">
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label text-muted fw-semibold small">URUTKAN</label>
                                    <select class="form-select shadow-sm" name="sort">
                                        <option value="terbaru" {{ request('sort', 'terbaru') === 'terbaru' ? 'selected' : '' }}>Terbaru</option>
                                        <option value="lama" {{ request('sort') === 'lama' ? 'selected' : '' }}>Terlama</option>
                                        <option value="az" {{ request('sort') === 'az' ? 'selected' : '' }}>Kode A-Z</option>
                                        <option value="za" {{ request('sort') === 'za' ? 'selected' : '' }}>Kode Z-A</option>
                                    </select>
                                </div>
                                <div class="col-md-12 d-flex gap-2 justify-content-end">
                                    <button type="submit" class="btn btn-primary fw-bold shadow-sm rounded-pill px-4">
                                        <i class="fas fa-search me-1"></i> Terapkan
                                    </button>
                                    <a href="{{ route('penghasil.limbah', ['tab' => 'tabel']) }}"
                                        class="btn btn-light fw-bold shadow-sm rounded-pill border px-4">
                                        <i class="fas fa-redo me-1"></i> Reset
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>

                    <div class="table-responsive rounded-3 shadow-sm border mb-4">
                        <table class="table table-hover table-striped mb-0 align-middle">
                            <thead class="table-light text-center">
                                <tr>
                                    <th rowspan="2" class="align-middle" style="width:80px;">Aksi</th>
                                    <th rowspan="2" class="align-middle text-nowrap">Tgl Keluar</th>
                                    <th rowspan="2" class="align-middle text-nowrap">Nama Transporter</th>
                                    <th colspan="2" class="align-middle">Limbah B3</th>
                                    <th rowspan="2" class="align-middle">Kode</th>
                                    <th rowspan="2" class="align-middle">Jumlah</th>
                                    <th colspan="3" class="align-middle">Kendaraan</th>
                                    <th rowspan="2" class="align-middle">Aksi</th>
                                    <th rowspan="2" class="align-middle">Status</th>
                                </tr>
                                <tr>
                                    <th class="text-nowrap border-top-0">Jenis</th>
                                    <th class="text-nowrap border-top-0">Sifat</th>
                                    <th class="text-nowrap border-top-0">Jenis</th>
                                    <th class="text-nowrap border-top-0">Nomor</th>
                                    <th class="text-nowrap border-top-0">Driver</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                @forelse ($dataLimbah as $limbah)
                                    <tr>
                                        <td>
                                            @if ($limbah->status === 'Rencana')
                                                <form action="{{ route('penghasil.limbah.destroy', $limbah->id_limbah) }}"
                                                    method="POST" class="d-inline form-hapus">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="btn btn-sm btn-outline-danger rounded-pill px-2" title="Hapus">
                                                        <i class="fas fa-trash me-1"></i><small>Hapus</small>
                                                    </button>
                                                </form>
                                            @else
                                                <span class="text-muted small">—</span>
                                            @endif
                                        </td>
                                        <td class="text-nowrap">
                                            {{ $limbah->tgl_rencana?->format('d M Y') ?? '-' }}
                                        </td>
                                        <td class="text-nowrap fw-medium">
                                            {{ $limbah->transporter->informasiTransporter->nama_transporter ?? ($limbah->transporter->nama_user ?? '-') }}
                                        </td>
                                        <td class="text-nowrap">{{ $limbah->jenis_limbah ?? '-' }}</td>
                                        <td class="text-nowrap">{{ $limbah->sifat_limbah ?? '-' }}</td>
                                        <td>
                                            <span class="badge bg-light text-dark border font-monospace">
                                                {{ $limbah->kode_limbah ?? '-' }}
                                            </span>
                                        </td>
                                        <td class="fw-bold text-nowrap">
                                            {{ $limbah->jumlah_limbah }} {{ $limbah->satuan }}
                                        </td>
                                        <td class="text-nowrap">{{ $limbah->jenis_kendaraan ?? '-' }}</td>
                                        <td class="font-monospace text-nowrap">{{ $limbah->no_kendaraan ?? '-' }}</td>
                                        <td class="text-nowrap">{{ $limbah->nama_driver ?? '-' }}</td>
                                        <td>
                                            {{-- Placeholder tombol Label / dokumen --}}
                                            <button class="btn btn-sm btn-outline-primary rounded-pill px-3" disabled title="Belum tersedia">
                                                <i class="fas fa-tag me-1"></i> Label
                                            </button>
                                        </td>
                                        <td>
                                            @php
                                                $badge = match($limbah->status) {
                                                    'Rencana'         => 'bg-secondary',
                                                    'Terangkut'       => 'bg-info text-dark',
                                                    'Diterima'        => 'bg-primary',
                                                    'Terolah'         => 'bg-warning text-dark',
                                                    'Telah Setor PAD' => 'bg-dark',
                                                    default           => 'bg-light text-dark border',
                                                };
                                            @endphp
                                            <span class="badge rounded-pill px-3 {{ $badge }}">
                                                {{ $limbah->status }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="12" class="text-center py-5 text-muted">
                                            <i class="fas fa-folder-open fa-2x mb-2 d-block opacity-50"></i>
                                            Belum ada data limbah.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-center mb-2">
                        {{ $dataLimbah->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {

            // ── Tab Management ──
            document.querySelectorAll('#limbahTab button').forEach(function (triggerEl) {
                triggerEl.addEventListener('shown.bs.tab', function (event) {
                    document.querySelectorAll('#limbahTab button').forEach(function (el) {
                        el.style.borderBottomColor = 'transparent';
                        el.classList.remove('text-dark');
                        el.classList.add('text-muted');
                    });
                    event.target.style.borderBottomColor = '#0d6efd';
                    event.target.classList.remove('text-muted');
                    event.target.classList.add('text-dark');
                });
            });

            // ── AJAX Auto-fill Driver dari Transporter ──
            const selectTransporter = document.getElementById('selectTransporter');
            const inputNamaDriver   = document.getElementById('inputNamaDriver');

            if (selectTransporter) {
                selectTransporter.addEventListener('change', function () {
                    const id = this.value;
                    if (!id || !inputNamaDriver) { return; }

                    fetch(`{{ url('/penghasil/limbah/transporter') }}/${id}/info`, {
                        credentials: 'same-origin',
                        headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
                    })
                    .then(r => r.json())
                    .then(data => {
                        inputNamaDriver.value = data.nama_driver || '';
                    })
                    .catch(() => {});
                });
            }

            // ── Kode Limbah Otomatis dari Jenis & Sifat ──
            const masterLimbah = @json($masterLimbahJson);

            const selectJenis  = document.getElementById('selectJenisLimbah');
            const selectSifat  = document.getElementById('selectSifatLimbah');
            const inputKode    = document.getElementById('inputKodeLimbah');
            const inputMaster  = document.getElementById('inputMasterLimbah');

            if (selectJenis && selectSifat) {
                selectJenis.addEventListener('change', function () {
                    const jenis = this.value;
                    selectSifat.innerHTML = '<option value="" selected disabled>Pilih sifat limbah</option>';
                    inputKode.value = '';
                    inputMaster.value = '';

                    masterLimbah
                        .filter(m => m.jenis === jenis)
                        .forEach(m => {
                            const opt = document.createElement('option');
                            opt.value = m.id;
                            opt.textContent = m.sifat;
                            opt.dataset.kode = m.kode;
                            selectSifat.appendChild(opt);
                        });

                    selectSifat.disabled = false;
                });

                selectSifat.addEventListener('change', function () {
                    const selected = this.options[this.selectedIndex];
                    inputMaster.value = this.value;
                    inputKode.value = selected ? (selected.dataset.kode || '') : '';
                });
            }

            // ── Konfirmasi hapus ──
            document.querySelectorAll('.form-hapus').forEach(function (form) {
                form.addEventListener('submit', function (e) {
                    e.preventDefault();
                    if (confirm('Yakin ingin menghapus data rencana limbah ini?')) {
                        form.submit();
                    }
                });
            });

        });
    </script>
@endsection
