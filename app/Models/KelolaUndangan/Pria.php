<?php

namespace App\Models\KelolaUndangan;

use App\Models\Data;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pria extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable =['data_id', 'nama_lengkap', 'nama_panggilan','deskripsi', 'image'];


    public function data(){
        return $this->belongsTo(Data::class);
    }


}
