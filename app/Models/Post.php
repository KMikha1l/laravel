<?php
namespace App\Models;

use \Illuminate\Database\Eloquent\Model;
use \Illuminate\Database\Eloquent\Relations\HasOne;
use \Illuminate\Database\Eloquent\Relations\hasMany;

class Post extends Model
{
    protected $fillable = [
      'user_id',
      'title',
      'content',
    ];

    public function owner(): HasOne
    {
        return $this->hasOne('App\Models\User', 'id', 'user_id');
    }

    public function comments(): HasMany
    {
        return $this->hasMany('App\Models\PostComment', 'post_id', 'id');
    }
}
