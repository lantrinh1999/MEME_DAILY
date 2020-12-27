<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static orderBy(string $string, string $string1)
 */
class Tag extends Model
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
        return $this->belongsToMany(\App\Models\Meme::class, 'meme_tag', 'tag_id', 'meme_id');
    }

    protected static function booted()
    {
        static::addGlobalScope(new \App\Scopes\LocationScope);
    }
}
