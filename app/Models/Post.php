<?php
namespace App;

use \Illuminate\Database\Eloquent\Model;

class Post extends Model
{
  protected $guarded = [];

  public function owner()
  {
    return $this->hasOne('App\User');
  }
}
