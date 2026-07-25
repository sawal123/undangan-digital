<?php

namespace App\Models;

use App\Models\KelolaUndangan\Acara;
use App\Models\KelolaUndangan\BirthdayProfile;
use App\Models\KelolaUndangan\EventDetail;
use App\Models\KelolaUndangan\FiturKado;
use App\Models\KelolaUndangan\FiturUcapan;
use App\Models\KelolaUndangan\Galery;
use App\Models\KelolaUndangan\ImgKisahCinta;
use App\Models\KelolaUndangan\Kado;
use App\Models\KelolaUndangan\KisahCinta;
use App\Models\KelolaUndangan\Pria;
use App\Models\KelolaUndangan\Qoute;
use App\Models\KelolaUndangan\Sound;
use App\Models\KelolaUndangan\Streaming;
use App\Models\KelolaUndangan\Tamu;
use App\Models\KelolaUndangan\ThumbnailWa;
use App\Models\KelolaUndangan\Ucapan;
use App\Models\KelolaUndangan\Wanita;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Data extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['user_id', 'theme_id', 'event_type_id', 'title', 'slug', 'uid', 'isActive'];

    protected $casts = [
        'isActive' => 'boolean',
    ];

    public function canBeShared(): bool
    {
        return $this->isActive === true;
    }

    public function scopeOwnedBy($query, int $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeForUid($query, string $uid)
    {
        return $query->where('uid', $uid);
    }

    protected static function booted()
    {
        static::creating(function ($data) {
            if (empty($data->uid)) {
                $data->uid = static::generateUniqueUid();
            }
        });
    }

    public static function generateUniqueUid()
    {
        do {
            $uid = Str::random(4);
        } while (static::where('uid', $uid)->exists());

        return $uid;
    }

    public function dataFont()
    {
        return $this->hasOne(DataFonts::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function theme()
    {
        return $this->belongsTo(Theme::class);
    }

    public function eventType()
    {
        return $this->belongsTo(EventType::class);
    }

    public function pria()
    {
        return $this->hasOne(Pria::class);
    }

    public function wanita()
    {
        return $this->hasOne(Wanita::class);
    }

    public function birthdayProfile()
    {
        return $this->hasOne(BirthdayProfile::class);
    }

    public function eventDetail()
    {
        return $this->hasOne(EventDetail::class);
    }

    public function acara()
    {
        return $this->hasMany(Acara::class);
    }

    public function galery()
    {
        return $this->hasMany(Galery::class);
    }

    public function sound()
    {
        return $this->hasOne(Sound::class);
    }

    public function tamu()
    {
        return $this->hasMany(Tamu::class, 'data_id');
    }

    public function ucapan()
    {
        return $this->hasMany(Ucapan::class);
    }

    public function FiturUcapan()
    {
        return $this->hasOne(FiturUcapan::class);
    }

    public function streaming()
    {
        return $this->hasOne(Streaming::class);
    }

    public function kado()
    {
        return $this->hasMany(Kado::class);
    }

    public function transaction()
    {
        return $this->hasMany(Transaction::class);
    }

    public function fiturKado()
    {
        return $this->hasOne(FiturKado::class);
    }

    public function imageKisah()
    {
        return $this->hasMany(ImgKisahCinta::class);
    }

    public function kisah()
    {
        return $this->hasMany(KisahCinta::class);
    }

    public function teksUndangan()
    {
        return $this->hasOne(TeksUndangan::class);
    }

    public function coverUndangan()
    {
        return $this->hasOne(coverUndangan::class);
    }

    public function teksWhatsApp()
    {
        return $this->hasOne(teksWhatsApp::class);
    }

    public function teksPenutup()
    {
        return $this->hasOne(teksPenutup::class);
    }

    public function thumbnailWas()
    {
        return $this->hasOne(ThumbnailWa::class);
    }

    public function qoute()
    {
        return $this->hasOne(Qoute::class);
    }

    public function setting()
    {
        return $this->hasOne(Setting::class);
    }
}
