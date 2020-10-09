<?php

//use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
// use Illuminate\Support\Facades\Cache;
use App\Actions\Memevui\Meme_;
use App\Models\Meme;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/crawler_memehay', function () {
    (new Meme_())->run();
});
Route::get('/reset_page_memehay', function () {
    (new Meme_())->resetPage();
});
Route::get('/memes/{page?}',
    function ($page = 1) {
        $limit = 20;
        $offset = ($page - 1) * $limit;
        $memes = Meme::offset($offset)
            ->limit($limit)
            ->get();
        $memes->load(['tags', 'meme_meta']);
        $collection = collect($memes->toArray());
        $memes = $collection->map(function ($item) {
            $item['meme_meta'] = array_combine(array_column($item['meme_meta'], 'key'), array_column($item['meme_meta'], 'value'));

            $item['tags'] = array_map(function ($tag) {
                return $tag = [
                    'slug' => $tag['slug'],
                    'name' => $tag['name'],
                ];
            }, $item['tags']);
            $item['created_at'] = date("Y-m-d H:i:s", strtotime($item['created_at']));
            $item['updated_at'] = date("Y-m-d H:i:s", strtotime($item['updated_at']));
            unset($item['image']);
            unset($item['deleted_at']);
            // $item['tags'] = array_combine(array_column($item['tags'], 'slug'), array_column($item['tags'], 'name'));
            return $item;
        });
        // dd($memes->all());
        return response()->json($memes);
    })->where('page', '[0-9]+');
