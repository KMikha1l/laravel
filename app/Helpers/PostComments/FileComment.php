<?php

namespace App\Helpers\PostComments;

use App\Helpers\PostComments\CommentInterface;
use App\Helpers\PostComments\PostCommentFactory;
use App\Models\PostComment;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use stdClass;
use Illuminate\Support\Facades\Storage;

class FileComment implements CommentInterface
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
        $id = ++$this->comments->max('id');

        $comment = new stdClass;
        $comment->id = $id;
        $comment->user_id = $request->user_id;
        $comment->post_id = $request->post_id;
        $comment->text = $request->text;

        $comment->created_at = Carbon::now();
        $comment->updated_at = Carbon::now();

        $this->comments->push($comment);

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
