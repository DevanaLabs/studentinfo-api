<?php

namespace StudentInfo\Jobs;


use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailer;
use Illuminate\Mail\Message;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use StudentInfo\Models\User;

class SendRecoverEmail extends Job implements SelfHandling, ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    /**
     * @var User
     */
    protected $user;
    /**
     * @var String
     */
    protected $email;

    /**
     * Create a new job instance.
     * @param $user
     */
    public function __construct(User $user)
    {
        $this->user  = $user;
        $this->email = $user->getEmail()->getEmail();
    }

    /**
     * Execute the job.
     * @param Mailer $mailer
     */
    public function handle(Mailer $mailer)
    {
        $email = $this->email;

        $mailer->send('email_recover_mail_template', [
            'email'   => $email,
            'token'   => $this->user->getRememberToken(),
            'faculty' => $this->user->getOrganisation()->getName(),
        ], function (Message $message) use ($email) {
            $message->to($email);
            $message->subject('?????????? ??????? ?? ??????? ????');
        });

        if (!empty($mailer->failures())) {
            Log::error("Failed to send email to: " . $email . " at: " . time());
        }
    }
}