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
