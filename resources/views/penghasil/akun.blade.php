@extends('layouts.app')

@section('title', 'Pengaturan Akun')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold"><i class="fas fa-user-cog me-2"></i> PENGATURAN AKUN</h4>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body p-4 p-md-5">
            <form>
                <div class="row">
                    <div class="col-md-6 border-end pe-md-5">
                        <h5 class="fw-bold text-primary mb-4">DATA LOGIN</h5>
                        <div class="mb-3">
                            <label class="form-label fw-bold">USERNAME</label>
                            <input type="text" class="form-control" value="penghasil_user" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">NAMA PENGHASIL</label>
                            <input type="text" class="form-control" value="PT. PENGHASIL CONTOH">
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">EMAIL NOTIFIKASI</label>
                            <input type="email" class="form-control" value="admin@penghasil.com">
                        </div>
                    </div>

                    <div class="col-md-6 ps-md-5">
                        <h5 class="fw-bold text-danger mb-4">GANTI PASSWORD</h5>
                        <div class="alert alert-warning small">
                            <i class="fas fa-info-circle me-1"></i> Kosongkan jika tidak ingin mengubah password.
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">PASSWORD BARU</label>
                            <input type="password" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">ULANGI PASSWORD</label>
                            <input type="password" class="form-control">
                        </div>
                    </div>
                </div>

                <hr class="my-4">

                <div class="d-flex justify-content-end gap-2">
                    <button type="reset" class="btn btn-outline-secondary px-4">BATAL</button>
                    <button type="submit" class="btn btn-primary px-4 fw-bold">SIMPAN PERUBAHAN</button>
                </div>
            </form>
        </div>
    </div>
@endsection
