<?php

namespace App\Models\PostComments;

use \Illuminate\Database\Eloquent\Model;
use \Illuminate\Database\Eloquent\Relations\BelongsTo;

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
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }

    public function post(): BelongsTo
    {
        return $this->belongsTo('App\Models\Post', 'post_id', 'id');
    }

    public static function comentsList()
    {
        return self::paginate();
    }
}
