<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $fillable = [
        "id",
        "name",
        "slug",
        "content",
    ];


    public function memes()
    {
        return $this->belongsToMany(\App\Models\Meme::class);
    }
}