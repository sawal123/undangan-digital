<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PriceList extends Model
{
    use HasFactory , SoftDeletes;

    protected $fillable =['name_packet', 'price', 'deskripsi', 'keterangan'];

    public function diskon(){
        return $this->hasOne(Diskon::class, 'price_id');
    }
}
