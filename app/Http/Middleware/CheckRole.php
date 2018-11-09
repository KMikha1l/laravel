<?php

namespace App\Http\Middleware;

use Closure;
use \Illuminate\Http\Response;

class CheckRole
{
    // Roles list
    private $roles = array('admin' => 1, 'moder' => 2, 'user' => 3);

    /**
     * Checking users rughts
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $permission): Response
    {
        if($request->user()->role_id > $this->roles[$permission])
        {
            return abort('403');
        }
        return $next($request);
    }
}
