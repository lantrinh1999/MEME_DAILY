<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Meme;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;

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

        $memes = $this->meme->filter((array)$request->only('search', 'trashed'))
            ->paginate(!empty($request->input('pp')) ? (int)$request->input('pp') : (int)config('meme.items_per_page', 20))->onEachSide(1)
            ->only('id', 'username', 'email', 'created_at', 'deleted_at');


        return Inertia::render('Memes/Index', compact('users', 'filters'));
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

//        dd($request->all());
        $validator = $request->validate([
            'image' => ['required', 'max:1000'],
            'title' => ['required', 'max:500'],
            'content' => [ 'max:10000000000000000000000'],
//            'email' => ['required', 'max:50', 'email', Rule::unique('users')],
//            'password' => ['max:50', 'min:8', 'confirmed'],
//            'is_super' => ['boolean']
        ]);
//        $validator['password'] = bcrypt($validator['password']);

        $memeData = [
            'title' => $validator['title'],
            'content' => $validator['content'],
            'image' => $validator['image']['value']
        ];
        dd($memeData);
        if ($this->meme->create($validator)) {
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
        $meme = $this->meme->find($id);
        return Inertia::render('Users/Edit', compact('user', 'pageTitle'));
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
        $validator = $request->validate([
            'first_name' => ['required', 'max:50'],
            'last_name' => ['required', 'max:50'],
            'email' => ['required', 'max:50', 'email', Rule::exists('users')],
            'password' => ['max:50', 'min:8', 'confirmed', 'nullable'],
            'is_super' => ['boolean']
        ]);
        if (!empty($validator['password']) && strlen($validator['password']) > 0) {
            $validator['password'] = bcrypt($validator['password']);
        } else {
            unset($validator['password']);
        }

        if ($this->meme->find($id)->update($validator)) {
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
        $id = array_diff((array)$request->id, (array)Auth::user()->id);
        if ($this->meme->whereIn('id', $id)->forceDelete()) {
            return redirect()->route('users.index')->with('success', trans('Success'));
        }
        return redirect()->back()->with('error', trans('error'));
    }

    public function trashed(Request $request)
    {

        $id = array_diff((array)$request->id, (array)Auth::user()->id);

        if ($this->meme->whereIn('id', $id)->delete()) {
            return redirect()->route('users.index')->with('success', trans('Success'));
        }
        return redirect()->back()->with('error', trans('error'));
    }

    public function restore(Request $request)
    {
        $id = array_diff((array)$request->id, (array)Auth::user()->id);
        if ($this->meme->whereIn('id', $id)->restore()) {
            return redirect()->back()->with('success', trans('Success'));
        }
        return redirect()->back()->with('error', trans('error'));
    }
}
