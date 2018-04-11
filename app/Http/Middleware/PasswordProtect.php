<?php
/**
 * Date: 2018-04-10
 * Time: 22:14
 */

namespace App\Http\Middleware;


use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PasswordProtect
{
    /** @var array $routes */
    protected $routes = [
        'admin',
    ];

    /**
     * @param Request $request
     * @param Closure $next
     * @param null    $guard
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function handle(Request $request, Closure $next, $guard = null)
    {
        if (in_array($request->path(), $this->routes) && !Auth::guard($guard)->check()) {
            session()->put('redirectTo', $request->path());
            $action = redirect('/login-password');
        } else {
            $action = $next($request);
        }

        return $action;
    }
}
