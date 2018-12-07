<?php

namespace App\Helpers\PostComments;

use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
// use stdClass;
use Illuminate\Support\Facades\Storage;


class FileComment extends Comment implements CommentInterface
{
    private $comments;
    private $model;

    public function __construct()
    {
        $fileContent = Storage::disk('comments')->get('comments.json');
        $jsonComments = json_decode($fileContent);
        $this->comments = collect($jsonComments);
    }

    public function index(): string
    {
        return $this->comments->toJson();
    }

    public function postComments($post_id): string
    {
        return $this->comments->where('post_id', $post_id)->toJson();
    }

    public function show($id): string
    {
        return $this->comments->where('id', $id)->toJson();
    }

    public function store(Request $request): string
    {
        $id = ($this->comments->max('id') + 1);

        $comment = new Comment;
        $comment->id = $id;
        $comment->user_id = $request->user_id;
        $comment->post_id = $request->post_id;
        $comment->text = $request->text;

        $comment->created_at = Carbon::now();
        $comment->updated_at = Carbon::now();

        $this->comments->push(get_object_vars($comment));

        $this->updateCommentsFile();
        return json_encode($this->comments->last());
    }

    public function update(Request $request, int $id): string
    {
        $comment = $this->comments[$id];

        $comment->user_id = $request->user_id;
        $comment->post_id = $request->post_id;
        $comment->text = $request->text;
        $comment->updated_at = Carbon::now();
        $this->updateCommentsFile();

        return json_encode($comment);
    }

    public function destroy(int $id): JsonResponse
    {
        unset($this->comments[$id]);
        $this->updateCommentsFile();

        return response()->json(null, 204);
    }

    private function updateCommentsFile(): void
    {
        $updatedComments = $this->comments->toJson();

        Storage::disk('comments')->put('comments.json', $updatedComments);
    }
}
