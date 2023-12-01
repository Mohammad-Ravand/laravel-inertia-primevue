<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Models\News;
use Inertia\Inertia;
use App\Models\Category;
use App\Enums\Notification;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Services\GlobalNotification;
use App\Http\Requests\StoreNewsRequest;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\UpdateNewsRequest;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $newses = News::paginate(10)->onEachSide(0);

        $activeActions = false;
        if (auth()->id()) {
            $activeActions = auth()->user()->role->id == 1;
        }

        return Inertia::render('Admin/News/Index', [
            'newses' => $newses,
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

        return Inertia::render('Admin/News/Create', [
            'categories' => $categories,
            'notify' => session()->get('notify'),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreNewsRequest $request)
    {
        $notification = new GlobalNotification('Error, news does not saved!','',Notification::Error);

        DB::beginTransaction();
        try {
            $requestData = $request->validated();

            $imagePath  = '';
            //svae news image
            if ($request->has('image') && !is_null($request->file('image'))) {
                // Store each image
                $image = $request->file('image');
                $imagePath = $image->store('image', 'public');

                $imagePath = '/storage/' . $imagePath;
            }

            // save news
            $news = News::create([
                'title' => $requestData['title'],
                'description' => $requestData['description'],
                'image' => $imagePath
            ]);

            //save news categories
            $news->categories()->attach($requestData['categories']);

            DB::commit();

            $notification = new GlobalNotification('news saved successfully','',Notification::Success);

            return redirect(route('admin.news.index'))->with(['notify' => $notification]);;
        } catch (\Throwable $th) {
            $notification = new GlobalNotification('Error, news does not saved!','',Notification::Error);
            DB::rollBack();

            return redirect()->back()->withInput()->with('notify',$notification);
            // throw $th;
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(News $news)
    {
        $news->categories = $news->categories;

        return Inertia::render('Admin/News/Show', [
            'news' => $news
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(News $news)
    {
        try {
            $news->categories = $news->categories;
            $categories = Category::all();

            return Inertia::render('Admin/News/Edit', [
                'categories' => $categories,
                'news' => $news,
                'notify' => session()->get('notify'),
            ]);
        } catch (\Throwable $th) {
            $notification = new GlobalNotification('Error!!,show page for edit news', '', Notification::Error);

            return redirect(route('admin.news.index'))->with(['notify' => $notification]);;
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateNewsRequest $request, News $news)
    {
        DB::beginTransaction();
        try {
            $requestData = $request->validated();

            if ($request->has('image') && !is_null($request->file('image'))) {
                //save new images
                $image = $request->file('image');
                $oldImagePath = $news->image;
                $imagePath = $image->store('images', 'public');
                $imagePath = '/storage/' . $imagePath;

                $postUpdate =  $news->update([
                    "title" => $requestData["title"],
                    "description" => $requestData["description"],
                    "image" => $imagePath,
                ]);

                if (!$postUpdate) {
                    throw new Exception("error update hotel", 1);
                }

                //update news categories
                $news->categories()->sync($requestData['categories']);

                //remove old file
                $oldImagePath = str_replace('/storage/', '', $oldImagePath);
                Storage::delete($oldImagePath);
            } else {
                $postUpdate =  $news->update([
                    "title" => $requestData["title"],
                    "description" => $requestData["description"],
                ]);

                if (!$postUpdate) {
                    throw new Exception("error update hotel", 1);
                }

                $news->categories()->sync($requestData['categories']);

            }
            DB::commit();

            $notification = new GlobalNotification('news updated successfully', '', Notification::Success);
            return redirect(route('admin.news.index'))->with(['notify' => $notification]);;

        } catch (\Throwable $th) {
            DB::rollBack();

            $notification = new GlobalNotification('Error!!, news does not updated', '', Notification::Error);

            return redirect()->back()->withInput()->with(['notify' => $notification]);;
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(News $news)
    {
        DB::beginTransaction();
        try {
            if(!$news){
                throw new Exception("news does not exist");
            }

            $news->categories()->detach();

            $news->delete();

            DB::commit();

        } catch (\Throwable $th) {
            DB::rollBack();
            //throw $th;
        }
    }
}
