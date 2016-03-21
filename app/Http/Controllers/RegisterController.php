<?php

namespace StudentInfo\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use LucaDegasperi\OAuth2Server\Authorizer;
use StudentInfo\ErrorCodes\UserErrorCodes;
use StudentInfo\Http\Requests\CreatePasswordPostRequest;
use StudentInfo\Http\Requests\IssueTokenPostRequest;
use StudentInfo\Jobs\SendEmails;
use StudentInfo\Jobs\SendRecoverEmail;
use StudentInfo\Jobs\SendRecoverWrongEmail;
use StudentInfo\Models\User;
use StudentInfo\Repositories\UserRepositoryInterface;
use StudentInfo\ValueObjects\Email;
use StudentInfo\ValueObjects\Password;

class RegisterController extends ApiController
{
    use DispatchesJobs;

    /**
     * @var UserRepositoryInterface
     */
    protected $userRepository;

    /**
     * @var Authorizer
     */
    protected $authorizer;

    /**
     * @param UserRepositoryInterface $userRepository
     * @param Authorizer              $authorizer
     */
    public function __construct(UserRepositoryInterface $userRepository, Authorizer $authorizer)
    {
        $this->userRepository = $userRepository;
        $this->authorizer = $authorizer;
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

            if ($user->getOrganisation()->getId() != $this->userRepository->find($this->authorizer->getResourceOwnerId())->getOrganisation()->getId()) {
                $failedToSend[] = $email;
                continue;
            }

            $user->generateRegisterToken();
            $this->userRepository->update($user);

            $this->dispatch(new SendEmails($user, $email, $user->getOrganisation()->getName()));
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
    public function register($registerToken)
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

        if ($user->getOrganisation()->getId() != $this->userRepository->find($this->authorizer->getResourceOwnerId())->getOrganisation()->getId()) {
            return $this->returnError(500, UserErrorCodes::USER_DOES_NOT_BELONG_TO_THIS_FACULTY);
        }

        $user->generateRegisterToken();
        $this->userRepository->update($user);

        return $this->returnSuccess();
    }

    public function recoverPassword($email)
    {
        /** @var User $user */
        $user = $this->userRepository->findByEmail(new Email($email));

        if ($user === null) {
            $this->dispatch(new SendRecoverWrongEmail($user, $user->getEmail()->getEmail(), $user->getOrganisation()->getName()));
            return $this->returnError(500, UserErrorCodes::USER_DOES_NOT_EXIST);
        }

        $user->setRememberToken(md5($user->getEmail()->getEmail() . time()));
        $user->setRegisterTokenCreatedAt();

        $this->dispatch(new SendRecoverEmail($user, $user->getEmail()->getEmail(), $user->getOrganisation()->getName()));
        $this->userRepository->update($user);

        return $this->returnSuccess([
            'user' => $user,
        ]);
    }

    public function recoverPasswordConfirmation($rememberToken)
    {
        /** @var User $user */
        $user = $this->userRepository->findByRememberToken($rememberToken);

        if ($user === null) {
            return $this->returnError(500, UserErrorCodes::USER_DOES_NOT_EXIST);
        }

        return $this->returnSuccess([
            'user' => $user,
        ]);
    }

    public function recoverCreatePassword(CreatePasswordPostRequest $request, $rememberToken)
    {
        /** @var User $user */
        $user = $this->userRepository->findByRememberToken($rememberToken);

        if ($user === null) {
            return $this->returnForbidden(UserErrorCodes::INVALID_REGISTER_TOKEN);
        }

        if ($user->isRegisterTokenExpired()) {
            return $this->returnForbidden(UserErrorCodes::EXPIRED_REGISTER_TOKEN);
        }

        $user->setRememberToken('');
        $user->setPassword(new Password($request->get('password')));

        $this->userRepository->update($user);

        return $this->returnSuccess([
            'user' => $user,
        ]);
    }
}