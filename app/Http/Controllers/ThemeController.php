<?php

namespace App\Http\Controllers;

use App\Models\Meme;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

class ThemeController extends Controller
{

    protected function getMemeData(array $data): array
    {
        $collection = collect($data);
        $memes = $collection->map(function ($item) {
            $item['meme_meta'] = array_combine(
                array_column($item['meme_meta'], 'key'),
                array_column($item['meme_meta'], 'value')
            );
            $item['tags'] = array_map(function ($tag) {
                return $tag = [
                    'slug' => $tag['slug'],
                    'name' => $tag['name'],
                ];
            }, $item['tags']);
            $item['created_at'] = date("Y-m-d H:i:s", strtotime($item['created_at']));
            $item['updated_at'] = date("Y-m-d H:i:s", strtotime($item['updated_at']));
            unset($item['deleted_at']);

            return $item;
        })->toArray();

        return $memes;
    }

    public function home(Request $request, $page = 1)
    {
        abort_if(!is_numeric($page), 404);

        $limit = 20;
        $offset = ($page - 1) * $limit;
        $memes = Meme::orderBy('id', 'desc')
            ->offset($offset)
            ->limit($limit)
            ->get();
        $memes->load(['tags', 'meme_meta']);
        $memes = $this->getMemeData($memes->toArray());
        $nextPage = $page + 1;

        $nextMeme = Meme::where('id', '<', @(end($memes)['id']) ?? 0)->exists();
        if (!$nextMeme) {
            $nextPage = false;
        }

        return view('theme.index', compact('memes', 'page', 'nextPage'));
    }

    public function allTags()
    {
        $tags = Tag::orderBy('created_at', 'desc')
            ->limit(200)
            ->get()
            ->toArray();

        return view('theme.allTags', compact('tags'));
    }


    public function tag(Request $request, $slug, $page = 1)
    {
        $page = (int)$page;

        $limit = 20;
        $offset = ($page - 1) * $limit;
        $tag = Tag::where('slug', $slug)
            ->withCount('memes')
            ->with(['memes' => function ($query) use ($page, $limit, $offset) {
                $memes = $query->with(['tags', 'meme_meta'])
                    ->orderBy('id', 'desc')
                    ->offset($offset)
                    ->limit($limit)
                    ->get();
                return $memes;
            }])->first();

        abort_if(!$tag, '404');
        if ($page == 1) {
            $tag->increment('view_count');
        }

        $tag = $tag->toArray();
        $memes = $this->getMemeData($tag['memes']);
        $nextPage = $page + 1;

        $nextMeme = Meme::whereHas('tags', function (Builder $query) use ($tag) {
            $query->where('tags.id', '=', $tag['id']);
        })->where('memes.id', '<', @(end($memes)['id']) ?? 0)
            ->exists();
        if (!$nextMeme) {
            $nextPage = false;
        }

        return view('theme.index', compact('tag', 'memes', 'page', 'nextPage'));

    }
}
