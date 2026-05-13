<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BeritaAcara extends Model
{
    use \App\Traits\UsesUUID;

    protected $table = 'berita_acaras';
    protected $primaryKey = 'id_berita_acara';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_limbah',
        'nama_penyerah',
        'alamat_penyerah',
        'jabatan_penyerah',
        'tandatangan_penyerah',
        'stempel_penyerah',
        'nama_penerima',
        'alamat_penerima',
        'jabatan_penerima',
        'tandatangan_penerima',
        'stempel_penerima',
        'tgl_penyerahan',
    ];

    protected function casts(): array
    {
        return [
            'tgl_penyerahan' => 'date',
        ];
    }

    public function limbah()
    {
        return $this->belongsTo(Limbah::class, 'id_limbah', 'id_limbah');
    }
}
