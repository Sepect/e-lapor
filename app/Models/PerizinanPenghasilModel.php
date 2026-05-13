<?php

namespace App\Models;

use App\Traits\UsesUUID;
use Illuminate\Database\Eloquent\Model;

class PerizinanPenghasilModel extends Model
{
    use UsesUUID;

    protected $table = 'perizinan_penghasil';

    protected $primaryKey = 'id_perizinan_penghasil';

    protected $fillable = [
        'id_user',
        'no_akta',
        'tgl_terbit',
        'lampiran',
        'no_perling',
        'tgl_terbit_perling',
        'lampiran_perling',
        'masa_berlaku_perling_dari',
        'masa_berlaku_perling_sampai',
        'limbah_dihasilkan'
    ];
}
