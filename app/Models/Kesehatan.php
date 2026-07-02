<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Kesehatan extends Model
{
    protected $table = 'kesehatan';

    protected $fillable = [
        'sapi_id',
        'nafsu_makan',
        'kondisi_susu',
        'perilaku',
        'catatan',
        'status',
    ];

    public function sapi(): BelongsTo
    {
        return $this->belongsTo(Sapi::class, 'sapi_id');
    }
}
