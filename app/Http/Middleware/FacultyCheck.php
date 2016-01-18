<?php

namespace StudentInfo\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;

class FacultyCheck
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
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
//        if (!$this->auth->check()) {
//            return redirect()->guest('/');
//        }
//
//        if ($this->auth->check()) {
//            if ($request->route()->parameters()['faculty'] != $request->user()->getOrganisation()->getSlug()) {
//                return redirect()->guest('/');
//            }
//        }

        return $next($request);
    }
}