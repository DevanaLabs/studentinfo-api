<?php


namespace StudentInfo\Http\Controllers;

use Illuminate\Auth\Guard;
use Illuminate\Mail\Mailer;
use StudentInfo\Http\Requests\IssueTokenPostRequest;
use StudentInfo\Repositories\UserRepositoryInterface;

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
            $this->mailer->send('welcome', ['email' => $email], function ($message) use ($email) {
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
}