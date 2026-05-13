@extends('layouts.app')

@section('title', 'Setor RETRIBUSI')

@section('content')
    <div class="container-fluid py-4 px-0 ">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold mb-0 text-uppercase text-dark">SETOR RETRIBUSI</h4>
            <a href="#" class="btn btn-outline-dark btn-sm">
                <i class="fas fa-arrow-left me-1"></i> KEMBALI
            </a>
        </div>
        <div class="card shadow-sm border-0 p-3">
            <div class="row">
                <div class="col-lg-8 col-xl-7">
                    <form action="#" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row mb-4 align-items-center">
                            <label class="col-12 col-md-4 col-form-label fw-bold fs-5 text-dark">Nomor Manifest</label>
                            <div class="col-12 col-md-8">
                                <input type="text" class="form-control rounded-0 py-2 text-dark"
                                       value="Otomatis" readonly>
                            </div>
                        </div>

                        <div class="row mb-4 align-items-center">
                            <label class="col-12 col-md-4 col-form-label fw-bold fs-5 text-dark">Tanggal input</label>
                            <div class="col-12 col-md-8">
                                <input type="text" class="form-control rounded-0 py-2"
                                       placeholder="Pencarian tanggal otomatis">
                            </div>
                        </div>

                        <div class="row mb-4 align-items-center">
                            <label class="col-12 col-md-4 col-form-label fw-bold fs-5 text-dark">Nomor bukti
                                setor</label>
                            <div class="col-12 col-md-8">
                                <input type="text" class="form-control rounded-0 py-2">
                            </div>
                        </div>

                        <div class="row mb-4 align-items-center">
                            <label class="col-12 col-md-4 col-form-label fw-bold fs-5 text-dark">Tanggal bukti
                                setor</label>
                            <div class="col-12 col-md-8">
                                <input type="date" class="form-control rounded-0 py-2 text-muted"
                                       title="Pencarian tanggal otomatis">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-12 col-md-4 col-form-label fw-bold fs-5 text-dark pt-md-2">Upload Bukti
                                Setor</label>
                            <div class="col-12 col-md-8">
                                <input type="file" class="form-control rounded-0 py-2">
                                <div class="form-text text-dark mt-2 fw-medium" style="font-size: 0.95rem;">
                                    Maksimal 2MB, format gambar (JPG, PNG dan GIF)
                                </div>
                            </div>
                        </div>

                        <div class="row mt-5">
                            <div class="col-12 col-md-8 offset-md-4">
                                <button type="submit"
                                        class="btn btn-outline-success rounded-0 px-5 py-2 fw-bold fs-5 w-100 w-md-auto">
                                    <i class="fas fa-check me-2"></i> SIMPAN
                                </button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
