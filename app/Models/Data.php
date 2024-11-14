<?php

namespace App\Models;

use App\Models\KelolaUndangan\Pria;
use App\Models\KelolaUndangan\Acara;
use App\Models\KelolaUndangan\FiturKado;
use App\Models\KelolaUndangan\FiturUcapan;
use App\Models\KelolaUndangan\Galery;
use App\Models\KelolaUndangan\Kado;
use App\Models\KelolaUndangan\Sound;
use App\Models\KelolaUndangan\Streaming;
use App\Models\KelolaUndangan\Tamu;
use App\Models\KelolaUndangan\Ucapan;
use App\Models\KelolaUndangan\Wanita;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Data extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable =['user_id', 'theme_id','title', 'slug'];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function pria(){
        return $this->hasOne(Pria::class);
    }
    public function wanita(){
        return $this->hasOne(Wanita::class);
    }

    public function acara(){
        return $this->hasMany(Acara::class);
    }
    public function galery(){
        return $this->hasMany(Galery::class);
    }

    public function sound(){
        return $this->hasOne(Sound::class);
    }
    
    public function tamu(){
        return $this->hasMany(Tamu::class, 'data_id');
    }
    public function ucapan(){
        return $this->hasMany(Ucapan::class);
    }
    public function FiturUcapan(){
        return $this->hasOne(FiturUcapan::class);
    }
    public function streaming(){
        return $this->hasOne(Streaming::class);
    }
    public function kado(){
        return $this->hasMany(Kado::class);
    }
    public function fiturKado(){
        return $this->hasOne(FiturKado::class);
    }
    
}
