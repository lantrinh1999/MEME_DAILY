<?php

namespace Botble\Meme\Repositories\Eloquent;

use Botble\Base\Enums\BaseStatusEnum;
use Botble\Meme\Repositories\Interfaces\MemeTagInterface;
use Botble\Support\Repositories\Eloquent\RepositoriesAbstract;

class MemeTagRepository extends RepositoriesAbstract implements MemeTagInterface
{
    public function getHotTag(int $limit = 10)
    {
        if ($limit > 100) {
            $limit = 100;
        }

        // $memes = \DB::select(\DB::raw("SELECT `meme_tags`.* FROM `meme_tags` LEFT JOIN `meme_tag` ON `meme_tag`.`tag_id` = `meme_tags`.`id` AND `meme_tags`.`status` = 'published' LEFT JOIN `memes` ON `memes`.`id` = `meme_tag`.`meme_id` AND `meme_tags`.`status` = 'published' WHERE `meme_tags`.`status` = 'published' GROUP BY `meme_tag`.`tag_id` ORDER BY ( memes.view + meme_tags.view + COUNT(memes.id) ) DESC LIMIT $limit"));

        // dd($memes);

        $model = $this->getModel();
        $tags = $model->select(['meme_tags.*']);
        $tags = $tags->leftJoin('meme_tag', function ($join) {
            $join->on('meme_tag.tag_id', '=', 'meme_tags.id');
            $join->where('meme_tags.status', BaseStatusEnum::PUBLISHED);
        });
        $tags = $tags->leftJoin('memes', function ($join) {
            $join->on('memes.id', '=', 'meme_tag.meme_id');
            $join->where('meme_tags.status', BaseStatusEnum::PUBLISHED);
        });
        $tags = $tags->where('meme_tags.status', BaseStatusEnum::PUBLISHED);

        $tags = $tags->groupBy('meme_tag.tag_id');

        $tags = $tags->orderByRaw('(memes.view + meme_tags.view + count(memes.id)) DESC');

        $tags = $tags->with('slugable');

        $tags = $tags->limit($limit);

        $tags = $tags->get();

        return $tags->shuffle();
    }

    /**
     * {@inheritDoc}
     */
    public function getDataSiteMap()
    {
        $data = $this->model
            ->with('slugable')
            ->where('meme_tags.status', BaseStatusEnum::PUBLISHED)
            ->select('meme_tags.*')
            ->orderBy('meme_tags.created_at', 'desc');

        return $this->applyBeforeExecuteQuery($data)->get();
    }
}
