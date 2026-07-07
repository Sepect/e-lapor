<?php

use App\Http\Controllers\AkunController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\LimbahController;
use App\Http\Controllers\MasterLimbahController;
use App\Http\Controllers\Penghasil\ProfilController;
use App\Http\Controllers\PenghasilController;
use App\Http\Controllers\Transporter\ProfilController as TransporterProfilController;
use App\Http\Controllers\TransporterController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/', [AuthController::class, 'index'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/pengaturan-akun', [AkunController::class, 'pengaturan'])->name('akun.index');
    Route::put('/pengaturan-akun/update', [AkunController::class, 'updateProfil'])->name('akun.update');

    Route::prefix('admin')->name('admin.')->middleware('role:admin')->group(function () {
        Route::get('/', [AkunController::class, 'index'])
            ->name('dashboard');
        Route::get('/penerimaan-limbah/detail/{id}', [LimbahController::class, 'show'])
            ->name('penerimaan.show');
        Route::get('/penerimaan-limbah/cetak/{id}', [LimbahController::class, 'cetak'])
            ->name('penerimaan.cetak');
        Route::post('/penerimaan-limbah/{id}/terima', [LimbahController::class, 'terima'])
            ->name('penerimaan.terima');
        Route::post('/penerimaan-limbah/{id}/kembalikan', [LimbahController::class, 'kembalikan'])
            ->name('penerimaan.kembalikan');
        Route::post('/penerimaan-limbah/{id}/olah', [LimbahController::class, 'olah'])
            ->name('penerimaan.olah');
        Route::post('/penerimaan-limbah/{id}/selesai', [LimbahController::class, 'selesai'])
            ->name('penerimaan.selesai');
        Route::get('/penerimaan-limbah/{status?}', [LimbahController::class, 'index'])
            ->name('penerimaan.index');

        Route::prefix('laporan')->name('laporan.')->group(function () {
            Route::get('/', [LaporanController::class, 'index'])->name('lengkap');
            Route::get('/penghasil', [LaporanController::class, 'penghasil'])->name('penghasil');
            Route::get('/transporter', [LaporanController::class, 'transporter'])->name('transporter');

            Route::get('/potensi_pad', [LaporanController::class, 'potensi_pad'])->name('potensi_pad');
            Route::get('/penerimaan_pad', [LaporanController::class, 'penerimaan_pad'])->name('penerimaan_pad');
            Route::get('/piutang_pad', [LaporanController::class, 'piutang_pad'])->name('piutang_pad');

            Route::post('/cetak', [LaporanController::class, 'cetak'])->name('cetak');
        });

        Route::prefix('pengguna')->name('pengguna.')->group(function () {
            Route::get('/', [AkunController::class, 'pengguna'])->name('index');
            Route::post('/', [AkunController::class, 'storePengguna'])->name('store');
            Route::put('/{id}', [AkunController::class, 'updatePengguna'])->name('update');
            Route::delete('/{id}', [AkunController::class, 'destroyPengguna'])->name('destroy');
        });

        Route::prefix('master-limbah')->name('master-limbah.')->group(function () {
            Route::get('/', [MasterLimbahController::class, 'index'])->name('index');
            Route::post('/', [MasterLimbahController::class, 'store'])->name('store');
            Route::put('/{id}', [MasterLimbahController::class, 'update'])->name('update');
            Route::delete('/{id}', [MasterLimbahController::class, 'destroy'])->name('destroy');
        });
    });

    Route::prefix('penghasil')->name('penghasil.')->middleware('role:penghasil')->group(function () {
        Route::get('/', [PenghasilController::class, 'dashboard'])->name('dashboard');

        Route::get('/profil', [PenghasilController::class, 'profil'])->name('profil');
        Route::put('/profil/informasi', [ProfilController::class, 'updateInformasi'])->name('profil.informasi');
        Route::put('/profil/kantor', [ProfilController::class, 'updateKantor'])->name('profil.kantor');
        Route::put('/profil/perizinan', [ProfilController::class, 'updatePerizinan'])->name('profil.perizinan');
        Route::post('/profil/logo', [ProfilController::class, 'updateLogo'])->name('profil.logo');

        Route::get('/kontrak', [PenghasilController::class, 'kontrak'])->name('kontrak');
        Route::post('/kontrak', [PenghasilController::class, 'storeKontrak'])->name('kontrak.store');
        Route::put('/kontrak/{id}', [PenghasilController::class, 'updateKontrak'])->name('kontrak.update');
        Route::get('/kontrak/{id}/cetak', [PenghasilController::class, 'cetakKontrak'])->name('kontrak.cetak');
        Route::get('/kontrak/transporter/{id}/info', [PenghasilController::class, 'getTransporterInfo'])->name('kontrak.transporter-info');
        Route::get('/limbah', [PenghasilController::class, 'limbah'])->name('limbah');
        Route::post('/limbah', [PenghasilController::class, 'storeLimbah'])->name('limbah.store');
        Route::delete('/limbah/{id}', [PenghasilController::class, 'destroyLimbah'])->name('limbah.destroy');
        Route::get('/limbah/transporter/{id}/info', [PenghasilController::class, 'getLimbahTransporterInfo'])->name('limbah.transporter-info');
        Route::get('/berita-acara', [PenghasilController::class, 'beritaAcara'])->name('beritaAcara');
        Route::get('/berita-acara/{id}', [PenghasilController::class, 'beritaAcaraDetail'])->name('beritaAcara.show');
        Route::get('/tagihan', [PenghasilController::class, 'tagihan'])->name('tagihan');
        Route::get('/tagihan/{id}', [PenghasilController::class, 'tagihanDetail'])->name('tagihan.show');
        Route::get('/pembayaran', [PenghasilController::class, 'pembayaran'])->name('pembayaran');
        Route::get('/pembayaran/{id}/form', [PenghasilController::class, 'formSetor'])->name('pembayaran.form');
        Route::post('/pembayaran/{id}/setor', [PenghasilController::class, 'setor'])->name('pembayaran.setor');
        Route::get('/akun', [PenghasilController::class, 'akun'])->name('akun');
    });

    Route::prefix('transporter')->name('transporter.')->middleware('role:transporter')->group(function () {
        Route::get('/', [TransporterController::class, 'dashboard'])->name('dashboard');
        Route::get('/profil', [TransporterController::class, 'profil'])->name('profil');
        Route::put('/profil/informasi', [TransporterProfilController::class, 'updateInformasi'])->name('profil.informasi');
        Route::put('/profil/perizinan', [TransporterProfilController::class, 'updatePerizinan'])->name('profil.perizinan');
        Route::post('/profil/logo', [TransporterProfilController::class, 'updateLogo'])->name('profil.logo');
        Route::get('/kontrak', [TransporterController::class, 'kontrak'])->name('kontrak');
        Route::get('/kontrak/penghasil/{id}/info', [TransporterController::class, 'getPenghasilInfo'])->name('kontrak.penghasil-info');
        Route::post('/kontrak', [TransporterController::class, 'storeKontrak'])->name('kontrak.store');
        Route::put('/kontrak/{id}', [TransporterController::class, 'updateKontrak'])->name('kontrak.update');
        Route::delete('/kontrak/{id}', [TransporterController::class, 'destroyKontrak'])->name('kontrak.destroy');
        Route::get('/limbah', [TransporterController::class, 'limbah'])->name('limbah');
        Route::post('/limbah', [TransporterController::class, 'storeLimbah'])->name('limbah.store');
        Route::delete('/limbah/{id}', [TransporterController::class, 'destroyLimbah'])->name('limbah.destroy');
        Route::get('/edit_limbah/{id}', [TransporterController::class, 'edit_limbah'])->name('edit-limbah');
        Route::post('/limbah/{id}/berita-acara', [TransporterController::class, 'storeBeritaAcara'])->name('limbah.berita-acara');
        Route::get('/berita-acara', [TransporterController::class, 'beritaAcara'])->name('beritaAcara');
        Route::get('/tagihan', [TransporterController::class, 'tagihan'])->name('tagihan');
        Route::get('/tagihan/{id}/setor', [TransporterController::class, 'formSetor'])->name('tagihan.setor.form');
        Route::post('/tagihan/{id}/setor', [TransporterController::class, 'setor'])->name('tagihan.setor');
        Route::get('/pad', [TransporterController::class, 'pad'])->name('pad');
        Route::get('/retribusi', [TransporterController::class, 'retribusi'])->name('retribusi');
        Route::get('/akun', [TransporterController::class, 'akun'])->name('akun');
    });
});
