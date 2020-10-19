<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class GalleryController extends Controller
{
    /**
     * Gallery instance
     *
     * @var App\Models\Gallery
     */
    protected $gallery;

    /**
     * Creates a new controller instance
     *
     * @param App\Models\Gallery $gallery
     */
    public function __construct(Gallery $gallery)
    {
        $this->gallery = $gallery;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $galleries = $this->gallery->latest()->get();

        return view('dashboard.galleries.index', compact('galleries'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $availabletags = $this->gallery->pluck('tags')->collapse()->unique()->values()->all();

        return view('dashboard.galleries.create', compact('availabletags'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'image_file' => ['required', 'image'],
        ]);

        return DB::transaction(function () use ($request) {
            $gallery = $this->gallery->create($request->all());

            $gallery->image()->create([
                'url' => $request->file('image_file')->store(config('app.env') . '/galleries', 's3'),
            ]);

            return redirect()->route('dashboard.galleries.index');
        });
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Gallery  $gallery
     * @return \Illuminate\Http\Response
     */
    public function edit(Gallery $gallery)
    {
        $availabletags = $this->gallery->pluck('tags')->collapse()->unique()->values()->all();

        return view('dashboard.galleries.edit', compact('gallery', 'availabletags'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Gallery  $gallery
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Gallery $gallery)
    {
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'image_file' => ['nullable', 'image'],
        ]);

        return DB::transaction(function () use ($request, $gallery) {
            $gallery = $gallery->update($request->all());

            if ($request->hasFile('image_file')) {
                app('filesystem')->cloud()->delete($gallery->url);

                $gallery->image()->create([
                    'url' => $request->file('image_file')->store(config('app.env') . '/galleries', 's3'),
                ]);
            }

            return redirect()->route('dashboard.galleries.index');
        });
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Gallery  $gallery
     * @return \Illuminate\Http\Response
     */
    public function destroy(Gallery $gallery)
    {
        return DB::transaction(function () use ($gallery) {
            app('filesystem')->cloud()->delete($gallery->image->url);

            $gallery->delete();

            return redirect()->route('dashboard.galleries.index');
        });
    }
}
