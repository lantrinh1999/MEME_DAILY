<?php
use Botble\Meme\Repositories\Interfaces\MemeInterface;
use Botble\Meme\Repositories\Interfaces\MemeTagInterface;

if (!function_exists('getMemes')) {
    function getMemes(int $limit = 12, bool $is_paginate = true, bool $is_simple = true, bool $is_by_tag = false, int $tag_id = 0, $search = null, bool $is_random = false)
    {
        return app(MemeInterface::class)->getMemes($limit, $is_paginate, $is_simple, $is_by_tag, $tag_id, $search, $is_random);
    }
}
if (!function_exists('getHotTag')) {
    function getHotTag(int $limit = 10)
    {
        return app(MemeTagInterface::class)->getHotTag($limit);
    }
}
