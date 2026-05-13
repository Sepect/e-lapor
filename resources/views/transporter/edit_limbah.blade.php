@extends('layouts.app')

@section('title', 'Edit Pengangkutan Limbah B3')

@section('content')
    @php
        $steps = [
            1 => 'Rencana',
            2 => 'Terangkut',
            3 => 'Diterima',
            4 => 'Terolah',
            5 => 'Telah Setor PAD',
        ];
        $statusMap = [
            'Rencana'       => 1,
            'Terangkut'     => 2,
            'Diterima'      => 3,
            'Terolah'       => 4,
            'Telah Setor PAD' => 5,
        ];
        $currentStep = $statusMap[$dataLimbah->status] ?? 1;
    @endphp

    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-2 mb-4">
        <h4 class="fw-bold mb-0 text-dark d-flex align-items-center">
            <div class="bg-primary bg-opacity-10 text-primary p-2 rounded-circle me-3 d-inline-flex justify-content-center align-items-center" style="width: 45px; height: 45px;">
                <i class="far fa-arrow-alt-circle-right"></i>
            </div>
            Pengangkutan Limbah B3
        </h4>
        <a href="{{ route('transporter.limbah', ['tab' => 'tabel']) }}" class="btn btn-light fw-semibold rounded-pill px-4 shadow-sm border">
            <i class="fas fa-arrow-left me-2"></i> Kembali
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-3 mb-4" role="alert">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card border-0 shadow-sm rounded-4 mb-5">
        <div class="card-body p-4 p-lg-5">

            <!-- Bootstrap Stepper -->
            <div class="position-relative mb-5 mt-3 px-2">
                <div class="d-flex justify-content-between align-items-start position-relative">
                    {{-- connecting line --}}
                    <div class="position-absolute top-0 start-0 end-0 d-flex align-items-start" style="padding-top: 22px; z-index: 0;">
                        <div class="flex-grow-1 mx-5" style="height: 3px; background: #e9ecef;"></div>
                    </div>

                    @foreach ($steps as $num => $label)
                        @php
                            $isDone    = $num < $currentStep;
                            $isActive  = $num === $currentStep;
                            $iconBg    = $isDone ? 'bg-success text-white border-success' : ($isActive ? 'bg-primary text-white border-primary' : 'bg-white text-secondary border-secondary-subtle');
                            $labelColor = $isDone ? 'text-success' : ($isActive ? 'text-primary fw-bold' : 'text-muted');
                        @endphp
                        <div class="d-flex flex-column align-items-center text-center position-relative" style="z-index: 1; width: 90px;">
                            <div class="rounded-circle border d-flex align-items-center justify-content-center fw-bold mb-2 {{ $iconBg }}" style="width: 46px; height: 46px; font-size: 1rem;">
                                @if ($isDone)
                                    <i class="fas fa-check"></i>
                                @else
                                    {{ $num }}
                                @endif
                            </div>
                            <small class="fw-semibold text-uppercase lh-sm {{ $labelColor }}" style="font-size: 0.72rem;">{{ $label }}</small>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Detail Limbah -->
            <div class="row g-4 mb-5">
                <div class="col-lg-6">
                    <div class="bg-light rounded-4 p-4 h-100 border">
                        <h6 class="fw-bold text-primary text-uppercase border-bottom pb-3 mb-4 d-flex align-items-center">
                            <i class="fas fa-info-circle me-2"></i> Detail Limbah
                        </h6>

                        <div class="mb-3">
                            <label class="form-label text-muted fw-semibold small text-uppercase">Nama Penghasil</label>
                            <input type="text" class="form-control bg-white"
                                value="{{ $dataLimbah->penghasil->informasiPenghasil->nama_penghasil ?? $dataLimbah->penghasil->nama_user ?? '-' }}" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-muted fw-semibold small text-uppercase">Kode Limbah</label>
                            <input type="text" class="form-control bg-white" value="{{ $dataLimbah->kode_limbah }}" readonly>
                        </div>
                        @if ($dataLimbah->jenis_limbah)
                            <div class="mb-3">
                                <label class="form-label text-muted fw-semibold small text-uppercase">Jenis Limbah</label>
                                <input type="text" class="form-control bg-white" value="{{ $dataLimbah->jenis_limbah }}" readonly>
                            </div>
                        @endif
                        @if ($dataLimbah->sifat_limbah)
                            <div class="mb-3">
                                <label class="form-label text-muted fw-semibold small text-uppercase">Sifat Limbah</label>
                                <input type="text" class="form-control bg-white" value="{{ $dataLimbah->sifat_limbah }}" readonly>
                            </div>
                        @endif
                        <div class="mb-3">
                            <label class="form-label text-muted fw-semibold small text-uppercase">Tanggal Rencana Angkut</label>
                            <input type="text" class="form-control bg-white"
                                value="{{ $dataLimbah->tgl_rencana ? \Carbon\Carbon::parse($dataLimbah->tgl_rencana)->format('d M Y') : '-' }}" readonly>
                        </div>
                        @if ($dataLimbah->catatan)
                            <div class="mb-3">
                                <label class="form-label text-muted fw-semibold small text-uppercase">Catatan</label>
                                <textarea class="form-control bg-white" rows="2" readonly>{{ $dataLimbah->catatan }}</textarea>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="bg-light rounded-4 p-4 h-100 border">
                        <h6 class="fw-bold text-success text-uppercase border-bottom pb-3 mb-4 d-flex align-items-center">
                            <i class="fas fa-truck me-2"></i> Data Transportasi
                        </h6>

                        <div class="mb-3">
                            <label class="form-label text-muted fw-semibold small text-uppercase">Nomor Manifest / Festronik</label>
                            <input type="text" class="form-control bg-white font-monospace"
                                value="{{ $dataLimbah->no_manifest ?? '-' }}" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-muted fw-semibold small text-uppercase">Jenis Kendaraan</label>
                            <input type="text" class="form-control bg-white"
                                value="{{ $dataLimbah->jenis_kendaraan ?? '-' }}" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-muted fw-semibold small text-uppercase">Nomor Kendaraan</label>
                            <input type="text" class="form-control bg-white font-monospace"
                                value="{{ $dataLimbah->no_kendaraan ?? '-' }}" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-muted fw-semibold small text-uppercase">Nama Driver</label>
                            <input type="text" class="form-control bg-white"
                                value="{{ $dataLimbah->nama_driver ?? '-' }}" readonly>
                        </div>
                        <div class="mb-0">
                            <label class="form-label text-muted fw-semibold small text-uppercase">Status</label>
                            <div>
                                @php
                                    $badgeColor = match($dataLimbah->status) {
                                        'Rencana'         => 'bg-warning text-dark',
                                        'Terangkut'       => 'bg-info text-dark',
                                        'Diterima'        => 'bg-primary',
                                        'Terolah'         => 'bg-success',
                                        'Telah Setor PAD' => 'bg-dark',
                                        default           => 'bg-secondary',
                                    };
                                @endphp
                                <span class="badge rounded-pill {{ $badgeColor }} px-3 py-2">{{ $dataLimbah->status }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Berita Acara Form (only when still Rencana or already Terangkut) --}}
            @if (in_array($dataLimbah->status, ['Rencana', 'Terangkut']))
                <h5 class="fw-bold text-center text-uppercase mb-4 mt-2">
                    <span class="border-bottom border-3 border-primary pb-2">Penandatanganan Berita Acara</span>
                </h5>

                @if ($errors->any())
                    <div class="alert alert-danger rounded-3 mb-4">
                        <ul class="mb-0 ps-3">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="row justify-content-center">
                    <div class="col-lg-10">
                        <form action="{{ route('transporter.limbah.berita-acara', $dataLimbah->id_limbah) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="card border border-light-subtle shadow-sm rounded-4">
                                <div class="card-body p-4 p-md-5">

                                    <div class="row mb-4 align-items-center">
                                        <label class="col-md-3 form-label text-muted fw-semibold small text-uppercase">Jumlah Limbah</label>
                                        <div class="col-md-9">
                                            <div class="input-group">
                                                <input type="number" step="0.01" class="form-control @error('jumlah_limbah') is-invalid @enderror"
                                                    name="jumlah_limbah"
                                                    value="{{ old('jumlah_limbah', $dataLimbah->jumlah_limbah) }}"
                                                    required min="0.01">
                                                <span class="input-group-text bg-white fw-bold text-secondary">{{ $dataLimbah->satuan }}</span>
                                                @error('jumlah_limbah')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mb-4 align-items-center">
                                        <label class="col-md-3 form-label text-muted fw-semibold small text-uppercase">Tanggal Penyerahan</label>
                                        <div class="col-md-9">
                                            <input type="date" class="form-control @error('tgl_penyerahan') is-invalid @enderror"
                                                name="tgl_penyerahan"
                                                value="{{ old('tgl_penyerahan', optional($dataLimbah->beritaAcara)->tgl_penyerahan ? \Carbon\Carbon::parse($dataLimbah->beritaAcara->tgl_penyerahan)->format('Y-m-d') : date('Y-m-d')) }}"
                                                required>
                                            @error('tgl_penyerahan')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <hr class="my-4 text-muted">
                                    <p class="fw-semibold text-muted text-uppercase small mb-3">Pihak Penyerah (Transporter)</p>

                                    <div class="row mb-4 align-items-center">
                                        <label class="col-md-3 form-label text-muted fw-semibold small text-uppercase">Nama Lengkap</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control @error('ba_nama') is-invalid @enderror"
                                                name="ba_nama"
                                                value="{{ old('ba_nama', optional($dataLimbah->beritaAcara)->nama_penyerah) }}"
                                                placeholder="Masukkan nama penandatangan" required>
                                            @error('ba_nama')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mb-4 align-items-center">
                                        <label class="col-md-3 form-label text-muted fw-semibold small text-uppercase">Alamat</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control @error('ba_alamat') is-invalid @enderror"
                                                name="ba_alamat"
                                                value="{{ old('ba_alamat', optional($dataLimbah->beritaAcara)->alamat_penyerah) }}"
                                                placeholder="Masukkan alamat">
                                            @error('ba_alamat')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mb-4 align-items-center">
                                        <label class="col-md-3 form-label text-muted fw-semibold small text-uppercase">Jabatan</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control @error('ba_jabatan') is-invalid @enderror"
                                                name="ba_jabatan"
                                                value="{{ old('ba_jabatan', optional($dataLimbah->beritaAcara)->jabatan_penyerah) }}"
                                                placeholder="Masukkan jabatan">
                                            @error('ba_jabatan')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <hr class="my-4 text-muted">

                                    <div class="row mb-4">
                                        <label class="col-md-3 form-label text-muted fw-semibold small text-uppercase pt-2">Tandatangan</label>
                                        <div class="col-md-9">
                                            @if (optional($dataLimbah->beritaAcara)->tandatangan_penyerah)
                                                <div class="mb-2">
                                                    <img src="{{ asset('storage/' . $dataLimbah->beritaAcara->tandatangan_penyerah) }}"
                                                        alt="Tandatangan" class="img-thumbnail" style="max-height: 80px;">
                                                </div>
                                            @endif
                                            <input type="file" class="form-control @error('tandatangan') is-invalid @enderror"
                                                name="tandatangan" accept="image/jpeg,image/png,image/gif">
                                            <div class="form-text"><i class="fas fa-info-circle me-1"></i> Maks 2MB. Format JPG, PNG, GIF.</div>
                                            @error('tandatangan')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mb-4">
                                        <label class="col-md-3 form-label text-muted fw-semibold small text-uppercase pt-2">Stempel</label>
                                        <div class="col-md-9">
                                            @if (optional($dataLimbah->beritaAcara)->stempel_penyerah)
                                                <div class="mb-2">
                                                    <img src="{{ asset('storage/' . $dataLimbah->beritaAcara->stempel_penyerah) }}"
                                                        alt="Stempel" class="img-thumbnail" style="max-height: 80px;">
                                                </div>
                                            @endif
                                            <input type="file" class="form-control @error('stempel') is-invalid @enderror"
                                                name="stempel" accept="image/jpeg,image/png,image/gif">
                                            <div class="form-text"><i class="fas fa-info-circle me-1"></i> Maks 2MB. Format JPG, PNG, GIF.</div>
                                            @error('stempel')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="text-center mt-4 mb-2">
                                <button type="submit" class="btn btn-primary rounded-pill px-5 py-3 fw-bold shadow-sm d-inline-flex align-items-center">
                                    <i class="fas fa-paper-plane me-2"></i>
                                    {{ $dataLimbah->beritaAcara ? 'Perbarui Berita Acara' : 'Kirim Berita Acara' }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            @else
                <div class="alert alert-info rounded-3 text-center mt-2">
                    <i class="fas fa-info-circle me-2"></i>
                    Status limbah sudah <strong>{{ $dataLimbah->status }}</strong>. Berita acara tidak dapat diubah lagi.
                </div>
            @endif

        </div>
    </div>
@endsection
