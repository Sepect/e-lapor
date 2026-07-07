@php($prefix = ($edit ?? false) ? 'edit_' : '')
<div class="modal-body p-4">
    @if (!($edit ?? false) && $errors->any())
        <div class="alert alert-danger rounded-3">
            <ul class="mb-0 ps-3">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="mb-3">
        <label for="{{ $prefix }}jenis_limbah" class="form-label fw-semibold text-muted small">JENIS LIMBAH B3</label>
        <input type="text" id="{{ $prefix }}jenis_limbah" class="form-control bg-light px-3 py-2"
            name="jenis_limbah" value="{{ ($edit ?? false) ? '' : old('jenis_limbah') }}"
            placeholder="Contoh: Oli Bekas" required>
    </div>

    <div class="mb-3">
        <label for="{{ $prefix }}sifat_limbah" class="form-label fw-semibold text-muted small">SIFAT LIMBAH B3</label>
        <input type="text" id="{{ $prefix }}sifat_limbah" class="form-control bg-light px-3 py-2"
            name="sifat_limbah" value="{{ ($edit ?? false) ? '' : old('sifat_limbah') }}"
            placeholder="Contoh: Mudah Menyala" required>
    </div>

    <div class="mb-3">
        <label for="{{ $prefix }}kode_limbah" class="form-label fw-semibold text-muted small">KODE LIMBAH</label>
        <input type="text" id="{{ $prefix }}kode_limbah" class="form-control bg-light px-3 py-2 font-monospace text-uppercase"
            name="kode_limbah" value="{{ ($edit ?? false) ? '' : old('kode_limbah') }}"
            placeholder="Contoh: B105d" required>
    </div>

    <div class="row g-3">
        <div class="col-8">
            <label for="{{ $prefix }}tarif" class="form-label fw-semibold text-muted small">TARIF PENGOLAHAN / TON</label>
            <div class="input-group">
                <span class="input-group-text bg-light">Rp</span>
                <input type="number" id="{{ $prefix }}tarif" class="form-control bg-light px-3 py-2"
                    name="tarif" value="{{ ($edit ?? false) ? '' : old('tarif') }}" min="0" placeholder="0" required>
            </div>
        </div>
        <div class="col-4">
            <label for="{{ $prefix }}satuan" class="form-label fw-semibold text-muted small">SATUAN</label>
            <input type="text" id="{{ $prefix }}satuan" class="form-control bg-light px-3 py-2 text-uppercase"
                name="satuan" value="{{ ($edit ?? false) ? '' : old('satuan', 'TON') }}" required>
        </div>
    </div>
</div>
