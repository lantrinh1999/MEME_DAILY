<?php

namespace Botble\Meme\Repositories\Interfaces;

use Botble\Support\Repositories\Interfaces\RepositoryInterface;

interface MemeTagInterface extends RepositoryInterface
{
    public function getHotTag(int $limit = 10);
    /**
     * @return mixed
     */
    public function getDataSiteMap();
}
