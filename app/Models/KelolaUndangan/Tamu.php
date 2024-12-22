<?php

namespace App\Models\KelolaUndangan;

use App\Models\Data;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tamu extends Model
{
    use HasFactory;
    protected $fillable =['data_id', 'nama', 'kode', 'nomor', 'slug'];

    public function ucapans(){
        return $this->hasOne(Ucapan::class);
    }
    public function data(){
        return $this->belongsTo(Data::class);
    }
}
