<?php


namespace StudentInfo\Http\Controllers;


use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Mail\MailQueue;
use Illuminate\Mail\Message;
use StudentInfo\ErrorCodes\UserErrorCodes;
use StudentInfo\Http\Requests\SendEmailRequest;

class TestController extends ApiController
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
     * TestController constructor.
     * @param Guard     $guard
     * @param MailQueue $mailer
     */
    public function __construct(Guard $guard, MailQueue $mailer)
    {
        $this->guard  = $guard;
        $this->mailer = $mailer;
    }


    public function testEmail(SendEmailRequest $request)
    {
        if (!in_array($request->ip(), ['79.175.125.102', '77.105.2.42', '192.168.10.1'])){
            return $this->returnForbidden(UserErrorCodes::YOU_DO_N0T_HAVE_PERMISSION_TO_SEE_THIS);
        }
        $emails = explode(',',$request->get('emails'));
        foreach ($emails as $email) {

            $this->mailer->queue('emails.register_mail_template', [
                'email' => $email,
                'token' => "Cao ljudi. ovo je test lol",
            ], function (Message $message) use ($email) {
                $message->from('us@example.com', 'Laravel');
                $message->to($email);
                $message->subject('Poziv za registraciju na studentinfo.rs');
            });
        }
        return $this->returnSuccess();
    }


}