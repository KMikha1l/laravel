<?php

namespace App\Helpers\PostComments;

use App\Helpers\PostComments\CommentInterface;
use App\Helpers\PostComments\PostCommentFactory;

use App\Models\PostComment;
use App\Http\Resources\PostCommentResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class DatabaseComment implements CommentInterface
{
    public function index(): string
    {
        return PostComment::get()->toJson();
    }

    public function postComments($post_id): string
    {
        return PostComment::where('post_id', $post_id)->get()->toJson();
    }

    public function show($comment_id): object
    {
        $comment = PostComment::where('id', $comment_id)->get();

        if (!isset($comment[0])) {
            return abort('404');
        }

        return $comment[0];
    }

    public function store(Request $request): PostCommentResource
    {
        $comment = PostComment::create([
            'user_id'  => $request->user_id,
            'post_id'  => $request->post_id,
            'text'     => $request->text,
        ]);

        return new PostCommentResource($comment);
    }

    public function update(Request $request, PostComment $comment): PostCommentResource
    {
        $comment->update($request->all());

        return new PostCommentResource($comment);
    }

    public function destroy(PostComment $comment): void
    {
        $comment->delete();
    }
}
