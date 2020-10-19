<?php

namespace App\Http\Controllers\Landing;

use App\Models\Post;
use App\Http\Controllers\Controller;

class PostController extends Controller
{
    /**
     * Post instance
     *
     * @var App\Models\Post
     */
    protected $post;

    /**
     * Creates a new controller instance
     *
     * @param App\Models\Post $post
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
        $allPosts = $this->post->latest()->published()->searchByTag(request()->query('tag'));

        $latestPosts = $allPosts->get();

        $posts = $allPosts->paginate(5);

        return view('landing.posts.index', compact('posts', 'latestPosts'));
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $post = $this->post->firstOrFailBySlug($slug);

        $previous = $this->post->where('id', '<', $post->id)->orderBy('id', 'desc')->first();

        $next = $this->post->where('id', '>', $post->id)->orderBy('id')->first();

        return view('landing.posts.show', compact('post', 'previous', 'next'));
    }
}
