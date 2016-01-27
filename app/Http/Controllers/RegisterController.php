<?php


namespace StudentInfo\Http\Controllers;

use Illuminate\Auth\Guard;
use Illuminate\Contracts\Mail\MailQueue;
use Illuminate\Foundation\Bus\DispatchesJobs;
use StudentInfo\ErrorCodes\UserErrorCodes;
use StudentInfo\Http\Requests\CreatePasswordPostRequest;
use StudentInfo\Http\Requests\IssueTokenPostRequest;
use StudentInfo\Jobs\SendEmails;
use StudentInfo\Models\User;
use StudentInfo\Repositories\UserRepositoryInterface;
use StudentInfo\ValueObjects\Email;
use StudentInfo\ValueObjects\Password;

class RegisterController extends ApiController
{
    use DispatchesJobs;
    /**
     * @var Guard
     */
    protected $guard;
    /**
     * @var MailQueue
     */
    protected $mailer;

    /**
     * @var UserRepositoryInterface
     */
    protected $userRepository;

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
        $sending = [];
        $failedToSend = [];

        foreach ($emails as $email) {
            /** @var User $user */
            $user = $this->userRepository->findByEmail(new Email($email));

            if ($user === null) {
                $failedToSend[] = $email;
                continue;
            }

            if ($user->getOrganisation()->getId() != $this->guard->user()->getOrganisation()->getId()) {
                $failedToSend[] = $email;
                continue;
            }

            $user->generateRegisterToken();
            $this->userRepository->update($user);

            $this->dispatch(new SendEmails($user, $email));
            $sending[] = $email;
        }
        return $this->returnSuccess([
            'sending'      => $sending,
            'unsuccessful' => $failedToSend,
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

        if ($user->isRegisterTokenExpired()) {
            return $this->returnForbidden(UserErrorCodes::EXPIRED_REGISTER_TOKEN);
        }
        return $this->returnSuccess([
            'user' => $user
        ]);
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

        if ($user->isRegisterTokenExpired()) {
            return $this->returnForbidden(UserErrorCodes::EXPIRED_REGISTER_TOKEN);
        }

        $user->setRegisterToken('');
        $user->setPassword(new Password($request->get('password')));

        $this->userRepository->update($user);

        return $this->returnSuccess([
            'user' => $user
        ]);
    }

    /**
     * @param                    $id
     * @return \Illuminate\Http\Response
     */
    public function updateRegisterToken($id)
    {
        /** @var User $user */
        $user = $this->userRepository->find($id);

        if ($user === null) {
            return $this->returnError(500, UserErrorCodes::USER_DOES_NOT_EXIST);
        }

        if ($user->getOrganisation()->getId() != $this->guard->user()->getOrganisation()->getId()) {
            return $this->returnError(500, UserErrorCodes::USER_DOES_NOT_BELONG_TO_THIS_FACULTY);
        }

        $user->generateRegisterToken();
        $this->userRepository->update($user);

        return $this->returnSuccess();
    }
}