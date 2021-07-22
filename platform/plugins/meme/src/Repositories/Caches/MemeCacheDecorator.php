<?php

namespace Botble\Meme\Repositories\Caches;

use Botble\Meme\Repositories\Interfaces\MemeInterface;
use Botble\Support\Repositories\Caches\CacheAbstractDecorator;

class MemeCacheDecorator extends CacheAbstractDecorator implements MemeInterface
{
    public function getMemes(int $limit = 12, bool $is_paginate = true, bool $is_simple = true, bool $is_by_tag = false, int $tag_id = 0, string $search = null, bool $is_random = false)
    {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }

    public function getFirst(array $arr = [], array $select = [], array $with = [])
    {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function getDataSiteMap()
    {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }
}
