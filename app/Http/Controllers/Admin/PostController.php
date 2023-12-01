<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Models\Post;
use Inertia\Inertia;
use App\Models\Category;
use App\Enums\Notification;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Services\GlobalNotification;
use App\Http\Requests\StorePostRequest;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\UpdatePostRequest;

class PostController extends Controller
{
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

        return Inertia::render('Admin/Post/Index', [
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

        return Inertia::render('Admin/Post/Create', [
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

            $notification = new GlobalNotification('post saved successfully', '', Notification::Success);

            return redirect(route('admin.post.index'))->with(['notify' => $notification]);;
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

        return Inertia::render('Admin/Post/Show', [
            'post' => $post
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        try {
            $post->categories = $post->categories;
            $categories = Category::all();

            return Inertia::render('Admin/Post/Edit', [
                'categories' => $categories,
                'post' => $post,
                'notify' => session()->get('notify'),
            ]);
        } catch (\Throwable $th) {
            $notification = new GlobalNotification('Error!!,show page for edit post', '', Notification::Error);

            return redirect(route('admin.post.index'))->with(['notify' => $notification]);;
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        DB::beginTransaction();
        try {
            $requestData = $request->validated();

            if ($request->has('image') && !is_null($request->file('image'))) {
                //save new images
                $image = $request->file('image');
                $oldImagePath = $post->image;
                $imagePath = $image->store('images', 'public');
                $imagePath = '/storage/' . $imagePath;

                $postUpdate =  $post->update([
                    "title" => $requestData["title"],
                    "description" => $requestData["description"],
                    "image" => $imagePath,
                ]);

                if (!$postUpdate) {
                    throw new Exception("error update hotel", 1);
                }

                //update post categories
                $post->categories()->sync($requestData['categories']);

                //remove old file
                $oldImagePath = str_replace('/storage/', '', $oldImagePath);
                Storage::delete($oldImagePath);
            } else {
                $postUpdate =  $post->update([
                    "title" => $requestData["title"],
                    "description" => $requestData["description"],
                ]);

                if (!$postUpdate) {
                    throw new Exception("error update hotel", 1);
                }

                $post->categories()->sync($requestData['categories']);

            }
            DB::commit();

            $notification = new GlobalNotification('post updated successfully', '', Notification::Success);
            return redirect(route('admin.post.index'))->with(['notify' => $notification]);;

        } catch (\Throwable $th) {
            DB::rollBack();

            $notification = new GlobalNotification('Error!!, post does not updated', '', Notification::Error);

            return redirect()->back()->withInput()->with(['notify' => $notification]);;
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        DB::beginTransaction();
        try {
            if (!$post) {
                throw new Exception("post does not exist");
            }

            $post->categories()->detach();

            $post->delete();

            DB::commit();

            $notification = new GlobalNotification('post removed successfully', '', Notification::Success);

            return redirect(route('admin.post.index'))->with(['notify' => $notification]);;
        } catch (\Throwable $th) {
            DB::rollBack();
            //throw $th;
            $notification = new GlobalNotification('Error!!, post does not removed', '', Notification::Error);

            return redirect()->back()->withInput()->with(['notify' => $notification]);;
        }
    }
}
