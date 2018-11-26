<?php

namespace App\Helpers\PostComments;

use App\Helpers\PostComments\CommentInterface;
use App\Helpers\PostComments\PostCommentFactory;

use App\Models\PostComment;
use App\Http\Resources\PostCommentResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class DatabaseComment implements CommentInterface
{
    public function index(): string
    {
        return PostComment::get()->toJson();
    }

    public function postComments(int $post_id): string
    {
        $comments = PostComment::where('post_id', $post_id)->get()->toJson();
        if (!empty($comments)) {
            return json_encode(['data' => 'Comment not found']);
        }

        return $comments;
    }

    public function show(int $id): string
    {
        $comment = PostComment::where('id', $id)->get()->toJson();

        if (!empty($comment)) {
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
        $comment->update($request->all());

        return json_encode($comment);
    }

    public function destroy(int $id): JsonResponse
    {
        $comment = PostComment::where('id', $id)->first();
        $comment->delete();

        return response()->json(null, 204);
    }
}
