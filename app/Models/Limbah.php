<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Limbah extends Model
{
    use \App\Traits\UsesUUID;

    protected $table = 'limbahs';

    protected $primaryKey = 'id_limbah';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'id_penghasil',
        'id_transporter',
        'id_kontrak',
        'id_master_limbah',
        'kode_limbah',
        'jenis_limbah',
        'sifat_limbah',
        'jumlah_limbah',
        'satuan',
        'no_manifest',
        'no_kendaraan',
        'nama_driver',
        'jenis_kendaraan',
        'catatan',
        'status',
        'tgl_rencana',
        'tgl_terangkut',
        'tgl_diterima',
        'tgl_terolah',
    ];

    protected function casts(): array
    {
        return [
            'tgl_rencana' => 'date',
            'tgl_terangkut' => 'date',
            'tgl_diterima' => 'date',
            'tgl_terolah' => 'date',
            'jumlah_limbah' => 'decimal:2',
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

    public function kontrak()
    {
        return $this->belongsTo(KontrakKerjasama::class, 'id_kontrak', 'id_kontrak_kerjasama');
    }

    public function masterLimbah(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(MasterLimbah::class, 'id_master_limbah', 'id_master_limbah');
    }

    public function beritaAcara(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(BeritaAcara::class, 'id_limbah', 'id_limbah');
    }

    public function tagihan(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Tagihan::class, 'id_limbah', 'id_limbah');
    }
}
