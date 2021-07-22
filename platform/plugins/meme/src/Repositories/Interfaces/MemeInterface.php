<?php

namespace Botble\Meme\Repositories\Interfaces;

use Botble\Support\Repositories\Interfaces\RepositoryInterface;

interface MemeInterface extends RepositoryInterface
{
    public function getMemes(int $limit = 12, bool $is_paginate = true, bool $is_simple = true, bool $is_by_tag = false, int $tag_id = 0, string $search = null, bool $is_random = false);

    public function getFirst(array $arr = [], array $select = [], array $with = []);

    /**
     * @return mixed
     */
    public function getDataSiteMap();

}
