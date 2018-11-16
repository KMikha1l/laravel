<?php

namespace App\Http\Middleware;

use Closure;
use \Illuminate\Http\Response;
use \Illuminate\Http\Request;
use \Illuminate\Http\RedirectResponse;

class CheckRole
{
    const ADMINISTRATOR_ID = 1;
    const MODERATOR_ID = 2;
    const USER_ID = 3;

    // Roles list
    public $roles = [
        'admin' => self::ADMINISTRATOR_ID,
        'moder' => self::MODERATOR_ID,
        'user' => self::USER_ID,
    ];

    /**
     * Checking users rughts
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, string $permission): object
    {
        if ($request->user()->role_id > $this->roles[$permission]) {
            return abort('403');
        }

        return $next($request);
    }
}
