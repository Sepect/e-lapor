<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InformasiTransporter extends Model
{
    use \App\Traits\UsesUUID;

    protected $table = 'informasi_transporters';
    protected $primaryKey = 'id_informasi_transporter';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_user',
        'nama_transporter',
        'alamat_transporter',
        'kota_transporter',
        'telepon_transporter',
        'fax_transporter',
        'nama_penanggung_jawab',
        'telepon_penanggung_jawab',
        'email_penanggung_jawab',
        'nama_driver',
        'telepon_driver',
        'email_driver',
        'logo_transporter',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }
}
