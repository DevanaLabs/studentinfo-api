<?php


namespace StudentInfo\Http\Controllers;

use Illuminate\Auth\Guard;
use Illuminate\Contracts\Mail\MailQueue;
use Illuminate\Mail\Message;
use StudentInfo\ErrorCodes\UserErrorCodes;
use StudentInfo\Http\Requests\CreatePasswordPostRequest;
use StudentInfo\Http\Requests\IssueTokenPostRequest;
use StudentInfo\Models\Student;
use StudentInfo\Models\User;
use StudentInfo\Repositories\UserRepositoryInterface;
use StudentInfo\ValueObjects\Email;
use StudentInfo\ValueObjects\Password;

class RegisterController extends ApiController
{
    /**
     * @var Guard
     */
    protected $guard;
    /**
     * @var MailQueue
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

    public function __construct(UserRepositoryInterface $userRepository, Guard $guard, MailQueue $mailer)
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
     * @apiParam {Array} emails Emails of the Users.
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

            /** @var User $user */
            $user = $this->userRepository->findByEmail(new Email($email));

            $this->mailer->queue('emails.register_mail_template', [
                'email' => $email,
                'token' => $user->getRegisterToken(),
            ], function (Message $message) use ($email) {
                $message->from('us@example.com', 'Laravel');
                $message->to($email);
                $message->subject('Registration');
            });

            // TODO : Check for failed emails

        }
        return $this->returnSuccess([
            'successful'   => $emails,
            'unsuccessful' => $this->failedToSend,
        ]);

    }

    /**
     * @param $registerToken
     * @return \Illuminate\Http\Response
     */
    public function registerStudent($registerToken)
    {
        /** @var User $user */
        $user = $this->userRepository->findByRegisterToken($registerToken);
        if ($user === null) {
            return $this->returnForbidden(UserErrorCodes::INVALID_REGISTER_TOKEN);
        }

        if ($user->registerTokenIsExpired()) {
            return $this->returnForbidden(UserErrorCodes::EXPIRED_REGISTER_TOKEN);
        }
        return $this->returnSuccess();
    }

    /**
     * @param CreatePasswordPostRequest $request
     * @param                           $registerToken
     * @return \Illuminate\Http\Response
     */
    public function createPassword(CreatePasswordPostRequest $request, $registerToken)
    {
        /** @var User $user */
        $user = $this->userRepository->findByRegisterToken($registerToken);

        if ($user === null) {
            return $this->returnForbidden(UserErrorCodes::INVALID_REGISTER_TOKEN);
        }

        if ($user->registerTokenIsExpired()) {
            return $this->returnForbidden(UserErrorCodes::EXPIRED_REGISTER_TOKEN);
        }

        $user->setPassword(new Password($request->get('password')));

        $this->userRepository->update($user);

        return $this->returnSuccess([
            'user' => $user
        ]);
    }
}