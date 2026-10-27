<?php

namespace App\Models\KelolaUndangan;

use App\Models\Data;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Rundown extends Model
{
    use HasFactory;

    protected $fillable = [
        'data_id',
        'acara_id',
        'waktu_mulai',
        'waktu_selesai',
        'nama_kegiatan',
        'keterangan',
        'lokasi',
        'is_active',
        'sort',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort' => 'integer',
    ];

    public function data(): BelongsTo
    {
        return $this->belongsTo(Data::class);
    }

    public function acara(): BelongsTo
    {
        return $this->belongsTo(Acara::class);
    }
}
