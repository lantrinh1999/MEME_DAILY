<?php

namespace Botble\Meme\Services;

use Botble\Base\Enums\BaseStatusEnum;
use Botble\Meme\Models\Meme;
use Botble\Meme\Models\MemeTag;
use Botble\Meme\Repositories\Interfaces\MemeInterface;
use Botble\Meme\Repositories\Interfaces\MemeTagInterface;
use Botble\SeoHelper\SeoOpenGraph;
use Eloquent;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use RvMedia;
use SeoHelper;

class MemeService
{
    /**
     * @param Eloquent $slug
     * @return array|Eloquent
     */
    public function handleFrontRoutes($slug)
    {
        if (!$slug instanceof Eloquent) {
            return $slug;
        }

        $condition = [
            'id' => $slug->reference_id,
            'status' => BaseStatusEnum::PUBLISHED,
        ];

        if (Auth::check() && request()->input('preview')) {
            Arr::forget($condition, 'status');
        }

        switch ($slug->reference_type) {
            case Meme::class:
                $meme = app(MemeInterface::class)
                    ->getFirst($condition, ['*'],
                        ['tags' => function ($query) {
                            return $query->where('status', (string) BaseStatusEnum::PUBLISHED)->with('slugable');
                        }, 'slugable']);

                if (empty($meme)) {
                    abort(404);
                }

                // Helper::handleViewCount($meme, 'viewed_meme');

                $des = $meme->description;
                if (!empty($des) && !empty(\theme_option('seo_description')) && strlen(trim(\theme_option('seo_description'))) > 0) {
                    $des = $des . '. ' . theme_option('seo_description');
                }

                $tit = $meme->name;
                if (!empty($tit) && !empty(\theme_option('seo_title')) && strlen(trim(\theme_option('seo_title'))) > 0) {
                    $tit = $tit . ' | ' . theme_option('seo_title');
                }
                SeoHelper::setTitle($meme->name)
                    ->setDescription($des);

                $meta = new SeoOpenGraph;
                if ($meme->image) {
                    $meta->setImage(RvMedia::getImageUrl($meme->image));
                }
                $meta->setDescription($des);
                $meta->setUrl(route('public.meme', $meme->slugable->key));
                $meta->setTitle($tit);
                $meta->setType('article');

                SeoHelper::setSeoOpenGraph($meta);

                do_action(BASE_ACTION_PUBLIC_RENDER_SINGLE, MEME_MODULE_SCREEN_NAME, $meme);

                \handleViewCount($meme);

                return [
                    'view' => 'meme',
                    'default_view' => 'plugins/blog::themes.meme',
                    'data' => compact('meme'),
                    'slug' => $meme->slug,
                ];
            case MemeTag::class:
                $tag = app(MemeTagInterface::class)->getFirstBy($condition, ['*'], ['slugable']);

                if (!$tag) {
                    abort(404);
                }

                $des = $tag->description;
                if (!empty($des) && !empty(\theme_option('seo_description')) && strlen(trim(\theme_option('seo_description'))) > 0) {
                    $des = $des . '. ' . theme_option('seo_description');
                }

                $tit = $tag->name;
                if (!empty($tit) && !empty(\theme_option('seo_title')) && strlen(trim(\theme_option('seo_title'))) > 0) {
                    $tit = $tit . ' | ' . theme_option('seo_title');
                }
                SeoHelper::setTitle($tag->name)
                    ->setDescription($des);

                $meta = new SeoOpenGraph;
                $meta->setDescription($des);
                $meta->setUrl($tag->url);
                $meta->setTitle($tit);
                $meta->setType('article');

                do_action(BASE_ACTION_PUBLIC_RENDER_SINGLE, MEME_TAG_MODULE_SCREEN_NAME, $tag);

                \handleViewCount($tag);

                return [
                    'view' => 'meme-tag',
                    'default_view' => 'plugins/meme::themes.meme-tag',
                    'data' => compact('tag'),
                    'slug' => $tag->slugable->key,
                ];
        }

        return $slug;
    }
}
