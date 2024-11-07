<?php

namespace App\Models;

use App\Models\KelolaUndangan\Pria;
use App\Models\KelolaUndangan\Acara;
use App\Models\KelolaUndangan\FiturUcapan;
use App\Models\KelolaUndangan\Galery;
use App\Models\KelolaUndangan\Sound;
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
        return $this->belongsTo(Pria::class);
    }
    public function wanita(){
        return $this->belongsTo(Wanita::class);
    }

    public function acara(){
        return $this->belongsTo(Acara::class);
    }
    public function galery(){
        return $this->belongsTo(Galery::class);
    }

    public function sound(){
        return $this->belongsTo(Sound::class);
    }
    public function tamu(){
        return $this->belongsTo(Tamu::class);
    }
    public function ucapan(){
        return $this->belongsTo(Ucapan::class);
    }
    public function FiturUcapan(){
        return $this->belongsTo(FiturUcapan::class);
    }

    
}
