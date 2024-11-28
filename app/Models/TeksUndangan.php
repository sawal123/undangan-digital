<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeksUndangan extends Model
{
    use HasFactory;
    protected $fillable =['data_id', 'pembuka', 'acara', 'penutup'];

    public function data(){
        return $this->belongsTo(Data::class);
    }
}
