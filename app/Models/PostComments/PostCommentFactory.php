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
    public function createObject($type = null): CommentInterface
    {
        $type === null ? $this->config = Config::get('app.comments_storage') : $d = 0;
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


    public function specificFactory($factoryName)
    {
//        dd(self::FACTORIES);
        if (in_array($factoryName, self::FACTORIES)) {
            $factoryName = 'App\Models\PostComments\\' . $factoryName;
            return new $factoryName;
        }
        return null;
    }
}
