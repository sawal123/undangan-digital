<?php

namespace App\Models\KelolaUndangan;

use App\Models\Data;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EventDetail extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'data_id',
        'headline',
        'host_name',
        'speaker_name',
        'dress_code',
        'description',
        'image',
    ];

    public function data()
    {
        return $this->belongsTo(Data::class);
    }
}
