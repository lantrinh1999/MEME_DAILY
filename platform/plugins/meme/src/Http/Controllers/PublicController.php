<?php

namespace Botble\Meme\Http\Controllers;

use Botble\Meme\Models\Tag;
use Botble\Meme\Models\Meme;
use Botble\Meme\Repositories\Interfaces\MemeInterface;
use Botble\Meme\Repositories\Interfaces\MemeTagInterface;
use Botble\Meme\Services\MemeService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Response;
use SeoHelper;
use SlugHelper;
use Theme;

class PublicController extends Controller
{
    /**
     * @param Request $request
     * @param MemeInterface $postRepository
     * @return Response
     */
    public function getSearch(Request $request, MemeInterface $postRepository)
    {
        $query = $request->input('q');
        SeoHelper::setTitle(__('Search result for: ') . '"' . $query . '"')
            ->setDescription(__('Search result for: ') . '"' . $query . '"');

        $posts = $postRepository->getSearch($query, 0, 12);

        Theme::breadcrumb()
            ->add(__('Home'), url('/'))
            ->add(__('Search result for: ') . '"' . $query . '"', route('public.search'));

        return Theme::scope('search', compact('posts'))
            ->render();
    }

    /**
     * @param string $slug
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|Response
     */
    public function getTag($slug, MemeService $memeService)
    {
        $slug = SlugHelper::getSlug($slug, SlugHelper::getPrefix(MemeTag::class, 'tag'));

        if (!$slug) {
            abort(404);
        }

        $data = $memeService->handleFrontRoutes($slug);

        if (isset($data['slug']) && $data['slug'] !== $slug->key) {
            return redirect()->to(route('public.single', SlugHelper::getPrefix(MemeTag::class, 'tag') . '/' . $data['slug']));
        }

        return Theme::scope($data['view'], $data['data'], $data['default_view'])
            ->render();
    }

    /**
     * @param string $slug
     * @param MemeService $memeService
     * @return \Illuminate\Http\RedirectResponse|Response
     */
    public function getMeme($slug, MemeService $memeService)
    {
        $slug = SlugHelper::getSlug($slug, SlugHelper::getPrefix(Meme::class, 'meme'));

        if (!$slug) {
            abort(404);
        }

        $data = $memeService->handleFrontRoutes($slug);

        if (isset($data['slug']) && $data['slug'] !== $slug->key) {
            return redirect()->to(route('public.single', SlugHelper::getPrefix(Meme::class, 'meme') . '/' . $data['slug']));
        }

        return Theme::scope($data['view'], $data['data'], $data['default_view'])
            ->render();
    }
}
