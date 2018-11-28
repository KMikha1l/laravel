<?php

namespace App\Helpers\PostComments;

use App\Models\PostComment;
use App\Http\Resources\PostCommentResource;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

interface CommentInterface
{
    // All comments
    public function index(): string;

    // Comments for current post_id
    public function postComments(int $post_id): string;

    // Comment by id
    public function show(int $id): string;

    // Saving new comment
    public function store(Request $request): string;

    // Updating current comment
    public function update(Request $request, int $id): string;

    // Deleting current comment
    public function destroy(int $id): JsonResponse;
}
