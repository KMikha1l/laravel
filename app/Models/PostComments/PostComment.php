<?php

namespace App\Models\PostComments;

use \Illuminate\Database\Eloquent\Model;
use \Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;
use App\Models\Post;

class PostComment extends Model
{
    protected $table = 'post_coments';
    protected $fillable = [
        'post_id',
        'user_id',
        'text',
    ];

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class, 'post_id', 'id');
    }

    public static function commentsList()
    {
        return self::paginate();
    }
}
