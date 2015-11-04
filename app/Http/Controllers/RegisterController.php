<?php


namespace StudentInfo\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Auth\Guard;
use Illuminate\Mail\Mailer;
use LaravelDoctrine\ORM\Facades\EntityManager;
use StudentInfo\Http\Requests\CreatePasswordPostRequest;
use StudentInfo\Http\Requests\IssueTokenPostRequest;
use StudentInfo\Repositories\UserRepositoryInterface;
use StudentInfo\ValueObjects\Password;

class RegisterController extends ApiController
{
    /**
     * @var Guard
     */
    protected $guard;
    /**
     * @var Mailer
     */
    protected $mailer;
    /**
     * @var array string
     */
    protected $failedToSend = [];
    /**
     * @var UserRepositoryInterface
     */
    private $userRepository;

    public function __construct(UserRepositoryInterface $userRepository, Guard $guard, Mailer $mailer)
    {
        $this->userRepository = $userRepository;
        $this->guard          = $guard;
        $this->mailer         = $mailer;
    }

    /**
     * @param IssueTokenPostRequest $request
     * @return array|string
     *
     * @api {post} /emails/:emails
     *
     * @apiName Login
     * @apiGroup User
     *
     * @apiParam {Array} emails Emails of the User.
     *
     * @apiSuccess {String} emails Emails of the User.
     *
     * @apiSuccessLogin Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *       {"success":{"data":["All emails were sent successfully"]}}
     *     }
     */
    public function issueRegisterTokens(IssueTokenPostRequest $request)
    {
        $emails = $request->get('emails');

        foreach ($emails as $email) {
            $this->mailer->send('welcome', ['email' => $email], function ($message) use ($email) {
                $message->from('us@example.com', 'Laravel');
                $message->to($email);
            });
            if (count($this->mailer->failures()) > 0) {
                $this->failedToSend[] = $email;
            }
        }
        return $this->returnSuccess([
            'successful'   => $emails,
            'unsuccessful' => $this->failedToSend
        ]);

    }

    /**
     * @param $registerToken
     * @return \Illuminate\Http\Response
     */
    public function registerStudent($registerToken)
    {
        $user = $this->userRepository->findByRegisterToken($registerToken);
        if ($user == null) {
            return $this->returnError(403,'InvalidTokenException');
        }
        if ($user->isExpired($user->getRegisterTokenCreatedAt())) {
            return $this->returnError(403,'TokenHasExpired');
        }
        return $this->returnSuccess(['Change you password']);
    }

    /**
     * @param CreatePasswordPostRequest $request
     * @param                           $registerToken
     * @return \Illuminate\Http\Response
     */
    public function createPassword(CreatePasswordPostRequest $request, $registerToken)
    {
        $user= $this->userRepository->findByRegisterToken($registerToken) ;
        if ($user == null) {
            return $this->returnError(403,'InvalidTokenException');
        }
        if ($user->isExpired($user->getRegisterTokenCreatedAt())) {
            return $this->returnError(403,'TokenHasExpired');
        }
        $user->setPassword(new Password($request->get('password')));
        $this->userRepository->updatePassword($user);
        return $this->returnSuccess(['Password is changed!']);
    }
}