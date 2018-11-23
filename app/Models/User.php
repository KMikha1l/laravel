<?php
namespace App\Models;

use \Illuminate\Notifications\Notifiable;
use \Illuminate\Contracts\Auth\MustVerifyEmail;
use \Illuminate\Foundation\Auth\User as Authenticatable;
use \Illuminate\Database\Eloquent\Relations\BelongsTo;
use \Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use Notifiable;

    const STATUS_DEACTIVATED = 0;
    const STATUS_ACTIVATED = 1;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'status',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function role(): BelongsTo
    {
        return $this->belongsTo('App\Models\UserRole', 'role_id', 'id');
    }

    public function comments(): HasMany
    {
        return $this->HasMany('App\Models\PostComent');
    }
}
