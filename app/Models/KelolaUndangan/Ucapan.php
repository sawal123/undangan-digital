<?php

namespace App\Models\KelolaUndangan;

use App\Models\Data;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ucapan extends Model
{
    use HasFactory;
    protected $fillable = ['data_id', 'tamu_id', 'ucapan', 'status'];

    public function tamu(){
        return $this->belongsTo(Tamu::class);
    }
    public function data(){
        return $this->belongsTo(Data::class);
    }
}
