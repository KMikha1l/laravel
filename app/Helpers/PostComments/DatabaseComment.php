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
    public function index()
    {
        return PostCommentResource::collection(PostComment::paginate(15));
    }

    public function postComments($post_id)
    {
        return PostCommentResource::collection(PostComment::where('post_id', $post_id)->get());
    }

    public function show($comment_id)
    {
        $comment = PostComment::where('id', $comment_id)->get();

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

    public function destroy(PostComment $comment): JsonResponse
    {
        $comment->delete();

        return response()->json(null, 204);
    }
}
