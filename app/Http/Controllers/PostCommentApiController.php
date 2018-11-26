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
    // Returns a full list of all comments
    public function index(): string
    {
        $factory = new PostCommentFactory;
        $factory = $factory->createObject();
        $comments = $factory->index();

        return $comments;
    }

    // Returns all post comments
    public function postComments($post_id): string
    {
        $factory = new PostCommentFactory;
        $factory = $factory->createObject();
        $comments = $factory->postComments($post_id);

        if (empty($comments)) { return 'Comments not found';}

        return $comments;
    }

    public function show($comment_id): string
    {
        $factory = new PostCommentFactory;
        $factory = $factory->createObject();
        $currentComment = $factory->show($comment_id);

        if (empty($currentComment)) { return 'Comment not found';}

        return $currentComment;
    }

    public function store(Request $request): string
    {
        $factory = new PostCommentFactory;
        $factory = $factory->createObject();
        $comment = $factory->store($request);

        return $comment;
    }

    public function update(Request $request, int $id): string
    {
        $factory = new PostCommentFactory;
        $factory = $factory->createObject();
        $comment = $factory->update($request, $id);

        return $comment;
    }

    public function destroy(int $id): JsonResponse
    {
        $factory = new PostCommentFactory;
        $factory = $factory->createObject();
        $result = $factory->destroy($id);

        return $result;
    }
}
