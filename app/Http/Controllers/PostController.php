<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use App\User;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index(): View
    {
        return view('posts.index', [
            'posts' => Post::paginate(10),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create(): View
    {
        return view('posts.create', [
            'users' => User::get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        // dd($request->user_id);
        Post::create($request->all());

        return redirect()->route('posts.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  Post  $post
     * @return View
     */
    public function show(Post $post): View
    {
        return view('posts.show', [
            'post' => $post,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Post  $post
     * @return View
     */
    public function edit(Post $post): View
    {
        return view('posts.edit', [
            'post' => $post,
            'users' => User::get()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  Post  $post
     * @return RedirectResponse
     */
    public function update(Request $request, Post $post): RedirectResponse
    {
        $post->update($request->all());

        return redirect()->route('posts.show', $post);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Post  $post
     * @return RedirectResponse
     */
    public function destroy(Post $post): RedirectResponse
    {
        $post->delete();

        return redirect()->route('posts.index');
    }
}
