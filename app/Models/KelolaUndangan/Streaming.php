<?php

namespace App\Models\KelolaUndangan;

use App\Models\Data;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Streaming extends Model
{
    use HasFactory;
    protected $fillable =['data_id', 'link', 'isActive'];

    public function data(){
        return $this->belongsTo(Data::class);
    }
}
