<?php

namespace App\Models\KelolaUndangan;

use App\Models\Data;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Qoute extends Model
{
    use HasFactory;
    protected $fillable = ['data_id', 'qoute'];
    public function data(){
        return $this->belongsTo(Data::class);
    }

}
