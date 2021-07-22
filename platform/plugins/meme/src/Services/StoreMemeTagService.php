<?php

namespace Botble\Meme\Services;

use Botble\ACL\Models\User;
use Botble\Base\Events\CreatedContentEvent;
use Botble\Meme\Models\Meme;
use Botble\Meme\Services\Abstracts\StoreMemeTagServiceAbstract;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StoreMemeTagService extends StoreMemeTagServiceAbstract
{

    /**
     * @param Request $request
     * @param Meme $meme
     * @return mixed|void
     */
    public function execute(Request $request, Meme $meme)
    {
        $tags = $meme->tags->pluck('name')->all();

        if (!is_array($request->input('tag'))) {
            $tagsInput = collect(json_decode($request->input('tag'), true))->pluck('value')->all();
        }

        if ((empty($tagsInput) || count($tagsInput) == 0) && !empty($request->input('tag')) && is_array($request->input('tag'))) {
            $tagsInput = $request->input('tag');
        }

        if (count($tags) != count($tagsInput) || count(array_diff($tags, $tagsInput)) > 0) {
            $meme->tags()->detach();
            foreach ($tagsInput as $tagName) {

                if (!trim($tagName)) {
                    continue;
                }

                $tag = $this->memeTagRepository->getFirstBy(['name' => $tagName]);

                if ($tag === null && !empty($tagName)) {
                    $tag = $this->memeTagRepository->createOrUpdate([
                        'name' => $tagName,
                        'author_id' => Auth::check() ? Auth::id() : 0,
                        'author_type' => User::class,
                    ]);

                    $request->merge(['slug' => $tagName]);

                    event(new CreatedContentEvent(MEME_TAG_MODULE_SCREEN_NAME, $request, $tag));
                }

                if (!empty($tag)) {
                    $meme->tags()->attach($tag->id);
                }
            }
        }
    }
}
