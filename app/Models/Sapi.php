<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Sapi extends Model
{
    protected $table = 'sapi';

    protected $fillable = [
        'name',
        'code',
        'status',
        'tanggal_lahir',
        'jenis_kelamin',
        'catatan',
    ];

    public function kesehatan(): HasMany
    {
        return $this->hasMany(Kesehatan::class, 'sapi_id');
    }

    public function produksi(): HasMany
    {
        return $this->hasMany(Produksi::class, 'sapi_id');
    }
}
