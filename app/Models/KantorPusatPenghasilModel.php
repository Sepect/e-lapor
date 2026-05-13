<?php

namespace App\Models;

use App\Traits\UsesUUID;
use Illuminate\Database\Eloquent\Model;

class KantorPusatPenghasilModel extends Model
{
    use UsesUUID;

    protected $table = 'kantor_pusat_penghasil';

    protected $primaryKey = 'id_kantor_pusat_penghasil';

    protected $fillable = [
        'id_user',
        'nama_kantor_pusat_penghasil',
        'alamat_kantor_pusat_penghasil',
        'telepon_kantor_pusat_penghasil',
        'fax_kantor_pusat_penghasil',
        'alamat_kantor_perwakilan_penghasil',
        'telepon_kantor_perwakilan_penghasil',
        'fax_kantor_perwakilan_penghasil',
    ];
}
