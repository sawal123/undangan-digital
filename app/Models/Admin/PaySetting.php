<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaySetting extends Model
{
    use HasFactory;
    protected $fillable = ['bank','category', 'fee', 'image', 'deskripsi', 'isActive', 'slug'];

}
