<?php

namespace Botble\View\Models;

use Botble\Base\Models\BaseModel;
use Botble\Base\Traits\EnumCastable;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class View extends BaseModel
{
    use EnumCastable;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'views';

    /**
     * @var array
     */
    protected $fillable = [
        'viewable_id',
        'viewable_type',
        'visitor',
        'user_agent',
        'viewed_at',
    ];

    public function viewable(): MorphTo
    {
        return $this->morphTo();
    }
}
