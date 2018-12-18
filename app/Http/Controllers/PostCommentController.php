<?php

namespace App\Http\Controllers;

use \App\Models\PostComments\PostComment;
use \Illuminate\Http\Request;
use \Illuminate\Http\RedirectResponse;
use \Illuminate\View\View;

class PostCommentController extends Controller
{

    public function index(): View
    {
        return view('comments.index', [
            'comments' => PostComment::orderBy('created_at', 'DESC')->paginate(10),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        PostComment::create($request->all());

        return redirect()->route('posts.show', $request->post_id);
    }

    public function destroy(PostComment $comment): RedirectResponse
    {
        $comment->delete();

        return redirect()->route('comments.index');
    }
}
