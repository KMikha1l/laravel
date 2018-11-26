<?php

namespace App\Helpers\PostComments;

use App\Models\PostComment;
use App\Http\Resources\PostCommentResource;
use Illuminate\Http\Request;

interface CommentInterface
{
    // All comments
    public function index(): string;

    // Comments for current post_id
    public function postComments($id): string;

    // Comment by id
    public function show($comment_id): object;

    // Saving new comment
    public function store(Request $request): PostCommentResource;

    // Updating current comment
    public function update(Request $request, PostComment $comment): PostCommentResource;

    // Deleting current comment
    public function destroy(PostComment $comment): void;
}
