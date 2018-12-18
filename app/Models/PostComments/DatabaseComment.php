<?php

namespace App\Models\PostComments;

use App\Models\Post;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DatabaseComment implements CommentInterface
{
    public function index(): string
    {
        return PostComment::all()->toJson();
    }

    public function postComments(int $postId): string
    {
        $post = Post::where('id', $postId)->first();
        if ($post === null) {
            return json_encode(['data' => 'Post not found']);
        } elseif (!$post->comments) {
            return json_encode(['data' => 'Comment not found']);
        }
        $comments = $post->comments;

        return $comments;
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
