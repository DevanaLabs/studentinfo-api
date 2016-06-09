<?php


namespace StudentInfo\Http\Controllers;


use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Mail\MailQueue;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Mail\Message;
use StudentInfo\ErrorCodes\UserErrorCodes;
use StudentInfo\Http\Requests\SendEmailRequest;
use StudentInfo\Jobs\SendInactiveBoardEmail;
use StudentInfo\Repositories\ActivityLogRepositoryInterface;
use Symfony\Component\HttpFoundation\Request;

class TestController extends ApiController
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
     * @var ActivityLogRepositoryInterface
     */
    private $activityLogRepository;

    /**
     * TestController constructor.
     *
     * @param \Illuminate\Contracts\Auth\Guard     $guard
     * @param \Illuminate\Contracts\Mail\MailQueue $mailer
     * @param                                      $activityLogRepository
     */
    public function __construct(\Illuminate\Contracts\Auth\Guard $guard, \Illuminate\Contracts\Mail\MailQueue $mailer, ActivityLogRepositoryInterface $activityLogRepository)
    {
        $this->guard                 = $guard;
        $this->mailer                = $mailer;
        $this->activityLogRepository = $activityLogRepository;
    }


    public function testEmail(SendEmailRequest $request)
    {
        if (!in_array($request->ip(), ['79.175.125.102', '77.105.2.42', '192.168.10.1'])){
            return $this->returnForbidden(UserErrorCodes::YOU_DO_N0T_HAVE_PERMISSION_TO_SEE_THIS);
        }
        $emails = $request->get('emails');
        foreach ($emails as $email) {

            $this->mailer->queue('emails.register_mail_template', [
                'email' => $email,
                'token' => "Cao ljudi. ovo je test lol",
                'faculty' => 'test',
            ], function (Message $message) use ($email) {
                $message->from('us@example.com', 'Laravel');
                $message->to($email);
                $message->subject('Poziv za registraciju na studentinfo.rs');
            });
        }
        return $this->returnSuccess();
    }

    public function testInactivity(Request $request)
    {
        $email = 'vucic94@yahoo.com';

        $inactiveBoards = $this->activityLogRepository->getInactiveFor(30);

        $this->mailer->queue('emails.register_mail_template', [
            'email' => $email,
            'token' => "Cao ljudi. ovo je test lol",
            'faculty' => 'test',
        ], function (Message $message) use ($email) {
            $message->from('us@example.com', 'Laravel');
            $message->to($email);
            $message->subject('Poziv za registraciju na studentinfo.rs');
        });        $this->dispatch(new SendInactiveBoardEmail($inactiveBoards, $email));

        dd($inactiveBoards);
        $this->returnSuccess($inactiveBoards);
    }


}