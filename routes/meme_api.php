<?php

//use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// use Illuminate\Support\Facades\Cache;
use App\Actions\Memevui\Meme_;
use App\Actions\Memevui\Meme2;
use App\Models\Meme;
use App\Actions\Imgur\Imgur;

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

//Route::get('/crawler_memehay', function () {
//    (new Meme_())->run();
//});

Route::get('/crawler_memehay_page/{page}', function ($page) {
    (new Meme2())->run($page);
});


Route::post('/uploadPhoto', function (\Illuminate\Http\Request $request) {


    $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
        'photo' => 'required|file|image|size:5000|dimensions:max_width=5000,max_height=5000',
    ]);
    $photo = $request->file('photo')->getRealPath();
    $extension = $request->file('photo')->extension();
    $new_image_url = Imgur::uploadImage23(compact('photo', 'extension'));
    $_key = '_pik';
    if (empty($new_image_url)) {
        $new_image_url = Imgur::uploadImage($photo);
        $_key = '_imgur';
    }
    return response()->json([
        'success' => [
            'value' => $new_image_url,
            '_key' => $_key,
        ]
    ]);
})->name('uploadPhoto');

Route::post('/getTags', function (\Illuminate\Http\Request $request) {
    $validator = $request->validate([
        'name' => ['required', 'max:100'],
    ]);

    $tags = \App\Models\Tag::select('id', 'name as text', 'slug')
        ->where('name', 'like', '%' . $validator['name'] . '%')
        ->limit(10)
        ->get()
        ->toArray();
    return response()->json($tags);
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
            unset($item['image']);
            unset($item['deleted_at']);

            return $item;
        });

        return response()->json($memes);
    })->where('page', '[0-9]+');
