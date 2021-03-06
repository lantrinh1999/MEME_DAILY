<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @method static select(string $string)
 * @method static published()
 */
class Meme extends Model
{
    protected $status = [
      1 => 'PUBLISH',
      0  => 'DRAFT'
    ];
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        "title",
        "content",
        "description",
        "slug",
        "image",
        "status",
        "meme_type",
        "user_id",
        "location"
    ];

    protected static function booted()
    {
        static::addGlobalScope(new \App\Scopes\LocationScope);
    }


    public function tags()
    {
        return $this->belongsToMany(\App\Models\Tag::class, 'meme_tag', 'meme_id', 'tag_id');
    }

    public function categories()
    {
        return $this->belongsToMany(\App\Models\Category::class, 'meme_category', 'meme_id', 'category_id');
    }

    public function meme_meta()
    {
        return $this->hasMany(\App\Models\Meme_meta::class);
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'PUBLISH');
    }

    public function public()
    {
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where(function ($query) use ($search) {
                $query->where('title', 'like', '%' . trim($search) . '%')
                    ->orWhere('slug', 'like', '%' . trim($search) . '%');
            });
        })->when($filters['role'] ?? null, function ($query, $role) {
            $query->whereRole($role);
        })->when($filters['trashed'] ?? null, function ($query, $trashed) {
            if ($trashed === 'only') {
                $query->onlyTrashed();
            }
        });
    }
}
