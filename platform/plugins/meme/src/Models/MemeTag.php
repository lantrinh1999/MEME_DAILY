<?php

namespace Botble\Meme\Models;

use Botble\Base\Enums\BaseStatusEnum;
use Botble\Base\Models\BaseModel;
use Botble\Base\Traits\EnumCastable;

class MemeTag extends BaseModel
{
    use EnumCastable;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'meme_tags';

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
    ];

    /**
     * @var array
     */
    protected $casts = [
        'status' => BaseStatusEnum::class,
    ];

    /**
     * The roles that belong to the MemeTag
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function memes()
    {
        return $this->belongsToMany(Meme::class, 'meme_tag', 'tag_id', 'meme_id');
    }

    protected static function boot()
    {
        parent::boot();

        self::deleting(function (MemeTag $tag) {
            $tag->memes()->detach();
        });
    }
}
