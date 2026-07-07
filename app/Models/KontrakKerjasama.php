<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KontrakKerjasama extends Model
{
    use \App\Traits\UsesUUID;

    protected $table = 'kontrak_kerjasamas';

    protected $primaryKey = 'id_kontrak_kerjasama';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'id_penghasil',
        'id_transporter',
        'nomor_kontrak',
        'tgl_terbit',
        'masa_berlaku_dari',
        'masa_berlaku_sampai',
        'status',
        'lampiran',
        'hari',
        'tanggal_ttd',
        'bulan',
        'tahun',
        'jangka_waktu',
        'nama_perusahaan',
        'jenis_usaha',
        'perizinan',
        'alamat_ttd',
        'kota_ttd',
        'provinsi_ttd',
        'nama_ttd',
        'jabatan_ttd',
    ];

    protected function casts(): array
    {
        return [
            'tgl_terbit' => 'date',
            'masa_berlaku_dari' => 'date',
            'masa_berlaku_sampai' => 'date',
        ];
    }

    public function penghasil()
    {
        return $this->belongsTo(User::class, 'id_penghasil', 'id_user');
    }

    public function transporter()
    {
        return $this->belongsTo(User::class, 'id_transporter', 'id_user');
    }
}
