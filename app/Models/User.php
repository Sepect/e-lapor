<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Traits\UsesUUID;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\PerizinanPenghasilModel;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, UsesUUID;

    public $incrementing = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $primaryKey = 'id_user';
    protected $keyType = 'string';

    protected $table = 'users';

    protected $fillable = [
        'nama_user',
        'username',
        'email',
        'role',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function informasiPenghasil(): HasOne
    {
        return $this->hasOne(InformasiPenghasilModel::class, 'id_user', 'id_user');
    }

    public function informasiTransporter(): HasOne
    {
        return $this->hasOne(InformasiTransporter::class, 'id_user', 'id_user');
    }

    public function perizinanTransporter(): HasOne
    {
        return $this->hasOne(PerizinanTransporter::class, 'id_user', 'id_user');
    }

    public function perizinanPenghasil(): HasOne
    {
        return $this->hasOne(PerizinanPenghasilModel::class, 'id_user', 'id_user');
    }
}
