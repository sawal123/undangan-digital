<?php

namespace App\Models\KelolaUndangan;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SosialMedia extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable =['wanita_id', 'pria_id', 'sosmed_id', 'nama'];
    
    public function wanita(){
        return $this->hasOne(Wanita::class);
    }

}
