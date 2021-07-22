<?php

namespace Botble\Meme\Models;

use Botble\Base\Enums\BaseStatusEnum;
use Botble\Base\Models\BaseModel;
use Botble\Base\Traits\EnumCastable;

class Meme extends BaseModel
{
    use EnumCastable;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'memes';

    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'content',
        'image',
        'type',
        'author_id',
        'author_type',
        'status',
        'locate',
        'view',
        'meme_meta',
        'meme_slug',
    ];

    /**
     * @var array
     */
    protected $casts = [
        'status' => BaseStatusEnum::class,
    ];

    /**
     * @return BelongsToMany
     */
    public function tags()
    {
        return $this->belongsToMany(MemeTag::class, 'meme_tag', 'meme_id', 'tag_id');
    }

    /**
     * @return MorphTo
     */
    public function author()
    {
        return $this->morphTo();
    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(function (Meme $meme) {
            $meme->tags()->detach();
        });
    }

}
