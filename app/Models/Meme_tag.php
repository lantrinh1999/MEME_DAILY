<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meme_tag extends Model
{
    use HasFactory;

    protected $table = 'meme_tag';
    protected  $fillable = [
        'meme_id', 'tag_id'
    ];
}
