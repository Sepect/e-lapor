@extends('layouts.app')

@section('title', 'Master Limbah B3')
@section('subtitle', 'Master Limbah B3')

@section('content')
    {{-- Page Header --}}
    <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden">
        <div class="card-body p-4 d-flex flex-column flex-md-row align-items-start align-items-md-center gap-3 bg-white position-relative">
            <div class="position-absolute top-0 start-0 w-100 h-100 bg-success opacity-10" style="pointer-events: none;"></div>
            <div class="position-absolute top-0 start-0 h-100 bg-success" style="width: 6px;"></div>

            <div class="bg-success bg-gradient text-white rounded-circle d-flex justify-content-center align-items-center flex-shrink-0 shadow-sm z-1"
                style="width: 55px; height: 55px;">
                <i class="fas fa-flask fs-4"></i>
            </div>
            <div class="flex-grow-1 z-1">
                <h5 class="fw-bold mb-1 text-dark">Master Limbah B3</h5>
                <p class="text-muted mb-0 small">Kelola daftar jenis & sifat limbah B3 beserta kode dan tarif pengolahan per ton.</p>
            </div>
        </div>
    </div>

    @if (session('error'))
        <div class="alert alert-danger rounded-3 mb-4">{{ session('error') }}</div>
    @endif

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-header bg-white border-bottom p-4 d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
            <h6 class="mb-0 fw-bold d-flex align-items-center">
                <div class="bg-success bg-opacity-10 text-success rounded p-2 me-3">
                    <i class="fas fa-list"></i>
                </div>
                Daftar Master Limbah B3
            </h6>
            <button class="btn btn-success fw-semibold rounded-pill px-4 shadow-sm" data-bs-toggle="modal"
                data-bs-target="#modalTambahMaster">
                <i class="fas fa-plus me-1"></i> Tambah Master
            </button>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table id="tableMaster" class="table table-hover align-middle mb-0 w-100">
                    <thead class="table-light text-muted">
                        <tr>
                            <th class="text-center py-3" style="width:60px;">No</th>
                            <th class="py-3">Jenis Limbah</th>
                            <th class="py-3">Sifat</th>
                            <th class="text-center py-3">Kode</th>
                            <th class="text-end py-3">Tarif / TON</th>
                            <th class="text-center py-3" style="width:120px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="border-top-0">
                        @foreach ($masterLimbah as $index => $m)
                            <tr>
                                <td class="text-center text-muted fw-semibold py-3">{{ $index + 1 }}</td>
                                <td class="fw-semibold text-dark py-3">{{ $m->jenis_limbah }}</td>
                                <td class="py-3">
                                    <span class="badge bg-warning bg-opacity-10 text-warning-emphasis border border-warning-subtle rounded-pill px-3 py-2">
                                        {{ $m->sifat_limbah }}
                                    </span>
                                </td>
                                <td class="text-center py-3">
                                    <span class="badge bg-primary bg-opacity-10 text-primary border border-primary-subtle rounded-pill px-3 py-2 font-monospace">
                                        {{ $m->kode_limbah }}
                                    </span>
                                </td>
                                <td class="text-end py-3 fw-semibold text-success">Rp {{ number_format($m->tarif, 0, ',', '.') }}</td>
                                <td class="text-center py-3">
                                    <div class="d-flex justify-content-center gap-2">
                                        <button class="btn btn-warning btn-sm rounded-circle d-flex justify-content-center align-items-center btn-edit"
                                            style="width: 35px; height: 35px;"
                                            data-id="{{ $m->id_master_limbah }}"
                                            data-jenis="{{ $m->jenis_limbah }}"
                                            data-sifat="{{ $m->sifat_limbah }}"
                                            data-kode="{{ $m->kode_limbah }}"
                                            data-tarif="{{ $m->tarif }}"
                                            data-satuan="{{ $m->satuan }}" title="Edit">
                                            <i class="fas fa-pen text-dark"></i>
                                        </button>
                                        <button class="btn btn-danger btn-sm rounded-circle d-flex justify-content-center align-items-center btn-hapus"
                                            style="width: 35px; height: 35px;"
                                            data-id="{{ $m->id_master_limbah }}" title="Hapus">
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

    {{-- Modal Tambah --}}
    <div class="modal fade" id="modalTambahMaster" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow rounded-4">
                <div class="modal-header border-bottom-0 pb-0 pt-4 px-4 position-relative">
                    <h5 class="modal-title fw-bold text-success d-flex align-items-center">
                        <div class="bg-success bg-opacity-10 p-2 rounded-circle me-3"><i class="fas fa-flask"></i></div>
                        Tambah Master Limbah B3
                    </h5>
                    <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"
                        style="position: absolute; right: 1.5rem; top: 1.5rem;"></button>
                </div>
                <form action="{{ route('admin.master-limbah.store') }}" method="POST">
                    @csrf
                    @include('admin.master_limbah._form_fields')
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

    {{-- Modal Edit --}}
    <div class="modal fade" id="modalEdit" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow rounded-4">
                <div class="modal-header border-bottom-0 pb-0 pt-4 px-4 position-relative">
                    <h5 class="modal-title fw-bold text-warning d-flex align-items-center text-dark">
                        <div class="bg-warning bg-opacity-25 p-2 rounded-circle me-3"><i class="fas fa-pen text-warning-emphasis"></i></div>
                        Edit Master Limbah B3
                    </h5>
                    <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"
                        style="position: absolute; right: 1.5rem; top: 1.5rem;"></button>
                </div>
                <form action="#" method="POST" id="formEdit">
                    @csrf
                    @method('PUT')
                    @include('admin.master_limbah._form_fields', ['edit' => true])
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
                    <h4 class="fw-bold mb-2">Hapus Master?</h4>
                    <p class="text-muted small mb-4">Data master limbah ini akan dihapus permanen. Yakin ingin melanjutkan?</p>
                    <form action="#" method="POST" id="formHapus" class="d-flex flex-column gap-2">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger fw-semibold rounded-pill w-100 py-2 shadow-sm">Ya, Hapus Sekarang</button>
                        <button type="button" class="btn btn-light fw-semibold rounded-pill w-100 py-2" data-bs-dismiss="modal">Batal</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script type="module">
            const $ = window.$;
            const bootstrap = window.bootstrap;

            $('#tableMaster').DataTable();

            const baseUrl = "{{ url('admin/master-limbah') }}";

            $(document).on('click', '.btn-edit', function () {
                const btn = $(this);
                $('#formEdit').attr('action', baseUrl + '/' + btn.data('id'));
                $('#edit_jenis_limbah').val(btn.data('jenis'));
                $('#edit_sifat_limbah').val(btn.data('sifat'));
                $('#edit_kode_limbah').val(btn.data('kode'));
                $('#edit_tarif').val(btn.data('tarif'));
                $('#edit_satuan').val(btn.data('satuan'));
                new bootstrap.Modal(document.getElementById('modalEdit')).show();
            });

            $(document).on('click', '.btn-hapus', function () {
                $('#formHapus').attr('action', baseUrl + '/' + $(this).data('id'));
                new bootstrap.Modal(document.getElementById('modalHapus')).show();
            });
        </script>
    @endpush
@endsection
