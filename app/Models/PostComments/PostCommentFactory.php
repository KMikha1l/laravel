<?php

namespace App\Models\PostComments;

use Illuminate\Support\Facades\Config;

class PostCommentFactory
{
    private $config;
    const FACTORIES = [
        'DB' => 'DatabaseComment',
        'FILE' => 'FileComment',
    ];

    // creating a new factory
    public function createObject($commentsType = 'DatabaseComment'): CommentInterface
    {
        $this->setConfig($commentsType);

        $className = self::FACTORIES[$this->config];
        switch ($className) {
            case "DatabaseComment" :
            return new DatabaseComment;
                break;

            case "FileComment" :
                return new FileComment;
                break;

            default:
                return new FileComment;
        }
    }

    public function setConfig($commentsType)
    {
        if (array_key_exists($commentsType, self::FACTORIES)) {
            $this->config = $commentsType;
            return;
        }
        Config::get('app.comments_storage');
    }
}
