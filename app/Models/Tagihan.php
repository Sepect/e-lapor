<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tagihan extends Model
{
    use \App\Traits\UsesUUID;

    protected $table = 'tagihans';
    protected $primaryKey = 'id_tagihan';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_user',
        'nomor_tagihan',
        'jenis_tagihan',
        'jumlah_tagihan',
        'status_pembayaran',
        'tgl_tagihan',
        'tgl_jatuh_tempo',
        'bukti_pembayaran',
        'metode_pembayaran',
        'no_referensi',
        'tgl_bayar',
        'catatan_pembayaran',
    ];

    protected function casts(): array
    {
        return [
            'tgl_tagihan'    => 'date',
            'tgl_jatuh_tempo' => 'date',
            'tgl_bayar'      => 'date',
            'jumlah_tagihan' => 'decimal:2',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }
}
