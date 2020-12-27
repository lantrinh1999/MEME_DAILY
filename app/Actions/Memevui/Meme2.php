<?php


namespace App\Actions\Memevui;


use Illuminate\Http\Request;
use App\Actions\Scaper\Crawler;
use App\Actions\Imgur\Imgur;
use App\Models\Meme;
use App\Models\Meme_meta;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class Meme2
{
    protected const KEY_PAGE_CACHE = 'memehay_page';
    protected $currentPage = 0;
    protected $data;

    function __construct()
    {

    }

    public function run(int $page)
    {

        if (Cache::store('file')->has(self::KEY_PAGE_CACHE . '2___')) {
            $page_ = Cache::store('file')->get(self::KEY_PAGE_CACHE . '2___');
            if ($page_ < 1 || $page_ >= $page) {
                $page_ = $page;
                Cache::store('file')->forever(self::KEY_PAGE_CACHE . '2___', $page);
            }
        } else {
            $page_ = $page;
            Cache::store('file')->forever(self::KEY_PAGE_CACHE . '2___', $page);
        }
        $this->data = (new Crawler())->memehay($page_);
        try {
            $this->insertData();
        } catch (\Exception $e) {
            \Log::info($e->getMessage());
                        dd($e->getMessage());
        }

        Cache::store('file')->forever(self::KEY_PAGE_CACHE . '2___', $page_ - 1);

        return response()->json($this->data);

    }

    public function insertData()
    {

        $location = 1;
        if(env('SITE_GLOBAL', false) == false) {
            $location = 1;
        } else {
            $location = 2;
        }

        if (!empty($this->data)) {
            $data = array_reverse($this->data);
            foreach ($data as $key => $value) {
                $tags = [];
                if (array_key_exists('tags', $value)) {
                    $tags = $value['tags'];
                    unset($value['tags']);
                }
//                dd(Meme::where('slug', '=' , $value['slug'])->exists());
                if (empty(\DB::table('memes')->where('slug', '=', $value['slug'])->first())) {

                    DB::beginTransaction();
                    try {
                        $value['status'] = 'PUBLISH';
                        $value['location'] = $location;
                        $meme = Meme::firstOrCreate(($value));
                        $new_image_url = Imgur::uploadImage2($value['image']);
                        $_key = '_image';
                        if (empty($new_image_url)) {
                            $new_image_url = Imgur::uploadImage($value['image']);
                            if (empty($new_image_url)) {
                                $new_image_url = $value['image'];
                            }
                        }

                        $check_meta_exists = Meme_meta::where([
                            'meme_id' => $meme->id,
                            'key' => '_image',
                        ])->exists();

                        if (!$check_meta_exists) {
                            $meme->meme_meta()->createMany([
                                [
                                    'key' => $_key,
                                    'value' => $new_image_url,
                                ]
                            ]);
                        }
                        if (!empty($tags) && count((array)$tags) > 0) {
                            $_tag = [];
                            foreach ($tags as $key => $tag) {
                                $tag['location'] = $location;
                                if(empty($aa = \DB::table('tags')->where('slug', $tag['slug'])->first())) {
                                    $_tag = Tag::firstOrCreate($tag)->id;
                                } else {
                                    $_tag = $aa->id;
                                }
                            }
                            $meme->tags()->sync($_tag);
                        }
                        // create_tag
                        DB::commit();
                    } catch (\Exception $e) {
                        DB::rollBack();
                        \Log::info($e->getMessage());
                        dd($e->getMessage());
                    }
                }
            }
        }
    }

    protected function setCurrentPage(int $page)
    {
        if ($page > 0) {
            $this->currentPage = $page;
            Cache::store('file')->forever(self::KEY_PAGE_CACHE . '2___', $page);
        } else {
            $this->currentPage = 0;

        }
    }

    protected function getCurrentPage(int $page)
    {
        if ($this->currentPage > 0) {
            return $this->currentPage;
        } else {

        }
        return $this->currentPage;
    }
}
