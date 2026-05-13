<?php

namespace App\Models;

use App\Traits\UsesUUID;
use Illuminate\Database\Eloquent\Model;

class InformasiPenghasilModel extends Model
{
    use UsesUUID;

    protected $table = 'informasi_penghasil';
    protected $primaryKey = 'id_informasi_penghasil';

    protected $fillable = [
        'id_user',
        'nama_penghasil', 'alamat_penghasil', 'kota_penghasil',
        'telepon_penghasil', 'fax_penghasil', 'nama_penanggung_jawab',
        'telepon_penanggung_jawab', 'email_penanggung_jawab',
        'nama_driver', 'telepon_driver', 'email_driver', 'logo_penghasil'
    ];
}
