@extends('layouts.app')

@section('title', 'Pengaturan Akun')

@section('content')
    <style>
        /* Efek hover untuk tombol */
        .hover-lift {
            transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
        }

        .hover-lift:hover {
            transform: translateY(-3px);
            box-shadow: 0 .5rem 1rem rgba(0, 0, 0, .15) !important;
        }
    </style>

    <div class="container-fluid py-4">

        <div class="card border-0 shadow-sm rounded-4 mb-4 bg-white overflow-hidden">
            <div
                class="card-body p-4 d-flex flex-column flex-md-row align-items-md-center border-start border-5 border-primary">

                <div
                    class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex justify-content-center align-items-center me-3"
                    style="width: 50px; height: 50px;">
                    <i class="fas fa-user-cog fs-4"></i>
                </div>

                <div class="me-auto mt-3 mt-md-0">
                    <h4 class="fw-bold mb-0 text-dark">Pengaturan Akun</h4>
                    <p class="text-muted mb-0 small">Perbarui detail profil dan kata sandi akun Anda</p>
                </div>

                <div class="mt-4 mt-md-0">
                    <a href="{{ url()->previous() }}"
                       class="btn btn-light rounded-pill fw-bold px-4 py-2 hover-lift text-dark border">
                        <i class="fas fa-arrow-left me-2"></i> Kembali
                    </a>
                </div>

            </div>
        </div>

        <form action="{{ route('akun.update') }}" method="POST">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-lg-7 mb-4">
                    <div class="card border-0 shadow-sm rounded-4 h-100">
                        <div class="card-body p-4 p-md-5">

                            <div class="d-flex align-items-center mb-4 pb-3 border-bottom border-2 border-light">
                                <i class="fas fa-id-card-alt fs-4 text-primary me-3"></i>
                                <h5 class="fw-bold mb-0 text-dark text-uppercase">Informasi Profil</h5>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-bold text-muted small text-uppercase">Nama Lengkap Admin
                                    <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 text-muted"><i
                                            class="fas fa-user"></i></span>
                                    <input type="text" class="form-control border-start-0 bg-light py-2"
                                           name="nama_user" value="{{ old('nama_user', $user->nama_user) }}" required>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-bold text-muted small text-uppercase">Username <span
                                        class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 text-muted"><i
                                            class="fas fa-at"></i></span>
                                    <input type="text" class="form-control border-start-0 bg-light py-2" name="username"
                                           value="{{ old('username', $user->username) }}" required>
                                </div>
                            </div>

                            <div class="mb-2">
                                <label class="form-label fw-bold text-muted small text-uppercase">Alamat Email <span
                                        class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 text-muted"><i
                                            class="fas fa-envelope"></i></span>
                                    <input type="email" class="form-control border-start-0 bg-light py-2" name="email"
                                           value="{{ old('email', $user->email) }}" required>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="col-lg-5 mb-4">
                    <div class="card border-0 shadow-sm rounded-4 h-100">
                        <div class="card-body p-4 p-md-5">

                            <div class="d-flex align-items-center mb-4 pb-3 border-bottom border-2 border-light">
                                <i class="fas fa-lock fs-4 text-danger me-3"></i>
                                <h5 class="fw-bold mb-0 text-dark text-uppercase">Keamanan</h5>
                            </div>

                            <div
                                class="alert alert-warning border-0 border-start border-warning border-4 bg-warning bg-opacity-10 text-dark mb-4"
                                role="alert">
                                <i class="fas fa-info-circle me-2 text-warning"></i>
                                <span class="small">Kosongkan kolom di bawah ini jika Anda <strong>tidak ingin</strong> mengubah password.</span>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-bold text-muted small text-uppercase">Password Baru</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 text-muted"><i
                                            class="fas fa-key"></i></span>
                                    <input type="password" class="form-control border-start-0 bg-light py-2"
                                           name="password" placeholder="Masukkan password baru...">
                                </div>
                            </div>

                            <div class="mb-2">
                                <label class="form-label fw-bold text-muted small text-uppercase">Ulangi Password
                                    Baru</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 text-muted"><i
                                            class="fas fa-check-double"></i></span>
                                    <input type="password" class="form-control border-start-0 bg-light py-2"
                                           name="password_confirmation" placeholder="Ketik ulang password baru...">
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm rounded-4 bg-light">
                <div class="card-body p-4 d-flex justify-content-end gap-3">
                    <button type="reset" class="btn btn-outline-secondary rounded-pill fw-bold px-4 hover-lift">
                        <i class="fas fa-undo me-2"></i> Reset
                    </button>
                    <button type="submit"
                            class="btn btn-primary bg-gradient rounded-pill fw-bold px-5 shadow-sm hover-lift text-white border-0">
                        <i class="fas fa-save me-2"></i> Simpan Perubahan
                    </button>
                </div>
            </div>

        </form>
    </div>
@endsection
