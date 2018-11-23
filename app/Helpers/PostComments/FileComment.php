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

        foreach ($content->data as $k => $v) {
            $this->comments[$v->id] =$v;
        }
    }

    public function __toStting()
    {
        return json_encode($this->comments);
    }

    public function index()
    {
        return $this->comments;
    }

    public function postComments($id)
    {
        $result = [];
        foreach ($this->comments as $k => $v) {
            if ($v->post_id == $id) {
                $result[] = $v;
            }
        }

        return $result;
    }

    public function show($comment_id)
    {
//        dd($this->comments[$comment_id]);
        return $this->comments[$comment_id];
    }

    public function store(Request $request): PostCommentResource
    {
        // $var = clone(end($this->comments));
        // dd(end($this->comments));
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

        return new PostCommentResource($this->comments[$newId]);
    }

    public function update(Request $request, $comment): PostCommentResource
    {
        $comment = $this->comments[$comment];

        $comment->user_id = $request->user_id;
        $comment->post_id = $request->post_id;
        $comment->text = $request->text;
        $comment->updated_at = Carbon::now();

        $this->updateCommentsFile();

        return new PostCommentResource($comment);
    }

    public function destroy($comment): void
    {
        unset($this->comments[$comment]);

        $this->updateCommentsFile();
    }

    private function updateCommentsFile()
    {
        $updatedComments = json_encode(['data' => $this->comments]);

        // dd($updatedComments);

        Storage::disk('comments')->put('comments.json', $updatedComments);
    }
}