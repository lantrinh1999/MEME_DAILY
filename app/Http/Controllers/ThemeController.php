<?php

namespace App\Http\Controllers;

use App\Models\Meme;
use Illuminate\Http\Request;

class ThemeController extends Controller
{
    public function index(Request $request, $page = 1)
    {

        abort_if(!is_numeric($page), 404);

        $limit = 20;
        $offset = ($page - 1) * $limit;
        $memes = Meme::orderBy('id', 'desc')->offset($offset)
            ->limit($limit)
            ->get();
        $memes->load(['tags', 'meme_meta']);
        $collection = collect($memes->toArray());
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
//            unset($item['image']);
            unset($item['deleted_at']);

            // $item['tags'] = array_combine(array_column($item['tags'], 'slug'), array_column($item['tags'], 'name'));
            return $item;
        })->toArray();
//        dd($memes);
        $nextPage = $page+1;

        return view('theme.index', compact('memes', 'page', 'nextPage'));
    }
}
