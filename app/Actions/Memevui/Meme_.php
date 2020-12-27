<?php

namespace App\Actions\Memevui;

use App\Actions\Scaper\Crawler;
use App\Actions\Imgur\Imgur;
use App\Models\Meme;
use App\Models\Meme_meta;
use App\Models\Tag;
use App\Models\User;
use http\Client\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class Meme_
{

    protected array $data;
    protected int $currentPage = 0;
    protected int $nextPage;
    protected int $currentPage2 = 0;
    protected int $nextPage2 = 0;
    protected const KEY_PAGE_CACHE = 'memehay_page';

    function __construct()
    {
        $this->setCurrentPage();
        $this->setCurrentPage2();
    }

    public function run()
    {

        $this->nextPage = $this->currentPage + 1;
        $this->getData();
        try {
            $this->insertData();
        } catch (\Exception $e) {
            \Log::info($e->getMessage());
                        dd($e->getMessage());
        }
        $this->setCurrentPage($this->nextPage);
    }
    public function run2($page)
    {
        if (!isset($this->currentPage2) || $page  == $this->nextPage2 + 1){
            $this->currentPage2 = $page;
        }
        $this->nextPage2 =abs($this->currentPage2 - 1) ;
        $this->getData2();
        try {
            $this->insertData();
        } catch (\Exception $e) {
            \Log::info($e->getMessage());
                        dd($e->getMessage());
        }
        $this->setCurrentPage2($this->nextPage2);
//        dd($this->nextPage2);
    }



    public function getData()
    {
        $this->data = (new Crawler())->memehay($this->nextPage);
    }
    public function getData2()
    {
        $this->data = (new Crawler())->memehay($this->nextPage2);
    }

    public function insertData()
    {
        if (!empty($this->data)) {
            $data = $this->data;
            // dd($data);
            foreach ($data as $key => $value) {
                $tags = [];
//                $image = $value['image'];
                $new_image_url = Imgur::uploadImage2($value['image']);
                $_key = '_pik';
                if (empty($new_image_url)) {
                    $new_image_url = Imgur::uploadImage($value['image']);
                    $_key = '_imgur';
                    if (empty($new_image_url)) {
                        $new_image_url = $value['image'];
                        $_key = '_memehay';
                    }
                }
                if (array_key_exists('tags', $value)) {
                    $tags = $value['tags'];
                    unset($value['tags']);
                }

                DB::beginTransaction();
                try {

                    $meme = Meme::firstOrCreate(array_reverse($value));

                    // create_meta
                    $check_meta_exists = Meme_meta::where([
                        'meme_id' => $meme->id,
                        'key' => '_imgur',
                    ])->exists();
                    if (!$check_meta_exists) {
                        $meme->meme_meta()->createMany([
                            [
                                'key' => $_key,
                                'value' => $new_image_url,
                            ]
                        ]);
                    }
                    if (!empty($tags) && count((array) $tags) > 0) {
                        $_tag = [];
                        foreach ($tags as $key => $tag) {
                            $_tag = Tag::firstOrCreate($tag)->id;
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



    public function setCurrentPage(int $page  = 0)
    {
        if ($page) {
            Cache::store('file')->forever(self::KEY_PAGE_CACHE, $page);
        } else {
            if (Cache::store('file')->has(self::KEY_PAGE_CACHE)) {
                $this->currentPage = Cache::store('file')->get(self::KEY_PAGE_CACHE);
            } else {
                $this->currentPage = 0;
                Cache::store('file')->forever(self::KEY_PAGE_CACHE, $this->currentPage);
            }
        }
    }
    public function setCurrentPage2(int $page  = 0)
    {
        if ($page) {
            Cache::store('file')->forever(self::KEY_PAGE_CACHE . '2', $page);
        } else {
            if (Cache::store('file')->has(self::KEY_PAGE_CACHE . '2')) {
                $this->currentPage2 = Cache::store('file')->get(self::KEY_PAGE_CACHE . '2');
            } else {
                $this->currentPage2 = 0;
                Cache::store('file')->forever(self::KEY_PAGE_CACHE . '2', $this->currentPage2);
            }
        }
    }

    public function getCurrentPage()
    {
    }

    public function resetPage()
    {
        Cache::store('file')->forget(self::KEY_PAGE_CACHE);
    }
}
