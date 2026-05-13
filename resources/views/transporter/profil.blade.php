@extends('layouts.app')

@section('title', 'Profil Transporter')

@section('content')
    <style>
        .hover-lift {
            transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
        }

        .hover-lift:hover {
            transform: translateY(-3px);
            box-shadow: 0 .5rem 1rem rgba(0, 0, 0, .15) !important;
        }

        .form-label-custom {
            font-weight: 700;
            color: #495057;
            text-transform: uppercase;
            font-size: 0.8rem;
            letter-spacing: 0.5px;
        }

        .form-control:focus, .form-select:focus {
            border-color: #0d6efd;
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.15);
        }

        .object-fit-contain {
            object-fit: contain;
        }

        .border-dashed {
            border-style: dashed !important;
        }
    </style>

    <div class="container-fluid py-4">

        <div class="card border-0 shadow-sm rounded-4 mb-4 bg-white overflow-hidden">
            <div class="card-body p-4 d-flex flex-column flex-md-row align-items-md-center border-start border-5 border-primary">
                <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex justify-content-center align-items-center me-3"
                     style="width: 50px; height: 50px;">
                    <i class="fas fa-truck fs-4"></i>
                </div>
                <div class="me-auto mt-3 mt-md-0">
                    <h4 class="fw-bold mb-0 text-dark">Profil Transporter</h4>
                    <p class="text-muted mb-0 small">Kelola informasi perusahaan, kontak, perizinan, dan logo Anda.</p>
                </div>
                <div class="mt-4 mt-md-0">
                    <a href="{{ route('transporter.dashboard') }}"
                       class="btn btn-light rounded-pill fw-bold px-4 py-2 hover-lift text-dark border">
                        <i class="fas fa-arrow-left me-2"></i> Kembali
                    </a>
                </div>
            </div>
        </div>

        <ul class="nav nav-pills mb-4 gap-2" id="profilTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active rounded-pill px-4 fw-bold shadow-sm" data-bs-toggle="pill"
                        data-bs-target="#info" type="button" role="tab">
                    <i class="fas fa-info-circle me-2"></i> Informasi Utama
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link rounded-pill px-4 fw-bold shadow-sm" data-bs-toggle="pill"
                        data-bs-target="#izin" type="button" role="tab">
                    <i class="fas fa-file-contract me-2"></i> Perizinan
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link rounded-pill px-4 fw-bold shadow-sm" data-bs-toggle="pill"
                        data-bs-target="#logo" type="button" role="tab">
                    <i class="fas fa-image me-2"></i> Logo Perusahaan
                </button>
            </li>
        </ul>

        <div class="card border-0 shadow-sm rounded-4 bg-white">
            <div class="card-body p-4 p-lg-5">
                <div class="tab-content" id="profilTabContent">

                    {{-- ── Tab Informasi Utama ───────────────────────────────── --}}
                    <div class="tab-pane fade show active" id="info" role="tabpanel">
                        <form action="{{ route('transporter.profil.informasi') }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="d-flex align-items-center mb-4 pb-2 border-bottom">
                                <i class="fas fa-building text-primary fs-5 me-2"></i>
                                <h5 class="fw-bold mb-0 text-dark">Data Perusahaan</h5>
                            </div>

                            <div class="row g-4 mb-5">
                                <div class="col-md-12">
                                    <label class="form-label form-label-custom">Nama Transporter <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control rounded-3 py-2 bg-light border-0 shadow-sm"
                                           name="nama_transporter" value="{{ $info->nama_transporter ?? '' }}" required>
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label form-label-custom">Alamat Lengkap</label>
                                    <textarea class="form-control rounded-3 py-2 bg-light border-0 shadow-sm" rows="2"
                                              name="alamat_transporter">{{ $info->alamat_transporter ?? '' }}</textarea>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label form-label-custom">Kabupaten / Kota</label>
                                    <input type="text" class="form-control rounded-3 py-2 bg-light border-0 shadow-sm"
                                           name="kota_transporter" value="{{ $info->kota_transporter ?? '' }}">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label form-label-custom">Telp / HP <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control rounded-3 py-2 bg-light border-0 shadow-sm"
                                           name="telepon_transporter" value="{{ $info->telepon_transporter ?? '' }}" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label form-label-custom">Fax</label>
                                    <input type="text" class="form-control rounded-3 py-2 bg-light border-0 shadow-sm"
                                           name="fax_transporter" value="{{ $info->fax_transporter ?? '' }}">
                                </div>
                            </div>

                            <div class="d-flex align-items-center mb-4 pb-2 border-bottom">
                                <i class="fas fa-users text-primary fs-5 me-2"></i>
                                <h5 class="fw-bold mb-0 text-dark">Kontak Person</h5>
                            </div>

                            <div class="row g-4 mb-4">
                                <div class="col-md-6">
                                    <div class="card border-0 bg-primary bg-opacity-10 rounded-4 h-100">
                                        <div class="card-body p-4">
                                            <h6 class="fw-bold text-primary text-center mb-4">
                                                <i class="fas fa-user-tie me-2"></i> PENANGGUNG JAWAB / ADMIN
                                            </h6>
                                            <div class="mb-3">
                                                <label class="form-label form-label-custom text-primary">Nama Lengkap</label>
                                                <input type="text" class="form-control rounded-3 py-2 border-0 shadow-sm"
                                                       name="nama_penanggung_jawab"
                                                       value="{{ $info->nama_penanggung_jawab ?? '' }}">
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label form-label-custom text-primary">Telp / HP</label>
                                                <input type="text" class="form-control rounded-3 py-2 border-0 shadow-sm"
                                                       name="telepon_penanggung_jawab"
                                                       value="{{ $info->telepon_penanggung_jawab ?? '' }}">
                                            </div>
                                            <div class="mb-0">
                                                <label class="form-label form-label-custom text-primary">Email</label>
                                                <input type="email" class="form-control rounded-3 py-2 border-0 shadow-sm"
                                                       name="email_penanggung_jawab"
                                                       value="{{ $info->email_penanggung_jawab ?? '' }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="card border-0 bg-info bg-opacity-10 rounded-4 h-100">
                                        <div class="card-body p-4">
                                            <h6 class="fw-bold text-info text-center mb-4">
                                                <i class="fas fa-id-badge me-2"></i> DATA DRIVER
                                            </h6>
                                            <div class="mb-3">
                                                <label class="form-label form-label-custom text-info">Nama Driver</label>
                                                <input type="text" class="form-control rounded-3 py-2 border-0 shadow-sm"
                                                       name="nama_driver" value="{{ $info->nama_driver ?? '' }}">
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label form-label-custom text-info">Telp / HP</label>
                                                <input type="text" class="form-control rounded-3 py-2 border-0 shadow-sm"
                                                       name="telepon_driver" value="{{ $info->telepon_driver ?? '' }}">
                                            </div>
                                            <div class="mb-0">
                                                <label class="form-label form-label-custom text-info">Email</label>
                                                <input type="email" class="form-control rounded-3 py-2 border-0 shadow-sm"
                                                       name="email_driver" value="{{ $info->email_driver ?? '' }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-end mt-4 pt-3 border-top">
                                <button type="submit"
                                        class="btn btn-primary bg-gradient rounded-pill px-5 py-2 fw-bold shadow-sm hover-lift text-white border-0">
                                    <i class="fas fa-save me-2"></i> Simpan Informasi
                                </button>
                            </div>
                        </form>
                    </div>

                    {{-- ── Tab Perizinan ─────────────────────────────────────── --}}
                    <div class="tab-pane fade" id="izin" role="tabpanel">
                        <form action="{{ route('transporter.profil.perizinan') }}" method="POST"
                              enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="d-flex align-items-center mb-4 pb-2 border-bottom">
                                <i class="fas fa-file-signature text-primary fs-5 me-2"></i>
                                <h5 class="fw-bold mb-0 text-dark">Akta Pendirian / Surat Keputusan</h5>
                            </div>

                            <div class="row g-4 mb-5">
                                <div class="col-md-6">
                                    <label class="form-label form-label-custom">Nomor Akta / SK</label>
                                    <input type="text" class="form-control rounded-3 py-2 bg-light border-0 shadow-sm"
                                           name="no_akta" value="{{ $izin->no_akta ?? '' }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label form-label-custom">Tanggal Terbit</label>
                                    <input type="date" class="form-control rounded-3 py-2 bg-light border-0 shadow-sm"
                                           name="tgl_terbit"
                                           value="{{ !empty($izin->tgl_terbit) ? $izin->tgl_terbit->format('Y-m-d') : '' }}">
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label form-label-custom">Upload File Lampiran Akta</label>
                                    <input type="file" class="form-control rounded-3 py-2 bg-light border-0 shadow-sm"
                                           name="lampiran">
                                    @if(!empty($izin->lampiran))
                                        <div class="mt-3 d-flex align-items-center bg-success bg-opacity-10 p-3 rounded-3 border border-success border-opacity-25">
                                            <i class="fas fa-file-pdf text-success fs-3 me-3"></i>
                                            <div class="me-auto">
                                                <div class="fw-bold text-success small">File Lampiran Tersedia</div>
                                                <div class="text-muted" style="font-size: 0.75rem;">Anda sudah mengunggah file ini sebelumnya.</div>
                                            </div>
                                            <a href="{{ asset('storage/' . $izin->lampiran) }}" target="_blank"
                                               class="btn btn-sm btn-success rounded-pill fw-bold px-4 shadow-sm hover-lift">
                                                <i class="fas fa-download me-1"></i> Lihat / Unduh
                                            </a>
                                        </div>
                                    @endif
                                    <small class="text-muted fst-italic mt-1 d-block">Maksimal 2MB (Word, PDF, Excel)</small>
                                </div>
                            </div>

                            <div class="d-flex align-items-center mb-4 pb-2 border-bottom">
                                <i class="fas fa-leaf text-success fs-5 me-2"></i>
                                <h5 class="fw-bold mb-0 text-dark">Izin Pengangkutan (Perling)</h5>
                            </div>

                            <div class="row g-4 mb-4">
                                <div class="col-md-6">
                                    <label class="form-label form-label-custom">Nomor Perling / Izin Pengangkutan</label>
                                    <input type="text" class="form-control rounded-3 py-2 bg-light border-0 shadow-sm"
                                           name="no_perling" value="{{ $izin->no_perling ?? '' }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label form-label-custom">Tanggal Terbit</label>
                                    <input type="date" class="form-control rounded-3 py-2 bg-light border-0 shadow-sm"
                                           name="tgl_terbit_perling"
                                           value="{{ !empty($izin->tgl_terbit_perling) ? $izin->tgl_terbit_perling->format('Y-m-d') : '' }}">
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label form-label-custom">Masa Berlaku</label>
                                    <div class="input-group shadow-sm rounded-3 overflow-hidden border-0">
                                        <input type="date" class="form-control bg-light border-0 py-2"
                                               name="masa_berlaku_perling_dari"
                                               value="{{ !empty($izin->masa_berlaku_perling_dari) ? $izin->masa_berlaku_perling_dari->format('Y-m-d') : '' }}">
                                        <span class="input-group-text bg-white border-0 fw-bold px-4">S/D</span>
                                        <input type="date" class="form-control bg-light border-0 py-2"
                                               name="masa_berlaku_perling_sampai"
                                               value="{{ !empty($izin->masa_berlaku_perling_sampai) ? $izin->masa_berlaku_perling_sampai->format('Y-m-d') : '' }}">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label form-label-custom">Upload File Lampiran Perling</label>
                                    <input type="file" class="form-control rounded-3 py-2 bg-light border-0 shadow-sm"
                                           name="lampiran_perling">
                                    @if(!empty($izin->lampiran_perling))
                                        <div class="mt-3 d-flex align-items-center bg-success bg-opacity-10 p-3 rounded-3 border border-success border-opacity-25">
                                            <i class="fas fa-file-pdf text-success fs-3 me-3"></i>
                                            <div class="me-auto">
                                                <div class="fw-bold text-success small">File Perling Tersedia</div>
                                                <div class="text-muted" style="font-size: 0.75rem;">Anda sudah mengunggah file ini sebelumnya.</div>
                                            </div>
                                            <a href="{{ asset('storage/' . $izin->lampiran_perling) }}" target="_blank"
                                               class="btn btn-sm btn-success rounded-pill fw-bold px-4 shadow-sm hover-lift">
                                                <i class="fas fa-download me-1"></i> Lihat / Unduh
                                            </a>
                                        </div>
                                    @endif
                                    <small class="text-muted fst-italic mt-1 d-block">Maksimal 2MB (Word, PDF, Excel)</small>
                                </div>
                            </div>

                            <div class="d-flex justify-content-end mt-4 pt-3 border-top">
                                <button type="submit"
                                        class="btn btn-primary bg-gradient rounded-pill px-5 py-2 fw-bold shadow-sm hover-lift text-white border-0">
                                    <i class="fas fa-save me-2"></i> Simpan Data Perizinan
                                </button>
                            </div>
                        </form>
                    </div>

                    {{-- ── Tab Logo ──────────────────────────────────────────── --}}
                    <div class="tab-pane fade" id="logo" role="tabpanel">
                        <form action="{{ route('transporter.profil.logo') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="d-flex flex-column align-items-center justify-content-center text-center py-4">
                                <div class="position-relative mb-4">
                                    <div class="bg-light border-2 border-dashed rounded-circle d-flex align-items-center justify-content-center overflow-hidden shadow-sm p-2"
                                         style="width: 180px; height: 180px; border-color: #dee2e6 !important;">
                                        @if(isset($info->logo_transporter))
                                            <img src="{{ asset('storage/' . $info->logo_transporter) }}"
                                                 alt="Logo Transporter"
                                                 class="w-100 h-100 rounded-circle object-fit-contain">
                                        @else
                                            <div class="text-muted">
                                                <i class="fas fa-image fa-3x mb-2 text-secondary"></i><br>
                                                <small class="fw-bold">No Logo</small>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <div class="w-100" style="max-width: 500px;">
                                    <label class="form-label form-label-custom">Pilih File Logo Perusahaan</label>
                                    <input type="file" class="form-control form-control-lg rounded-pill shadow-sm fs-6"
                                           name="logo_transporter" required accept="image/*">
                                    <small class="text-muted fst-italic mt-2 d-block">Maksimal ukuran 2MB. Format didukung: JPG, PNG, GIF</small>

                                    <button type="submit"
                                            class="btn btn-primary bg-gradient rounded-pill px-5 py-3 fw-bold shadow-sm hover-lift text-white border-0 mt-4 w-100">
                                        <i class="fas fa-cloud-upload-alt me-2"></i> Unggah & Simpan Logo
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
