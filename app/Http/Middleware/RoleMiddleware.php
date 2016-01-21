<?php

namespace StudentInfo\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Response;

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
        if (!$this->auth->check() || (($this->auth->check()) && !$request->user()->hasPermissionTo($role))) {
            $response = new Response([
                'error' => [
                    'message' => 'You do not have permission to view this page',
                ],
            ], 403);

            $response->header('Content-Type', 'application/json');

            return $response;
        }

        return $next($request);
    }
}