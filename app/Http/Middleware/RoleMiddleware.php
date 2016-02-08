<?php

namespace StudentInfo\Http\Middleware;

use Closure;
use Illuminate\Http\Response;
use LucaDegasperi\OAuth2Server\Authorizer;
use StudentInfo\Models\User;
use StudentInfo\Repositories\UserRepositoryInterface;

class RoleMiddleware
{
    /**
     * @var UserRepositoryInterface
     */
    protected $userRepository;

    /**
     * @var Authorizer
     */
    protected $authorizer;

    /**
     * Create a new filter instance.
     *
     * @param UserRepositoryInterface $userRepository
     * @param Authorizer              $authorizer
     */
    public function __construct(UserRepositoryInterface $userRepository, Authorizer $authorizer)
    {
        $this->userRepository = $userRepository;
        $this->authorizer     = $authorizer;
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
        $userId = $this->authorizer->getResourceOwnerId();
        /** @var User $user */
        $user = $this->userRepository->find($userId);

        if ($user === null || (($user !== null)) && !$user->hasPermissionTo($role)) {
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