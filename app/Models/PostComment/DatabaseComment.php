<?php

namespace App\Models\PostComment;

use App\Models\Post;
use App\Models\PostComment\CommentInterface;
use App\Models\PostComment\PostCommentFactory;
use App\Models\PostComment\PostComment;
//use App\Models\PostComment\PostCommentResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class DatabaseComment implements CommentInterface
{
    public function index(): string
    {
        return PostComment::all()->toJson();
    }

    public function postComments(int $postId): string
    {
        $post = Post::where('id', $postId)->first();

        if (empty($post) or empty($post->comments->toArray())) {
            return json_encode(['data' => 'Comment not found']);
        }

        return $post->comments;
    }

    public function show(int $id): string
    {
        $comment = PostComment::where('id', $id)->first()->toJson();

        if (empty($comment)) {
            return json_encode(['data' => 'Comment not found']);
        }

        return $comment;
    }

    public function store(Request $request): string
    {
        $comment = PostComment::create([
            'user_id'  => $request->user_id,
            'post_id'  => $request->post_id,
            'text'     => $request->text,
        ]);

        return json_encode($comment);
    }

    public function update(Request $request, int $id): string
    {
        $comment = PostComment::where('id', $id)->first();
        $result = $comment->update($request->all());

        return json_encode($result);
    }

    public function destroy(int $id): JsonResponse
    {
        $comment = PostComment::where('id', $id)->first();
        $comment->delete();

        return response()->json(null, 204);
    }
}
