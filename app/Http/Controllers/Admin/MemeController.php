<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Meme;
use App\Models\Meme_meta;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use App\Actions\Imgur\Imgur;
use Illuminate\Validation\Rule;

class MemeController extends Controller
{
    protected $meme;

    public function __construct(Meme $meme)
    {
        $this->meme = $meme;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $filters = (object)$request->all();

        $memes = $this->meme->orderBy('created_at', 'desc')->filter((array)$request->only('search', 'trashed'))->with('tags', 'meme_meta')
            ->paginate(!empty($request->input('pp')) ? (int)$request->input('pp') : (int)config('meme.items_per_page', 20))->onEachSide(1)
            ->only('id', 'title', 'slug','image' ,'created_at', 'status', 'deleted_at');

//        dd($memes);

        return Inertia::render('Memes/Index', compact('memes', 'filters'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $pageTitle = "Create User";
        return Inertia::render('Memes/Create', compact('pageTitle'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {


        DB::beginTransaction();
        try {
            $validator = $request->validate([
                'image.value' => ['required', 'max:1000', 'url', 'active_url'],
                'image._key' => ['required', 'max:1000'],
                'title' => ['required', 'max:500'],
                'content' => ['max:10000000000000000000000'],
                'tags' => ['nullable'],
                'status' => ['required']
            ]);
            $slug = Str::slug($validator['title']);
            if (Meme::where('slug', '=', $slug)->withTrashed()->first()) {
                $slug = $slug . '-' . Str::random(5);
            }
            $memeData = [
                'title' => $validator['title'],
                'content' => $validator['content'],
                'image' => $validator['image']['value'],
                'slug' => $slug,
                'user_id' => Auth::id(),
            ];


            if (!empty($validator['tags'])) {
                $tags = collect($validator['tags'])->map(function ($tag) {

                    if (empty($tag['slug'])) {

                        $slug = Str::slug($tag['text']);
                        if (Tag::where('slug', $slug)->exists()) {
                            $slug = $slug . '-' . time();
                        }
                        $tag = Tag::create(['name' => $tag['text'], 'slug' => $slug]);
                        if ($tag) {
                            return $tag->id;
                        }
                    }
                    return $tag['id'];
                });
            }
            $flag = false;
            $meme = $this->meme->create($memeData);

            $meme->meme_meta()->createMany([
                [
                    'key' => $validator['image']['_key'],
                    'value' => $validator['image']['value'],
                ]
            ]);
            if (!empty($tags)) {
                $meme->tags()->sync($tags);
            }
            DB::commit();
            $flag = true;
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::info($e->getMessage());
                        throw $e;
        }

        if ($flag) {
            return redirect()->back()->with('success', trans('Success'));
        }
        return redirect()->back()->with('error', trans('Errors'));
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $pageTitle = 'Detail User';
        $meme = (array)$this->meme->find($id);
//        Inertia::render('core/Users/Detail', compact('user', 'pageTitle'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $pageTitle = 'Edit User';
        $meme = $this->meme->with('tags', 'meme_meta')->find($id)->toArray();
        $meme['meme_meta'] = array_combine(
                array_column($meme['meme_meta'], 'key'),
                array_column($meme['meme_meta'], 'value')
            );
        return Inertia::render('Memes/Edit', compact('meme', 'pageTitle'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->meme = Meme::find($id);

        $validator = $request->validate([
            'image.value' => ['required', 'max:1000', 'url', 'active_url'],
            'image._key' => ['required', 'max:1000'],
            'title' => ['required', 'max:500'],
            'content' => ['max:10000000000000000000000'],
            'tags' => ['nullable'],
            'status' => ['required']
        ]);

        $memeData = [
            'title' => $validator['title'],
            'content' => $validator['content'],
            'status' => $validator['status'],
            'image' => $validator['image']['value'],
        ];


        if (!empty($validator['tags'])) {
            $tags = collect($validator['tags'])->map(function ($tag) {
                if (empty($tag['slug'])) {
                    $slug = Str::slug($tag['text']);
                    if (Tag::where('slug', $slug)->exists()) {
                        $slug = $slug . '-' . time();
                    }
                    $tag = Tag::create(['name' => $tag['text'], 'slug' => $slug]);
                    if ($tag) {
                        return $tag->id;
                    }
                }
                return $tag['id'];
            });
        }
        $flag = false;

        DB::beginTransaction();
        try {
            $meme = $this->meme->update($memeData);
            $meta = Meme_meta::where('meme_id', $this->meme->id)->where('key', '_image')->first();
//            dd($validator );
            $meta->update(['value' => $validator['image']['value']]);
            if (!empty($tags)) {
                $this->meme->tags()->sync($tags);
            }
            DB::commit();
            $flag = true;
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage());

        }

        if ($flag) {
            return redirect()->back()->with('success', trans('Success'));
        }
        return redirect()->back()->with('error', trans('Errors'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        $id = (array) $request->id;
        if ($this->meme->withTrashed()->whereIn('id', $id)->forceDelete()) {
            return redirect()->back()->with('success', trans('Success'));
        }
        return redirect()->back()->with('error', trans('error'));
    }

    public function trashed(Request $request)
    {

        $id = (array)$request->id;

        if ($this->meme->whereIn('id', $id)->delete()) {
            return redirect()->back()->with('success', trans('Success'));
        }
        return redirect()->back()->with('error', trans('error'));
    }

    public function restore(Request $request)
    {
        $id = (array)$request->id;
//        dd($id);
        if ($this->meme->withTrashed()->whereIn('id', $id)->restore()) {
            return redirect()->back()->with('success', trans('Success'));
        }
        return redirect()->back()->with('error', trans('error'));
    }


    public function store23(Request $request)
    {

        // dd(1);
        DB::beginTransaction();
        try {
            // echo '<pre>';
            $validator = $request->all();
            // var_dump($validator);die;
            // $request->validate([
            //     'title' => ['required', 'max:500'],
            //     'content' => ['max:10000000000000000000000'],
            //     'tags' => ['nullable'],
            //     'photo' => 'required|file|image|size:5000|dimensions:max_width=5000,max_height=5000',
            // ]);
            // dd(1);
            // photo
            if(empty($validator['title'])) {
                return response()->json([
                    'error' => true,
                    'message' => 'Nhap title'
                ]);
            }
            if(!empty($request->file('photo'))) {
                $photo = $request->file('photo')->getRealPath();
                $extension = $request->file('photo')->extension();
            } else {
                return response()->json([
                    'error' => true,
                    'message' => 'Dmm up anh cho tao'
                ]);
            }


            $new_image_url = Imgur::uploadImage($photo);
            $_key = '_imgur';

            if (empty($new_image_url)) {
                $new_image_url = Imgur::uploadImage23(compact('photo', 'extension'));
                $_key = '_pik';
            }
            // return response()->json([
            //     'success' => [
            //         'value' => $new_image_url,
            //         '_key' => $_key,
            //     ]
            // ]);
            $slug = Str::slug($validator['title']);
            if (Meme::where('slug', '=', $slug)->withTrashed()->first()) {
                $slug = $slug . '-' . Str::random(5);
            }
            $memeData = [
                'title' => $validator['title'],
                'content' => $validator['content'],
                'image' => trim($new_image_url),
                'slug' => $slug,
            ];



            if (!empty($validator['tags'])) {
                $tags = collect($validator['tags'])->map(function ($tag) {

                    if (empty($tag['slug'])) {

                        $slug = Str::slug($tag['text']);
                        if (Tag::where('slug', $slug)->exists()) {
                            $slug = $slug . '-' . time();
                        }
                        $tag = Tag::create(['name' => $tag['text'], 'slug' => $slug]);
                        if ($tag) {
                            return $tag->id;
                        }
                    }
                    return $tag['id'];
                });
            }
            $flag = false;
            $meme = $this->meme->create($memeData);

            $meme->meme_meta()->createMany([
                [
                    'key' => trim($_key),
                    'value' => trim($new_image_url),
                ]
            ]);
            if (!empty($tags)) {
                $meme->tags()->sync($tags);
            }
            DB::commit();
            $flag = true;
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::info($e->getMessage());
                        throw $e;
        }

        if ($flag) {
            return response()->json([
                'success' => true,
                'link' => route('theme.meme', ['slug' => $slug]),
            ]);
        }
        return response()->json([
            'success' => false
        ]);
    }

}
