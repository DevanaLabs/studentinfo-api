<?php


namespace StudentInfo\Http\Controllers;

use Illuminate\Auth\Guard;
use Illuminate\Mail\Mailer;
use Illuminate\Support\Facades\Mail;
use StudentInfo\ErrorCodes\UserErrorCodes;
use StudentInfo\Http\Requests\AddStudentsRequest;
use StudentInfo\Http\Requests\CreatePasswordPostRequest;
use StudentInfo\Http\Requests\IssueTokenPostRequest;
use StudentInfo\Http\Requests\Request;
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

            /** @var User $user */
            $user = $this->userRepository->findByEmail(new Email($email));

            Mail::queue('emails.register_mail_template', ['email' => $email, 'token' => $user->getRegisterToken()], function ($message) use ($email) {
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
        if ($user == null) {
            return $this->returnError(403, 'InvalidTokenException');
        }
        if ($user->isExpired($user->getRegisterTokenCreatedAt())) {
            return $this->returnError(403, 'TokenHasExpired');
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
        /** @var User $user */
        $user = $this->userRepository->findByRegisterToken($registerToken);
        if ($user == null) {
            return $this->returnError(403, 'InvalidTokenException');
        }
        if ($user->registerTokenIsExpired($user->getRegisterTokenCreatedAt())) {
            return $this->returnError(403, 'TokenHasExpired');
        }
        $user->setPassword(new Password($request->get('password')));
        $this->userRepository->updatePassword($user);
        return $this->returnSuccess(['Password is changed!']);
    }

    public function addStudents(AddStudentsRequest $request)
    {
        $students = $request->get('students');
        for($count=0; $count < count($students); $count++)
        {
            $student = new Student();
            $student->setFirstName($students[$count]['firstName']);
            $student->setLastName($students[$count]['lastName']);
            $student->setEmail(new Email($students[$count]['email']));
            $student->setIndexNumber($students[$count]['indexNumber']);
            $student->setPassword(new Password('password'));
            $student->generateRegisterToken();
            if (!$this->userRepository->findByEmail(new Email($students[$count]['email'])))
            {
                $this->userRepository->create($student);
            }
        }
    }
}