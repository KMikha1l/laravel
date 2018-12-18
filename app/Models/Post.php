<?php
namespace App\Models;

use \Illuminate\Database\Eloquent\Model;
use \Illuminate\Database\Eloquent\Relations\HasOne;
use \Illuminate\Database\Eloquent\Relations\hasMany;
use App\Models\PostComments\PostComment;

class Post extends Model
{
    protected $fillable = [
      'user_id',
      'title',
      'content',
    ];

    public function owner(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function comments(): HasMany
    {
        return $this->hasMany(PostComment::class, 'post_id', 'id');
    }
}
