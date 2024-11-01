<?php

namespace App\Models;

use App\Models\KelolaUndangan\Pria;
use App\Models\KelolaUndangan\Acara;
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

    
}
