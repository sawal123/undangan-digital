<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Animation extends Model
{
    use HasFactory;
    protected $fillable = ['nama', 'link', 'thumbnail'];
}
