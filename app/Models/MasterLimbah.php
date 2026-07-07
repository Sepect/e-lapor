<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterLimbah extends Model
{
    use \App\Traits\UsesUUID, HasFactory;

    protected $table = 'master_limbahs';

    protected $primaryKey = 'id_master_limbah';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'kode_limbah',
        'jenis_limbah',
        'sifat_limbah',
        'tarif',
        'satuan',
    ];

    protected function casts(): array
    {
        return [
            'tarif' => 'decimal:2',
        ];
    }

    public function limbahs(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Limbah::class, 'id_master_limbah', 'id_master_limbah');
    }
}
