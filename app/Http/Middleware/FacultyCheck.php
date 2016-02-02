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
//        if (!$this->auth->check()){
//            $response = new Response([
//                'error' => [
//                    'message' => 'You are not logged in',
//                ],
//            ], 403);
//
//            $response->header('Content-Type', 'application/json');
//
//            return $response;
//        }
//        if ($request->route()->parameters()['faculty'] != $request->user()->getOrganisation()->getSlug()) {
//            $response = new Response([
//                'error' => [
//                    'message' => 'You do not have permission to view this page',
//                ],
//            ], 403);
//
//            $response->header('Content-Type', 'application/json');
//
//            return $response;
//        }

        return $next($request);
    }
}