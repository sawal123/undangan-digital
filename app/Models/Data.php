<?php

namespace App\Models;

use App\Models\KelolaUndangan\Pria;
use App\Models\KelolaUndangan\Acara;
use App\Models\KelolaUndangan\FiturKado;
use App\Models\KelolaUndangan\FiturUcapan;
use App\Models\KelolaUndangan\Galery;
use App\Models\KelolaUndangan\ImgKisahCinta;
use App\Models\KelolaUndangan\Kado;
use App\Models\KelolaUndangan\KisahCinta;
use App\Models\KelolaUndangan\Qoute;
use App\Models\KelolaUndangan\Sound;
use App\Models\KelolaUndangan\Streaming;
use App\Models\KelolaUndangan\Tamu;
use App\Models\KelolaUndangan\ThumbnailWa;
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
    public function theme(){
        return $this->belongsTo(Theme::class);
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
    public function transaction(){
        return $this->hasMany(Transaction::class);
    }
    public function fiturKado(){
        return $this->hasOne(FiturKado::class);
    }

    public function imageKisah(){
        return $this->hasMany(ImgKisahCinta::class);
    }
    public function kisah(){
        return $this->hasMany(KisahCinta::class);
    }

    public function teksUndangan(){
        return $this->hasOne(TeksUndangan::class);
    }
    public function coverUndangan(){
        return $this->hasOne(coverUndangan::class);
    }
     public function teksWhatsApp(){
        return $this->hasOne(teksWhatsApp::class);
    }
    public function teksPenutup(){
        return $this->hasOne(teksPenutup::class);
    }
    public function thumbnailWas(){
        return $this->hasOne(ThumbnailWa::class);
    }
    public function qoute(){
        return $this->hasOne(Qoute::class);
    }
    public function setting(){
        return $this->hasOne(Setting::class);
    }
    
}
