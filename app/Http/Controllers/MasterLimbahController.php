<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMasterLimbahRequest;
use App\Models\MasterLimbah;

class MasterLimbahController extends Controller
{
    public function index(): \Illuminate\View\View
    {
        $masterLimbah = MasterLimbah::orderBy('jenis_limbah')->get();

        return view('admin.master_limbah.index', compact('masterLimbah'));
    }

    public function store(StoreMasterLimbahRequest $request): \Illuminate\Http\RedirectResponse
    {
        MasterLimbah::create($request->validated());

        return back()->with('success', 'Master limbah B3 berhasil ditambahkan.');
    }

    public function update(StoreMasterLimbahRequest $request, string $id): \Illuminate\Http\RedirectResponse
    {
        $master = MasterLimbah::findOrFail($id);
        $master->update($request->validated());

        return back()->with('success', 'Master limbah B3 berhasil diperbarui.');
    }

    public function destroy(string $id): \Illuminate\Http\RedirectResponse
    {
        $master = MasterLimbah::findOrFail($id);

        if ($master->limbahs()->exists()) {
            return back()->with('error', 'Master limbah tidak dapat dihapus karena sudah dipakai pada data limbah.');
        }

        $master->delete();

        return back()->with('success', 'Master limbah B3 berhasil dihapus.');
    }
}
