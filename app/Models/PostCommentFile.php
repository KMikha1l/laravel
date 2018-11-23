<?php

namespace App\Models;

use Illuminate\Support\Facades\Storage;

class PostCommentFile
{
    public $comments = [];

    public function __construct(array $attributes = [])
    {
        $comments = $this->getComments;
    }

    protected function getComments(): array
    {
        $content = Storage::disk('comments')->get('comments.json');
        $content = json_decode($content);

        foreach ($content as $k => $v) {
            $contentArray[$v->id] = $v;
        }

        return $content2;
    }

    // public function
}
