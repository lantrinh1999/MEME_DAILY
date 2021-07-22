<?php

namespace Botble\Base\Repositories\Caches;

use Botble\Base\Repositories\Interfaces\MetaBoxInterface;
use Botble\Support\Repositories\Caches\CacheAbstractDecorator;

class MetaBoxCacheDecorator extends CacheAbstractDecorator implements MetaBoxInterface
{
    public function getFirst(array $arr = [], array $select = [])
    {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }
}
