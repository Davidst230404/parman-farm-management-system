<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mitra extends Model
{
    protected $table = 'mitras';

    protected $fillable = [
        'nama',
        'kontak',
        'alamat',
        'catatan',
    ];

    public function penjualan()
    {
        return $this->hasMany(Penjualan::class, 'mitra_id');
    }
}
