<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Post;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class PostController extends Controller
{
    /**
     * Post instance
     *
     * @var \App\Models\Post
     */
    protected $post;

    /**
     * Creates a new controller instance
     *
     * @param \App\Models\Post $post
     */
    public function __construct(Post $post)
    {
        $this->post = $post;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = $this->post->latest()->orderByDesc('is_published')->get();

        return view('dashboard.posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $uuid = Str::uuid();

        $post = $this->post->create([
            'id' => $uuid,
            'user_id' => auth()->user()->id,
            'title' => "Borrador: $uuid",
            'slug' => $uuid,
            'excerpt' => "Borrador: $uuid",
            'content' => "[]",
            'tags' => [],
        ]);

        return redirect()->route('dashboard.posts.edit', $post);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function attachImage(Request $request, Post $post)
    {
        $savedUrl = $request->file('image')->store(config('app.env') . "/posts/$post->id", 's3');

        return response()->json([
            'success' => true,
            'file' => [
                'url' => $request->has('url') ? $request->url : app('filesystem')->cloud()->url($savedUrl),
            ],
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        $availabletags = $this->post->pluck('tags')->collapse()->unique()->values()->all();

        return view('dashboard.posts.edit', compact('post', 'availabletags'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        return DB::transaction(function () use ($request, $post) {
            if ($request->has('partial')) {
                $post->update([
                    'content' => json_encode($request->content),
                ]);

                return $post;
            }

            $request->validate([
                'title' => ['required', 'string', 'max:255'],
                'excerpt' => ['required', 'string', 'max:255'],
                'cover_file' => ['nullable', 'image'],
            ]);

            $post->update([
                'user_id' => auth()->user()->id,
                'title' => $request->title,
                'excerpt' => $request->excerpt,
                'is_published' => !$request->has('is_published'),
                'published_at' => !$request->has('is_published') ? now() : null,
                'cover' => $request->hasFile('cover_file') ? $request->file('cover_file')->store(config('app.env') . "/posts/$post->id", 's3') : $post->cover,
                'tags' => collect($request->tags)->filter()->values()->all(),
            ]);

            return redirect()->route('dashboard.posts.index');
        });
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        return DB::transaction(function () use ($post) {
            app('filesystem')->cloud()->deleteDirectory(config('app.env') . "/posts/$post->id");

            $post->delete();

            return redirect()->route('dashboard.posts.index');
        });
    }
}
