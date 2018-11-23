<?php

namespace App\Helpers\PostComments;

use Illuminate\Support\Facades\Config;
use App\Helpers\PostComments\DatabaseComment;
use App\Helpers\PostComments\FileComment;

class PostCommentFactory
{
    private $config;
    private $factories = [
        'DB' => 'DatabaseComment',
        'File' => 'FileComment',
    ];

    // creating a new factory
    public function createObject()
    {
        $this->config = Config::get('app.comments_storage');
        $className = $this->factories[$this->config];
        switch ($className) {
            case "DatabaseComment" : return new DatabaseComment;
                break;

            case "FileComment" : return new FileComment;
                break;

            default: return new FileComment;
        }
    }
}
