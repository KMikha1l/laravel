<?php

namespace App\Helpers\PostComments;

use App\Helpers\PostComments\CommentInterface;
use App\Helpers\PostComments\PostCommentFactory;

use App\Models\PostComment;
use App\Http\Resources\PostCommentResource;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Storage;

class FileComment implements CommentInterface
{
    private $comments = [];

    public function __construct()
    {
        $content = Storage::disk('comments')->get('comments.json');
        $content = json_decode($content);

        foreach ($content as $k => $v) {
            $this->comments[$v->id] =$v;
        }
    }

    public function index(): string
    {
        return json_encode(['data' => $this->comments]);
    }

    public function postComments($id): string
    {
        $result = [];
        foreach ($this->comments as $k => $v) {
            if ($v->post_id == $id) {
                $result[] = $v;
            }
        }

        return json_encode(['data' => $result]);
    }

    public function show($comment_id): string
    {
        if (!isset($this->comments[$comment_id])) {
            return json_encode(['data' => 'Comment not found']);
        }

        return json_encode($this->comments[$comment_id]) ?? '';
    }

    public function store(Request $request): string
    {
        $this->comments[] = clone(end($this->comments));

        end($this->comments);
        $newId = key($this->comments);

        $this->comments[$newId]->id = $newId;
        $this->comments[$newId]->user_id = $request->user_id;
        $this->comments[$newId]->post_id = $request->post_id;
        $this->comments[$newId]->text = $request->text;
        $this->comments[$newId]->created_at = Carbon::now();
        $this->comments[$newId]->updated_at = Carbon::now();

        $this->updateCommentsFile();

        return json_encode($this->comments[$newId]);
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
        $updatedComments = json_encode($this->comments);

        Storage::disk('comments')->put('comments.json', $updatedComments);
    }
}