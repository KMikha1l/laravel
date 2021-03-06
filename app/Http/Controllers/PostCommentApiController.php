<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\PostComments\PostCommentFactory;

class PostCommentApiController extends Controller
{
    // Returns a full list of all comments
    public function index(): string
    {
        $factory = new PostCommentFactory;
        $model = $factory->createObject();
        $comments = $model->index();

        return $comments;
    }

    // Returns all post comments
    public function postComments($post_id): string
    {
        $factory = new PostCommentFactory;
        $model = $factory->createObject();
        $comments = $model->postComments($post_id);

        if (empty($comments)) {
            return 'Comments not found';
        }

        return $comments;
    }

    public function show($comment_id): string
    {
        $factory = new PostCommentFactory;
        $model = $factory->createObject();
        $currentComment = $model->show($comment_id);

        if (empty($currentComment)) {
            return 'Comment not found';
        }

        return $currentComment;
    }

    public function store(Request $request): string
    {
        $factory = new PostCommentFactory;
        $model = $factory->createObject();
        $comment = $model->store($request);

        return $comment;
    }

    public function update(Request $request, int $id): string
    {
        $factory = new PostCommentFactory;
        $model = $factory->createObject();
        $comment = $model->update($request, $id);

        return $comment;
    }

    public function destroy(int $id): JsonResponse
    {
        $factory = new PostCommentFactory;
        $model = $factory->createObject();
        $result = $model->destroy($id);

        return $result;
    }
}
