<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Produksi extends Model
{
    protected $table = 'produksi';

    protected $fillable = [
        'sapi_id',
        'jumlah_susu',
        'sesi',
        'tanggal',
        'status',
    ];

    public function sapi(): BelongsTo
    {
        return $this->belongsTo(Sapi::class, 'sapi_id');
    }
}
