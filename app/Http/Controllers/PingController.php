<?php namespace StudentInfo\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;

class PingController extends ApiController
{
    /**
     * @var Guard
     */
    protected $guard;

    /**
     * PingController constructor.
     *
     * @param \Illuminate\Contracts\Auth\Guard $guard
     */
    public function __construct(Guard $guard)
    {
        $this->guard = $guard;
    }

    public function ping(Request $request)
    {
//        $username = $this->guard->user();
//        $time = Carbon::now();
        echo "Pong";

    }


}