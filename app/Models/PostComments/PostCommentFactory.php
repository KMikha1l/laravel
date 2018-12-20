<?php

namespace App\Models\PostComments;

use Illuminate\Support\Facades\Config;

class PostCommentFactory
{
    const FACTORIES = [
        'DB' => 'DatabaseComment',
        'FILE' => 'FileComment',
    ];

    // creating a new factory
    public function createObject(): CommentInterface
    {
        $key = Config::get('app.comments_storage');
        $factoryName = self::FACTORIES[$key];

        return $this->specificFactory($factoryName);
    }

    public function specificFactory(string $factoryName): CommentInterface
    {
        if (in_array($factoryName, self::FACTORIES)) {
            $factoryName = 'App\Models\PostComments\\' . $factoryName;
            return new $factoryName;
        }
        abort(500, "File $factoryName does not exist");
    }
}
