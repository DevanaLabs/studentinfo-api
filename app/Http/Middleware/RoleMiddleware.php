<?php
/**
 * Created by PhpStorm.
 * User: Nebojsa
 * Date: 11/23/2015
 * Time: 1:07 PM
 */

namespace StudentInfo\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;

class RoleMiddleware
{
    /**
     * The Guard implementation.
     *
     * @var Guard
     */
    protected $auth;

    /**
     * Create a new filter instance.
     *
     * @param  Guard $auth
     *
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure                 $next
     *
     * @param                           $role
     * @return mixed
     */
    public function handle($request, Closure $next, $role)
    {
        if ($this->auth->check()) {
            if (! $request->user()->hasPermissionTo($role)) {
                return redirect()->guest('/');
            }
        }

        return $next($request);
    }
}