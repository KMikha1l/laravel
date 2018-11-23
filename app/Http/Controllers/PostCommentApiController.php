<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\PostCommentResource;
use App\Models\PostComment;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\JsonResponse;

use Illuminate\Support\Facades\Storage;

use App\Helpers\PostComments\PostCommentFactory;

class PostCommentApiController extends Controller
{
    // ++ Returns a full list of all comments
    public function index()
    {
        $factory = new PostCommentFactory;
        $factory = $factory->createObject();
        $comments = $factory->index();

        return $comments;
    }

    // ++ Returns all post comments
    public function postComments($post_id)
    {
        $factory = new PostCommentFactory;
        $factory = $factory->createObject();
        $comments = $factory->postComments($post_id);

        if (empty($comments)) { return 'Comments not found';}

        return $comments;
    }

    // ++
    public function show($comment_id)
    {
        $factory = new PostCommentFactory;
        $factory = $factory->createObject();
        $currentComment = $factory->show($comment_id);

        return new PostCommentResource($currentComment);
    }

    // ++
    public function store(Request $request): PostCommentResource
    {
        $factory = new PostCommentFactory;
        $factory = $factory->createObject();
        $comment = $factory->store($request);

        return new PostCommentResource($comment);
    }

    // +
    public function update(Request $request, $comment): PostCommentResource
    {
        $factory = new PostCommentFactory;
        $factory = $factory->createObject();
        $comment = $factory->update($request, $comment);

        return new PostCommentResource($comment);
    }

    // +
    public function destroy($comment): JsonResponse
    {
        $factory = new PostCommentFactory;
        $factory = $factory->createObject();
        $comment = $factory->destroy($comment);

        return response()->json(null, 204);
    }
}
