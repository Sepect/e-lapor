<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PerizinanTransporter extends Model
{
    use \App\Traits\UsesUUID;

    protected $table = 'perizinan_transporters';
    protected $primaryKey = 'id_perizinan_transporter';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_user',
        'no_akta',
        'tgl_terbit',
        'lampiran',
        'no_perling',
        'tgl_terbit_perling',
        'masa_berlaku_perling_dari',
        'masa_berlaku_perling_sampai',
        'lampiran_perling',
    ];

    protected function casts(): array
    {
        return [
            'tgl_terbit' => 'date',
            'tgl_terbit_perling' => 'date',
            'masa_berlaku_perling_dari' => 'date',
            'masa_berlaku_perling_sampai' => 'date',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }
}
