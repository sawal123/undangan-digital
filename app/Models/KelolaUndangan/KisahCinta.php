<?php

namespace App\Models\KelolaUndangan;

use App\Models\Data;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KisahCinta extends Model
{
    use HasFactory;
    protected $fillable =['data_id', 'title', 'deskripsi'];

    public function data(){
        return $this->belongsTo(Data::class);
    }
    public function image()
{
    return $this->hasOne(ImgKisahCinta::class, 'kisah_id', 'id');
}
}
