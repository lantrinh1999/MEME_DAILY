<?php

namespace Botble\Meme\Repositories\Caches;

use Botble\Meme\Repositories\Interfaces\MemeTagInterface;
use Botble\Support\Repositories\Caches\CacheAbstractDecorator;

class MemeTagCacheDecorator extends CacheAbstractDecorator implements MemeTagInterface
{
    public function getHotTag(int $limit = 10)
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
