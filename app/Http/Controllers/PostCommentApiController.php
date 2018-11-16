<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\PostCommentResource;
use App\Models\PostComment;
use \Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use \Illuminate\Http\JsonResponse;

class PostCommentApiController extends Controller
{

    public function index(): AnonymousResourceCollection
    {
        return PostCommentResource::collection(PostComment::paginate(10));
    }

    public function postComments($post_id): AnonymousResourceCollection
    {
        return PostCommentResource::collection(PostComment::where('post_id', $post_id)->get());
    }

    public function store(Request $request)
    {
        $comment = PostComment::create([
            'user_id'       => $request->user_id,
            'post_id'       => $request->post_id,
            'text'          => $request->text,
        ]);

        return new PostCommentResource($comment);
    }

    public function show(PostComment $comment): UserResource
    {
        return new PostCommentResource($comment);
    }

    public function update(Request $request, PostComment $comment): UserResource
    {
        // check if currently authenticated user is the owner of the book
        // if ($request->user()->id !== $comment->user_id) {
        //     return response()->json(['error' => 'You can only edit your own comments.'], 403);
        // }

        $comment->update($request->all());

        return new PostCommentResource($comment);
    }

    public function destroy(PostComment $comment): JsonResponse
    {
        $comment->delete();

        return response()->json(null, 204);
    }
}
