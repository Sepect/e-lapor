@extends('layouts.app')

@section('title', 'Pengangkutan Limbah B3')

@section('content')
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-2 mb-4">
        <h4 class="fw-bold mb-0 text-dark d-flex align-items-center">
            <div class="bg-primary bg-opacity-10 text-primary p-2 rounded-circle me-3 d-inline-flex justify-content-center align-items-center" style="width: 45px; height: 45px;">
                <i class="fas fa-truck-moving"></i>
            </div>
            Pengangkutan Limbah B3
        </h4>
        <a href="{{ route('transporter.dashboard') }}" class="btn btn-light fw-semibold rounded-pill px-4 shadow-sm border">
            <i class="fas fa-arrow-left me-2"></i> Kembali
        </a>
    </div>

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
                    <form action="{{ route('transporter.limbah.store') }}" method="POST" id="formTambahLimbah">
                        @csrf
                        <div class="row justify-content-center">
                            <div class="col-12 col-lg-8">

                                {{-- ── BAGIAN 1: Data Limbah ── --}}
                                <h6 class="fw-bold text-primary text-uppercase border-bottom pb-3 mb-4 d-flex align-items-center justify-content-between">
                                    <div><i class="fas fa-file-alt me-2"></i> Data Limbah B3</div>
                                    <button type="submit" class="btn btn-primary fw-bold rounded-pill px-4 shadow-sm btn-sm">
                                        <i class="fas fa-paper-plane me-1"></i> Simpan
                                    </button>
                                </h6>

                                <div class="mb-4 row g-2 align-items-center">
                                    <label class="col-sm-4 col-form-label text-muted fw-semibold small text-uppercase">Nama Penghasil
                                        <span class="text-danger">*</span></label>
                                    <div class="col-sm-8">
                                        <select class="form-select px-3 py-2 shadow-sm @error('id_penghasil') is-invalid @enderror"
                                            name="id_penghasil" id="selectPenghasil">
                                            <option value="" selected disabled>-- Pilih penghasil --</option>
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
                                        @if($penghasilList->isEmpty())
                                            <div class="form-text text-warning">
                                                <i class="fas fa-exclamation-triangle me-1"></i>
                                                Belum ada kontrak aktif. <a href="{{ route('transporter.kontrak') }}">Buat kontrak</a> terlebih dahulu.
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <div class="mb-4 row g-2 align-items-center">
                                    <label class="col-sm-4 col-form-label text-muted fw-semibold small text-uppercase">Kode Limbah B3
                                        <span class="text-danger">*</span></label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control px-3 py-2 shadow-sm font-monospace text-uppercase @error('kode_limbah') is-invalid @enderror"
                                            name="kode_limbah" value="{{ old('kode_limbah') }}" placeholder="Contoh: A337-1">
                                        @error('kode_limbah')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-4 row g-2 align-items-center">
                                    <label class="col-sm-4 col-form-label text-muted fw-semibold small text-uppercase">Jenis Limbah B3</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control px-3 py-2 shadow-sm @error('jenis_limbah') is-invalid @enderror"
                                            name="jenis_limbah" value="{{ old('jenis_limbah') }}" placeholder="Masukkan jenis limbah">
                                        @error('jenis_limbah')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-4 row g-2 align-items-center">
                                    <label class="col-sm-4 col-form-label text-muted fw-semibold small text-uppercase">Sifat Limbah B3</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control px-3 py-2 shadow-sm @error('sifat_limbah') is-invalid @enderror"
                                            name="sifat_limbah" value="{{ old('sifat_limbah') }}" placeholder="Contoh: Infeksius, Kimia, Reaktif">
                                        @error('sifat_limbah')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-4 row g-2 align-items-center">
                                    <label class="col-sm-4 col-form-label text-muted fw-semibold small text-uppercase">Berat Angkut
                                        <span class="text-danger">*</span></label>
                                    <div class="col-sm-8">
                                        <div class="input-group shadow-sm">
                                            <input type="number" step="0.01" min="0.01"
                                                class="form-control px-3 py-2 @error('jumlah_limbah') is-invalid @enderror"
                                                name="jumlah_limbah" value="{{ old('jumlah_limbah') }}" placeholder="0.00">
                                            <select class="form-select" name="satuan" style="max-width: 100px;">
                                                <option value="TON" {{ old('satuan', 'TON') === 'TON' ? 'selected' : '' }}>TON</option>
                                                <option value="KG" {{ old('satuan') === 'KG' ? 'selected' : '' }}>KG</option>
                                                <option value="L" {{ old('satuan') === 'L' ? 'selected' : '' }}>L</option>
                                            </select>
                                            @error('jumlah_limbah')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <small class="text-muted mt-1 d-block"><i class="fas fa-info-circle me-1"></i> Gunakan titik (.) untuk desimal</small>
                                    </div>
                                </div>

                                <div class="mb-4 row g-2 align-items-center">
                                    <label class="col-sm-4 col-form-label text-muted fw-semibold small text-uppercase">Tanggal Angkut
                                        <span class="text-danger">*</span></label>
                                    <div class="col-sm-8">
                                        <input type="date" class="form-control px-3 py-2 shadow-sm @error('tgl_rencana') is-invalid @enderror"
                                            name="tgl_rencana" value="{{ old('tgl_rencana', now()->format('Y-m-d')) }}">
                                        @error('tgl_rencana')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                {{-- ── BAGIAN 2: Data Transporter & Kendaraan ── --}}
                                <h6 class="fw-bold text-success text-uppercase border-bottom pb-3 mb-4 mt-5 d-flex align-items-center">
                                    <i class="fas fa-truck me-2"></i> Data Transporter & Kendaraan
                                </h6>

                                <div class="mb-4 row g-2 align-items-center">
                                    <label class="col-sm-4 col-form-label text-muted fw-semibold small text-uppercase">No. Manifest / Festronik</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control px-3 py-2 shadow-sm font-monospace text-uppercase @error('no_manifest') is-invalid @enderror"
                                            name="no_manifest" value="{{ old('no_manifest') }}" placeholder="Masukkan nomor manifest">
                                        @error('no_manifest')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-4 row g-2 align-items-center">
                                    <label class="col-sm-4 col-form-label text-muted fw-semibold small text-uppercase">Nama Driver</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control px-3 py-2 shadow-sm @error('nama_driver') is-invalid @enderror"
                                            name="nama_driver" value="{{ old('nama_driver', $infoTransporter?->nama_driver) }}"
                                            placeholder="Nama driver pengangkut">
                                        @error('nama_driver')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-4 row g-2 align-items-center">
                                    <label class="col-sm-4 col-form-label text-muted fw-semibold small text-uppercase">Jenis Kendaraan</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control px-3 py-2 shadow-sm @error('jenis_kendaraan') is-invalid @enderror"
                                            name="jenis_kendaraan" value="{{ old('jenis_kendaraan') }}" placeholder="Contoh: Box, Tangki, Van">
                                        @error('jenis_kendaraan')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-4 row g-2 align-items-center">
                                    <label class="col-sm-4 col-form-label text-muted fw-semibold small text-uppercase">Nomor Kendaraan</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control px-3 py-2 shadow-sm font-monospace text-uppercase @error('no_kendaraan') is-invalid @enderror"
                                            name="no_kendaraan" value="{{ old('no_kendaraan') }}" placeholder="Contoh: DD 1234 XX">
                                        @error('no_kendaraan')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-5 row g-2">
                                    <label class="col-sm-4 col-form-label text-muted fw-semibold small text-uppercase">Catatan</label>
                                    <div class="col-sm-8">
                                        <textarea class="form-control px-3 py-2 shadow-sm @error('catatan') is-invalid @enderror"
                                            name="catatan" rows="3" placeholder="Tambahkan catatan jika diperlukan...">{{ old('catatan') }}</textarea>
                                        @error('catatan')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="text-center mt-2 mb-2">
                                    <button type="submit" class="btn btn-primary rounded-pill px-5 py-3 fw-bold shadow-sm d-inline-flex align-items-center fs-5">
                                        <i class="fas fa-save me-2"></i> Simpan Data Pengangkutan
                                    </button>
                                </div>

                            </div>
                        </div>
                    </form>
                </div>

                {{-- ===================== TABEL TAB ===================== --}}
                <div class="tab-pane fade {{ request('tab') === 'tabel' ? 'show active' : '' }}" id="tabel" role="tabpanel" aria-labelledby="tabel-tab">

                    {{-- Filter --}}
                    <form method="GET" action="{{ route('transporter.limbah') }}">
                        <input type="hidden" name="tab" value="tabel">
                        <div class="bg-light p-4 rounded-4 mb-4 border">
                            <h6 class="fw-bold mb-3 d-flex align-items-center text-dark">
                                <i class="fas fa-filter me-2 text-primary"></i> Filtering & Sorting
                            </h6>
                            <div class="row g-3 align-items-end">
                                <div class="col-md-3">
                                    <label class="form-label text-muted fw-semibold small">KODE LIMBAH</label>
                                    <input type="text" class="form-control shadow-sm" name="kode"
                                        value="{{ request('kode') }}" placeholder="Contoh: A337-1">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label text-muted fw-semibold small">TANGGAL ANGKUT</label>
                                    <div class="input-group shadow-sm">
                                        <input type="date" class="form-control" name="dari" value="{{ request('dari') }}">
                                        <span class="input-group-text bg-white border-start-0 border-end-0 fw-bold text-muted">s/d</span>
                                        <input type="date" class="form-control" name="sampai" value="{{ request('sampai') }}">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label text-muted fw-semibold small">NAMA PENGHASIL</label>
                                    <input type="text" class="form-control shadow-sm" name="penghasil"
                                        value="{{ request('penghasil') }}" placeholder="Nama penghasil">
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
                                <div class="col-md-2 d-flex gap-2">
                                    <button type="submit" class="btn btn-primary fw-bold flex-grow-1 shadow-sm rounded-pill">
                                        <i class="fas fa-search me-1"></i> Cari
                                    </button>
                                    <a href="{{ route('transporter.limbah', ['tab' => 'tabel']) }}"
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
                            <thead class="table-light text-center">
                                <tr>
                                    <th rowspan="2" class="align-middle" style="width: 90px;">Aksi</th>
                                    <th rowspan="2" class="align-middle text-nowrap">Tgl Angkut</th>
                                    <th rowspan="2" class="align-middle text-nowrap">Nama Penghasil</th>
                                    <th colspan="3" class="align-middle">Limbah B3</th>
                                    <th rowspan="2" class="align-middle">Jumlah</th>
                                    <th rowspan="2" class="align-middle text-nowrap">No. Manifest</th>
                                    <th colspan="3" class="align-middle">Kendaraan</th>
                                    <th rowspan="2" class="align-middle">Status</th>
                                </tr>
                                <tr>
                                    <th class="text-nowrap border-top-0">Kode</th>
                                    <th class="text-nowrap border-top-0">Jenis</th>
                                    <th class="text-nowrap border-top-0">Sifat</th>
                                    <th class="text-nowrap border-top-0">Jenis</th>
                                    <th class="text-nowrap border-top-0">Nomor</th>
                                    <th class="text-nowrap border-top-0">Driver</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                @forelse($dataLimbah as $limbah)
                                    <tr>
                                        <td>
                                            <div class="d-flex gap-1 justify-content-center">
                                                <a href="{{ route('transporter.edit-limbah', $limbah->id_limbah) }}"
                                                    class="btn btn-sm btn-outline-info  px-2" title="Detail">
                                                    <i class="fas fa-eye me-1"></i>/<i class="fas fa-pencil me-1"></i>
                                                </a>
                                                <form action="{{ route('transporter.limbah.destroy', $limbah->id_limbah) }}" method="POST"
                                                    class="d-inline form-hapus-limbah">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="btn btn-sm btn-outline-danger px-2" title="Hapus">
                                                        <i class="fas fa-trash me-1"></i><small>Hapus</small>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                        <td class="text-nowrap">{{ $limbah->tgl_rencana?->format('d M Y') ?? '-' }}</td>
                                        <td class="text-start fw-medium">
                                            {{ $limbah->penghasil->informasiPenghasil->nama_penghasil ?? ($limbah->penghasil->nama_user ?? '-') }}
                                        </td>
                                        <td><span class="badge bg-light text-dark border font-monospace">{{ $limbah->kode_limbah ?? '-' }}</span></td>
                                        <td class="text-nowrap">{{ $limbah->jenis_limbah ?? '-' }}</td>
                                        <td class="text-nowrap">{{ $limbah->sifat_limbah ?? '-' }}</td>
                                        <td class="fw-bold text-nowrap">{{ $limbah->jumlah_limbah }} {{ $limbah->satuan }}</td>
                                        <td class="font-monospace text-primary fw-semibold">{{ $limbah->no_manifest ?? '-' }}</td>
                                        <td class="text-nowrap">{{ $limbah->jenis_kendaraan ?? '-' }}</td>
                                        <td class="font-monospace text-nowrap">{{ $limbah->no_kendaraan ?? '-' }}</td>
                                        <td class="text-nowrap">{{ $limbah->nama_driver ?? '-' }}</td>
                                        <td>
                                            @if($limbah->status === 'Terangkut')
                                                <span class="badge bg-info text-dark rounded-pill px-3">Terkirim</span>
                                            @elseif($limbah->status === 'Diterima' || $limbah->status === 'Telah Setor PAD')
                                                <span class="badge bg-success rounded-pill px-3">Diterima</span>
                                            @elseif($limbah->status === 'Terolah')
                                                <span class="badge bg-warning text-dark rounded-pill px-3">Terolah</span>
                                            @elseif($limbah->status === 'Rencana')
                                                <span class="badge bg-secondary rounded-pill px-3">Rencana</span>
                                            @else
                                                <span class="badge bg-light text-dark border rounded-pill px-3">{{ $limbah->status }}</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="12" class="text-center py-5 text-muted">
                                            <i class="fas fa-folder-open fa-2x mb-2 d-block opacity-50"></i>
                                            Belum ada data pengangkutan limbah.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-center mb-4">
                        {{ $dataLimbah->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {

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

            // ── Konfirmasi hapus ──
            document.querySelectorAll('.form-hapus-limbah').forEach(function (form) {
                form.addEventListener('submit', function (e) {
                    e.preventDefault();
                    if (confirm('Yakin ingin menghapus data limbah ini? Data tidak dapat dikembalikan.')) {
                        form.submit();
                    }
                });
            });

        });
    </script>
@endsection
