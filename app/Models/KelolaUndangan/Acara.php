<?php

namespace App\Models\KelolaUndangan;

use App\Models\Data;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Acara extends Model
{
    use HasFactory;

    protected $fillable = ['data_id', 'nama_acara', 'vanue', 'alamat', 'date', 'jam_start', 'jam_end', 'zona_waktu', 'maps'];


    public function data()
    {
        return $this->belongsTo(Data::class);
    }
}
