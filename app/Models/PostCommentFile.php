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
}
