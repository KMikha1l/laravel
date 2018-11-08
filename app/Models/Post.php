<?php
namespace App\Models;

use \Illuminate\Database\Eloquent\Model;
use \Illuminate\Database\Eloquent\Relations\HasOne;

class Post extends Model
{
    protected $fillable = [
      'user_id',
      'title',
      'content',
    ];

    public function owner(): HasOne
    {
        return $this->hasOne('App\User', 'id', 'user_id');
    }
}
