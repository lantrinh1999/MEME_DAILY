<?php

namespace Botble\Meme\Repositories\Eloquent;

use Botble\Base\Enums\BaseStatusEnum;
use Botble\Meme\Repositories\Interfaces\MemeInterface;
use Botble\Support\Repositories\Eloquent\RepositoriesAbstract;

class MemeRepository extends RepositoriesAbstract implements MemeInterface
{
    public function getMemes(int $limit = 12, bool $is_paginate = true, bool $is_simple = false, bool $is_by_tag = false, int $tag_id = 0, string $search = null, bool $is_random = false)
    {
        $model = $this->getModel();

        $memes = $model->where('memes.status', BaseStatusEnum::PUBLISHED);
        // $memes = $memes->where('memes.is_hidden', '<>', 1);

        if (!empty($is_random)) {
            $memes = $memes->inRandomOrder();
        } else {
            $memes = $memes->orderBy('memes.created_at', 'DESC');
            $memes = $memes->orderBy('memes.id', 'DESC');
        }

        $memes = $memes->select('memes.*');

        $memes = $memes->leftJoin('meme_tag', function ($join) use ($is_by_tag, $tag_id) {
            $is_by_tag = $is_by_tag;
            $tag_id = $tag_id;
            $join->on('meme_tag.meme_id', '=', 'memes.id');
            $join->leftJoin('meme_tags', function ($join) use ($is_by_tag, $tag_id) {
                $join->on('meme_tag.tag_id', '=', 'meme_tags.id');
                $join->where('meme_tags.status', BaseStatusEnum::PUBLISHED);
                // $join->where('meme_tags.is_hidden', '<>', 1);
                if ($is_by_tag && !empty($tag_id)) {
                    $join->where('meme_tags.id', '=', $tag_id);
                }
            });
        });

        // $memes = $memes->whereHas('tags', function ($query) {
        //     $query->where(function($query) {
        //         $query->orWhere('meme_tags.status', BaseStatusEnum::PUBLISHED);
        //         $query->orWhereNull('meme_tags.status');
        //     });
        //     // $query->where('meme_tags.is_hidden', '<>', 1);
        // });

        if ($is_by_tag && !empty($tag_id)) {
            $memes = $memes->where('meme_tags.id', '=', $tag_id);
        }

        if (isset($search)) {
            $memes = $memes->where(function ($query) use ($search) {
                $search = trim(strip_tags($search));
                $query->orWhere('memes.name', 'LIKE', "%$search%");
                $query->orWhere('meme_tags.name', 'LIKE', "%$search%");
                $query->orWhere('memes.description', 'LIKE', "%$search%");
                $query->orWhere('meme_tags.description', 'LIKE', "%$search%");
            });
        }

        $memes = $memes
            ->distinct()
            ->with(['slugable', 'tags' => function ($query) {
                $query->with(['slugable']);
                $query->where('status', (string) BaseStatusEnum::PUBLISHED);
            }]);
        $memes = $this->applyBeforeExecuteQuery($memes);

        if ($is_paginate) {
            if ($is_simple) {
                $data = $memes->simplePaginate($limit ?? 12, ['*'], 'p');
            } else {
                $data = $memes->paginate($limit ?? 12, ['*'], 'p');
            }

            $new_data = $data->getCollection()->shuffle();

            $data = $data->setCollection($new_data);

            if (isset($search)) {
                $data = $data->appends($search);
            }

            return $data;

        }

        return $memes->limit($limit)->get();

    }

    public function getFirst(array $arr = [], array $select = [], array $with = [])
    {
        return $this->getModel()->where($arr)->select($select)->with($with)->first();
    }

    /**
     * {@inheritDoc}
     */
    public function getDataSiteMap()
    {
        $data = $this->model
            ->with('slugable')
            ->where('memes.status', BaseStatusEnum::PUBLISHED)
            ->select('memes.*')
            ->orderBy('memes.created_at', 'desc');

        return $this->applyBeforeExecuteQuery($data)->get();
    }
}
