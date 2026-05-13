@extends('layouts.app')

@section('title', 'Manajemen Pengguna')
@section('subtitle', 'Manajemen Pengguna')

@section('content')
    {{-- Page Header --}}
    <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden">
        <div class="card-body p-4 d-flex flex-column flex-md-row align-items-start align-items-md-center gap-3 bg-white position-relative">
            <!-- Decorative Background -->
            <div class="position-absolute top-0 start-0 w-100 h-100 bg-primary opacity-10" style="pointer-events: none;"></div>
            <div class="position-absolute top-0 start-0 h-100 bg-primary" style="width: 6px;"></div>

            <div class="bg-primary bg-gradient text-white rounded-circle d-flex justify-content-center align-items-center flex-shrink-0 shadow-sm z-1"
                 style="width: 55px; height: 55px;">
                <i class="fas fa-users fs-4"></i>
            </div>
            <div class="flex-grow-1 z-1">
                <h5 class="fw-bold mb-1 text-dark">Manajemen Pengguna</h5>
                <p class="text-muted mb-0 small">Kelola data akun Penghasil dan Transporter dengan mudah dan terorganisir.</p>
            </div>
        </div>
    </div>

    {{-- Tabs --}}
    <ul class="nav nav-pills mb-4 gap-2 bg-white p-2 rounded-pill shadow-sm d-inline-flex" id="userTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active fw-semibold px-4 rounded-pill transition-all" id="penghasil-tab"
                    data-bs-toggle="pill" data-bs-target="#penghasil" type="button" role="tab">
                <i class="fas fa-industry me-2"></i> Data Penghasil
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link fw-semibold px-4 rounded-pill transition-all" id="transporter-tab"
                    data-bs-toggle="pill" data-bs-target="#transporter" type="button" role="tab">
                <i class="fas fa-truck me-2"></i> Data Transporter
            </button>
        </li>
    </ul>

    <style>
        .nav-pills .nav-link { color: #6c757d; }
        .nav-pills .nav-link.active { background-color: #0d6efd; color: #fff; box-shadow: 0 4px 6px rgba(13,110,253,0.2); }
        .nav-pills .nav-link:hover:not(.active) { background-color: rgba(13,110,253,0.1); color: #0d6efd; }
    </style>

    <div class="tab-content" id="userTabContent">

        {{-- Tab Penghasil --}}
        <div class="tab-pane fade show active" id="penghasil" role="tabpanel">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-header bg-white border-bottom p-4 d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                    <h6 class="mb-0 fw-bold d-flex align-items-center">
                        <div class="bg-success bg-opacity-10 text-success rounded p-2 me-3">
                            <i class="fas fa-industry"></i>
                        </div>
                        Daftar Penghasil Limbah
                    </h6>
                    <button class="btn btn-success fw-semibold rounded-pill px-4 shadow-sm"
                            data-bs-toggle="modal" data-bs-target="#modalTambahPenghasil">
                        <i class="fas fa-plus me-1"></i> Tambah Penghasil
                    </button>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table id="tablePenghasil"
                               class="table table-hover align-middle mb-0 w-100">
                            <thead class="table-light text-muted">
                                <tr>
                                    <th class="text-center py-3" style="width:60px;">No</th>
                                    <th class="py-3">Nama Penghasil</th>
                                    <th class="text-center py-3">Username</th>
                                    <th class="text-center py-3">Email</th>
                                    <th class="text-center py-3" style="width:120px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="border-top-0">
                                @foreach($penghasil as $index => $p)
                                    <tr>
                                        <td class="text-center text-muted fw-semibold py-3">{{ $index + 1 }}</td>
                                        <td class="fw-semibold text-dark py-3">{{ $p->nama_user }}</td>
                                        <td class="text-center py-3">
                                            <span class="badge bg-primary bg-opacity-10 text-primary border border-primary-subtle rounded-pill px-3 py-2">
                                                <i class="fas fa-at me-1"></i> {{ $p->username }}
                                            </span>
                                        </td>
                                        <td class="text-center py-3">
                                            <a href="mailto:{{ $p->email }}" class="text-decoration-none text-muted fw-medium hover-primary d-inline-flex align-items-center">
                                                <i class="far fa-envelope me-2 text-primary"></i> {{ $p->email }}
                                            </a>
                                        </td>
                                        <td class="text-center py-3">
                                            <div class="d-flex justify-content-center gap-2">
                                                <button class="btn btn-warning btn-sm rounded-circle d-flex justify-content-center align-items-center btn-edit"
                                                        style="width: 35px; height: 35px;"
                                                        data-bs-toggle="modal" data-bs-target="#modalEdit"
                                                        data-id="{{ $p->id_user }}"
                                                        data-nama="{{ $p->nama_user }}"
                                                        data-username="{{ $p->username }}"
                                                        data-email="{{ $p->email }}"
                                                        title="Edit">
                                                    <i class="fas fa-pen text-dark"></i>
                                                </button>
                                                <button class="btn btn-danger btn-sm rounded-circle d-flex justify-content-center align-items-center btn-hapus"
                                                        style="width: 35px; height: 35px;"
                                                        data-bs-toggle="modal" data-bs-target="#modalHapus"
                                                        data-id="{{ $p->id_user }}"
                                                        title="Hapus">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- Tab Transporter --}}
        <div class="tab-pane fade" id="transporter" role="tabpanel">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-header bg-white border-bottom p-4 d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                    <h6 class="mb-0 fw-bold d-flex align-items-center">
                        <div class="bg-info bg-opacity-10 text-info rounded p-2 me-3">
                            <i class="fas fa-truck"></i>
                        </div>
                        Daftar Transporter
                    </h6>
                    <button class="btn btn-info text-white fw-semibold rounded-pill px-4 shadow-sm"
                            data-bs-toggle="modal" data-bs-target="#modalTambahTransporter">
                        <i class="fas fa-plus me-1"></i> Tambah Transporter
                    </button>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table id="tableTransporter"
                               class="table table-hover align-middle mb-0 w-100">
                            <thead class="table-light text-muted">
                                <tr>
                                    <th class="text-center py-3" style="width:60px;">No</th>
                                    <th class="py-3">Nama Transporter</th>
                                    <th class="text-center py-3">Username</th>
                                    <th class="text-center py-3">Email</th>
                                    <th class="text-center py-3" style="width:120px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="border-top-0">
                                @foreach($transporter as $index => $p)
                                    <tr>
                                        <td class="text-center text-muted fw-semibold py-3">{{ $index + 1 }}</td>
                                        <td class="fw-semibold text-dark py-3">{{ $p->nama_user }}</td>
                                        <td class="text-center py-3">
                                            <span class="badge bg-primary bg-opacity-10 text-primary border border-primary-subtle rounded-pill px-3 py-2">
                                                <i class="fas fa-at me-1"></i> {{ $p->username }}
                                            </span>
                                        </td>
                                        <td class="text-center py-3">
                                            <a href="mailto:{{ $p->email }}" class="text-decoration-none text-muted fw-medium hover-primary d-inline-flex align-items-center">
                                                <i class="far fa-envelope me-2 text-info"></i> {{ $p->email }}
                                            </a>
                                        </td>
                                        <td class="text-center py-3">
                                            <div class="d-flex justify-content-center gap-2">
                                                <button class="btn btn-warning btn-sm rounded-circle d-flex justify-content-center align-items-center btn-edit"
                                                        style="width: 35px; height: 35px;"
                                                        data-bs-toggle="modal" data-bs-target="#modalEdit"
                                                        data-id="{{ $p->id_user }}"
                                                        data-nama="{{ $p->nama_user }}"
                                                        data-username="{{ $p->username }}"
                                                        data-email="{{ $p->email }}"
                                                        title="Edit">
                                                    <i class="fas fa-pen text-dark"></i>
                                                </button>
                                                <button class="btn btn-danger btn-sm rounded-circle d-flex justify-content-center align-items-center btn-hapus"
                                                        style="width: 35px; height: 35px;"
                                                        data-bs-toggle="modal" data-bs-target="#modalHapus"
                                                        data-id="{{ $p->id_user }}"
                                                        title="Hapus">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>

    {{-- Modal Tambah Penghasil --}}
    <div class="modal fade" id="modalTambahPenghasil" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow rounded-4">
                <div class="modal-header border-bottom-0 pb-0 pt-4 px-4 position-relative">
                    <h5 class="modal-title fw-bold text-success d-flex align-items-center">
                        <div class="bg-success bg-opacity-10 p-2 rounded-circle me-3">
                            <i class="fas fa-user-plus"></i>
                        </div>
                        Tambah Akun Penghasil
                    </h5>
                    <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" style="position: absolute; right: 1.5rem; top: 1.5rem;"></button>
                </div>
                <form action="{{ route('admin.pengguna.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="role" value="penghasil">
                    <div class="modal-body p-4">
                        <div class="mb-4">
                            <label for="penghasil_nama" class="form-label fw-semibold text-muted small">NAMA PENGHASIL / INSTANSI</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="fas fa-building text-muted"></i></span>
                                <input type="text" id="penghasil_nama" class="form-control border-start-0 bg-light px-3 py-2" name="nama_user"
                                       placeholder="Contoh: PT. Medika Sentosa" required>
                            </div>
                        </div>
                        <div class="mb-4">
                            <label for="penghasil_username" class="form-label fw-semibold text-muted small">USERNAME</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="fas fa-user text-muted"></i></span>
                                <input type="text" id="penghasil_username" class="form-control border-start-0 bg-light px-3 py-2" name="username"
                                       placeholder="Contoh: medika_sentosa" required>
                            </div>
                        </div>
                        <div class="mb-4">
                            <label for="penghasil_email" class="form-label fw-semibold text-muted small">ALAMAT EMAIL</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="fas fa-envelope text-muted"></i></span>
                                <input type="email" id="penghasil_email" class="form-control border-start-0 bg-light px-3 py-2" name="email"
                                       placeholder="Contoh: admin@medika.com" required>
                            </div>
                        </div>
                        <div class="mb-2">
                            <label for="penghasil_password" class="form-label fw-semibold text-muted small">PASSWORD</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="fas fa-lock text-muted"></i></span>
                                <input type="password" id="penghasil_password" class="form-control border-start-0 bg-light px-3 py-2" name="password"
                                       placeholder="Masukkan kata sandi..." required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-top-0 pt-0 pb-4 px-4">
                        <button type="button" class="btn btn-light fw-semibold rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success fw-semibold rounded-pill px-4 shadow-sm">
                            <i class="fas fa-save me-1"></i> Simpan Data
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Modal Tambah Transporter --}}
    <div class="modal fade" id="modalTambahTransporter" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow rounded-4">
                <div class="modal-header border-bottom-0 pb-0 pt-4 px-4 position-relative">
                    <h5 class="modal-title fw-bold text-info d-flex align-items-center">
                        <div class="bg-info bg-opacity-10 p-2 rounded-circle me-3">
                            <i class="fas fa-truck text-info"></i>
                        </div>
                        Tambah Akun Transporter
                    </h5>
                    <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" style="position: absolute; right: 1.5rem; top: 1.5rem;"></button>
                </div>
                <form action="{{ route('admin.pengguna.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="role" value="transporter">
                    <div class="modal-body p-4">
                        <div class="mb-4">
                            <label for="transporter_nama" class="form-label fw-semibold text-muted small">NAMA TRANSPORTER</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="fas fa-building text-muted"></i></span>
                                <input type="text" id="transporter_nama" class="form-control border-start-0 bg-light px-3 py-2" name="nama_user"
                                       placeholder="Contoh: PT. Angkut Cepat" required>
                            </div>
                        </div>
                        <div class="mb-4">
                            <label for="transporter_username" class="form-label fw-semibold text-muted small">USERNAME</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="fas fa-user text-muted"></i></span>
                                <input type="text" id="transporter_username" class="form-control border-start-0 bg-light px-3 py-2" name="username"
                                       placeholder="Contoh: angkut_cepat" required>
                            </div>
                        </div>
                        <div class="mb-4">
                            <label for="transporter_email" class="form-label fw-semibold text-muted small">ALAMAT EMAIL</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="fas fa-envelope text-muted"></i></span>
                                <input type="email" id="transporter_email" class="form-control border-start-0 bg-light px-3 py-2" name="email"
                                       placeholder="Contoh: info@angkutcepat.com" required>
                            </div>
                        </div>
                        <div class="mb-2">
                            <label for="transporter_password" class="form-label fw-semibold text-muted small">PASSWORD</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="fas fa-lock text-muted"></i></span>
                                <input type="password" id="transporter_password" class="form-control border-start-0 bg-light px-3 py-2" name="password"
                                       placeholder="Masukkan kata sandi..." required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-top-0 pt-0 pb-4 px-4">
                        <button type="button" class="btn btn-light fw-semibold rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-info text-white fw-semibold rounded-pill px-4 shadow-sm">
                            <i class="fas fa-save me-1"></i> Simpan Data
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Modal Edit --}}
    <div class="modal fade" id="modalEdit" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow rounded-4">
                <div class="modal-header border-bottom-0 pb-0 pt-4 px-4 position-relative">
                    <h5 class="modal-title fw-bold text-warning d-flex align-items-center text-dark">
                        <div class="bg-warning bg-opacity-25 p-2 rounded-circle me-3">
                            <i class="fas fa-user-edit text-warning-emphasis"></i>
                        </div>
                        Edit Data Akun
                    </h5>
                    <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" style="position: absolute; right: 1.5rem; top: 1.5rem;"></button>
                </div>
                <form action="#" method="POST" id="formEdit">
                    @csrf
                    @method('PUT')
                    <div class="modal-body p-4">
                        <div class="mb-4">
                            <label for="edit_nama" class="form-label fw-semibold text-muted small">NAMA LENGKAP / INSTANSI</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="fas fa-building text-muted"></i></span>
                                <input type="text" id="edit_nama" class="form-control border-start-0 bg-light px-3 py-2" name="nama_user" required>
                            </div>
                        </div>
                        <div class="mb-4">
                            <label for="edit_username" class="form-label fw-semibold text-muted small">USERNAME</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="fas fa-user text-muted"></i></span>
                                <input type="text" id="edit_username" class="form-control border-start-0 bg-light px-3 py-2" name="username" required>
                            </div>
                        </div>
                        <div class="mb-4">
                            <label for="edit_email" class="form-label fw-semibold text-muted small">ALAMAT EMAIL</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="fas fa-envelope text-muted"></i></span>
                                <input type="email" id="edit_email" class="form-control border-start-0 bg-light px-3 py-2" name="email" required>
                            </div>
                        </div>
                        <div class="mb-2">
                            <label for="edit_password" class="form-label fw-semibold text-muted small">PASSWORD BARU</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="fas fa-key text-muted"></i></span>
                                <input type="password" id="edit_password" class="form-control border-start-0 bg-light px-3 py-2" name="password"
                                       placeholder="Kosongkan jika tidak ingin diubah">
                            </div>
                            <div class="form-text mt-2"><i class="fas fa-info-circle me-1"></i>Biarkan kosong jika password tidak diubah.</div>
                        </div>
                    </div>
                    <div class="modal-footer border-top-0 pt-0 pb-4 px-4">
                        <button type="button" class="btn btn-light fw-semibold rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-warning fw-semibold rounded-pill px-4 shadow-sm text-dark">
                            <i class="fas fa-save me-1"></i> Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Modal Hapus --}}
    <div class="modal fade" id="modalHapus" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content border-0 shadow rounded-4">
                <div class="modal-body text-center p-4">
                    <div class="bg-danger bg-opacity-10 text-danger rounded-circle d-inline-flex justify-content-center align-items-center mb-3"
                         style="width: 80px; height: 80px;">
                        <i class="fas fa-exclamation-triangle fs-1"></i>
                    </div>
                    <h4 class="fw-bold mb-2">Hapus Akun?</h4>
                    <p class="text-muted small mb-4">Data pengguna ini akan dihapus permanen dan tidak bisa dikembalikan. Yakin ingin melanjutkan?</p>
                    <form action="#" method="POST" id="formHapus" class="d-flex flex-column gap-2">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger fw-semibold rounded-pill w-100 py-2 shadow-sm">
                            Ya, Hapus Sekarang
                        </button>
                        <button type="button" class="btn btn-light fw-semibold rounded-pill w-100 py-2" data-bs-dismiss="modal">
                            Batal
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@push('scripts')
<script>
    $(document).ready(function () {
        // Init datatables without the generic border and hover to fit bootstrap custom look
        $('#tablePenghasil').DataTable({
            "language": {
                "search": "Cari:",
                "lengthMenu": "Tampilkan _MENU_ data",
                "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                "infoEmpty": "Data tidak tersedia",
                "paginate": {
                    "first": "Pertama",
                    "last": "Terakhir",
                    "next": "Selanjutnya",
                    "previous": "Sebelumnya"
                }
            }
        });
        
        $('#tableTransporter').DataTable({
            "language": {
                "search": "Cari:",
                "lengthMenu": "Tampilkan _MENU_ data",
                "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                "infoEmpty": "Data tidak tersedia",
                "paginate": {
                    "first": "Pertama",
                    "last": "Terakhir",
                    "next": "Selanjutnya",
                    "previous": "Sebelumnya"
                }
            }
        });

        const baseUrl = "{{ url('admin/pengguna') }}";

        $(document).on('click', '.btn-edit', function () {
            const id       = $(this).data('id');
            const nama     = $(this).data('nama');
            const username = $(this).data('username');
            const email    = $(this).data('email');

            $('#formEdit').attr('action', baseUrl + '/' + id);
            $('#edit_nama').val(nama);
            $('#edit_username').val(username);
            $('#edit_email').val(email);
            $('#edit_password').val('');
        });

        $(document).on('click', '.btn-hapus', function () {
            $('#formHapus').attr('action', baseUrl + '/' + $(this).data('id'));
        });
    });
</script>
@endpush
@endsection
