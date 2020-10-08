<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meme_meta extends Model
{
    use HasFactory;

    protected $table  = 'meme_meta';
    protected $fillable = [
        "meme_id",
        "key",
        "value",
    ];
}