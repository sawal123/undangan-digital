<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventType extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'key', 'description'];

    public function data()
    {
        return $this->hasMany(Data::class);
    }

    public function themes()
    {
        return $this->hasMany(Theme::class);
    }
}
