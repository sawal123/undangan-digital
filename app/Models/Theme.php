<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Theme extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['nama', 'category_id', 'path', 'thumbnail'];

    public function category(){
        return $this->belongsTo(Category::class);
    }
}
