<?php


namespace StudentInfo\Http\Controllers;

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

    public function issueRegisterTokens(IssueTokenPostRequest $request)
    {
        $emails = $request->get('emails');

        foreach ($emails as $email) {
            $this->mailer->send($this->guard->user()->getRememberToken(), ['email' => $email], function ($message) use ($email) {
                $message->from('us@example.com', 'Laravel');
                $message->to($email);
            });
            if (count($this->mailer->failures()) > 0) {
                $this->failedToSend[] = $email;
            }
        }

        if (empty($this->getFailedToSend())) {
            return 'All emails were sent successfully';
        }

        $this->returnSuccess([
            'successful'   => $emails,
            'unsuccessful' => $this->failedToSend
        ]);

        return $this->getFailedToSend();
    }


    /**
     * @return array
     */
    public function getFailedToSend()
    {
        return $this->failedToSend;
    }

    public function registerStudent($rememberToken)
    {
        if ($this->userRepository->findByRememberToken($rememberToken) == null){
            return $this->returnError(403,'InvalidTokenException');
        }
        return $this->returnSuccess(['Change you password']);
    }

    public function createPassword(CreatePasswordPostRequest $request, $rememberToken)
    {
        if ($this->userRepository->findByRememberToken($rememberToken) == null){
            return $this->returnError(403,'InvalidTokenException');
        }
        $password = $request->get('password');
        $this->userRepository->findByRememberToken($rememberToken)->setPassword(new Password($password));
        $this->userRepository->updatePassword($this->userRepository->findByRememberToken($rememberToken));
        return $this->returnSuccess(['Password is changed!']);
    }
}