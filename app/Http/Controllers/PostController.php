<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Policies\RolePolicy;
use Inertia\Inertia;
use App\Models\Category;
use App\Enums\Notification;
use Illuminate\Support\Facades\DB;
use App\Services\GlobalNotification;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;

class PostController extends Controller
{

    public function __construct(){

    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $posts = Post::paginate(10)->onEachSide(0);

        $activeActions = false;
        if (auth()->id()) {
            $activeActions = auth()->user()->role->id == 1;
        }

        return Inertia::render('Post/Index', [
            'posts' => $posts,
            'activeAction' => $activeActions,
            'notify' => session()->get('notify'),

        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();

        return Inertia::render('Post/Create', [
            'categories' => $categories,
            'notify' => session()->get('notify'),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request)
    {
        DB::beginTransaction();
        try {
            $requestData = $request->validated();

            $imagePath  = '';
            //svae post image
            if ($request->has('image') && !is_null($request->file('image'))) {
                // Store each image
                $image = $request->file('image');
                $imagePath = $image->store('image', 'public');

                $imagePath = '/storage/' . $imagePath;
            }

            // save post
            $post = Post::create([
                'title' => $requestData['title'],
                'description' => $requestData['description'],
                'image' => $imagePath
            ]);

            //save post categories
            $post->categories()->attach($requestData['categories']);

            DB::commit();

            $notification = new GlobalNotification('post saved successfully','',Notification::Success);

            return redirect(route('post.index'))->with(['notify' => $notification]);;
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        $post->categories = $post->categories;

        return Inertia::render('Post/Show', [
            'post' => $post
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        //
    }
}
