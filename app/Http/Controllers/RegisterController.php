<?php


namespace StudentInfo\Http\Controllers;

use Illuminate\Auth\Guard;
use Illuminate\Http\Request;
use Illuminate\Mail\Mailer;
use StudentInfo\Repositories\UserRepositoryInterface;

class RegisterController extends ApiController
{
    /*
     * @var array string
     */
    protected $failedToSend=[];

    /**
     * @param UserRepositoryInterface $repository
     * @param Guard                   $guard
     * @param Mailer                  $mailer
     * @param Request                 $request
     * @return string
     * @internal param array $emails
     */
    public function issueRegisterTokens(UserRepositoryInterface $repository, Guard $guard, Mailer $mailer, Request $request)
    {
        if ($repository->isAdmin($guard->user())==null)
            return 'You\'re not admin';
        if (($repository->isAdmin($guard->user())!=null)  && (!$repository->isAdmin($guard->user()->getId())))
            return 'You\'re not admin';
        //$message = "Please click the following link to register:/n";
        $input = $request->input();
        $emails = $input['emails'];
        foreach ($emails as $email) {
            $mailer->send('welcome', ['email' => $email], function ($message) use ($email) {
                $message->from('us@example.com', 'Laravel');
                $message->to($email);
            });
            if(count($mailer->failures())>0)
            {
                $this->failedToSend[]=$email;
            }
        }
        if (empty($this->getFailedToSend()))
            dd('All emails were sent successfully');
        else {
            dd('Emails were not sent to:<br>');
            foreach($this->getFailedToSend() as $failedEmail)
            {
                dd($failedEmail.'<br>');
            }
        }

    }

    /**
     * @return array
     */
    public function getFailedToSend()
    {
        return $this->failedToSend;
    }

}