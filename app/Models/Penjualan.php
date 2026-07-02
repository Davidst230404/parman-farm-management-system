<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    protected $table = 'penjualan';

    protected $fillable = [
        'jumlah_terjual',
        'total_pendapatan',
        'mitra_id',
        'tanggal',
        'metode',
        'status',
        'catatan',
    ];

    public function mitra()
    {
        return $this->belongsTo(Mitra::class, 'mitra_id');
    }
}
