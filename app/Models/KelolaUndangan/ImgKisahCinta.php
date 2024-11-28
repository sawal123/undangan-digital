<?php

namespace App\Models\KelolaUndangan;

use App\Models\Data;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ImgKisahCinta extends Model
{
    use HasFactory;
    protected $fillable = ['data_id', 'kisah_id', 'image'];
    public function kisah()
    {
        return $this->belongsTo(KisahCinta::class, 'kisah_id', 'id');
    }
    
     public function data(){
        return $this->belongsTo(Data::class);
    }
}
