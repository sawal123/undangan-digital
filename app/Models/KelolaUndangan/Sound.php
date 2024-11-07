<?php

namespace App\Models\KelolaUndangan;

use App\Models\Data;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sound extends Model
{
    use HasFactory;
    protected $fillable = ['data_id', 'sound', 'start', 'isActive'];

    public function data(){
        return $this->hasOne(Data::class);
    }
}
