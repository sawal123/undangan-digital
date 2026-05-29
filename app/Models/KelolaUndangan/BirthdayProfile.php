<?php

namespace App\Models\KelolaUndangan;

use App\Models\Data;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BirthdayProfile extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'data_id',
        'name',
        'nickname',
        'age',
        'parent_name',
        'description',
        'photo',
    ];

    public function data()
    {
        return $this->belongsTo(Data::class);
    }
}
