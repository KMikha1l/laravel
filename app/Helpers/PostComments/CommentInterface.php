<?php

namespace App\Helpers\PostComments;

use App\Models\PostComment;

use Illuminate\Http\Request;

interface CommentInterface
{
    // All comments
    public function index();

    // Comments for current post_id
    public function postComments($id);

    // Comment by id
    public function show($comment_id);

    // Saving new comment
    public function store(Request $request);

    // Updating current comment
    public function update(Request $request, PostComment $comment);

    // Deleting current comment
    public function destroy(PostComment $comment);
}
