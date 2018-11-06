<?php

namespace App\Http\Middleware;

use Closure;

class CheckRole
{
    private $roles = array('admin' => 1, 'moder' => 2, 'user' => 3);

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $permission)
    {
        if($request->user()->role_id > $this->roles[$permission])
        {
            return abort('403');
        }

        return $next($request);
    }
}
