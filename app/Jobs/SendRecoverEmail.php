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
     * @var String
     */
    protected $facultyName;

    /**
     * Create a new job instance.
     * @param User $user
     * @param      $email
     * @param      $facultyName
     */
    public function __construct(User $user, $email, $facultyName)
    {
        $this->user  = $user;
        $this->email = $email;
        $this->facultyName = $facultyName;
    }

    /**
     * Execute the job.
     * @param Mailer $mailer
     */
    public function handle(Mailer $mailer)
    {
        $email = $this->email;

        $mailer->send('emails.recover_mail_template', [
            'email'   => $email,
            'token'   => $this->user->getRememberToken(),
            'faculty' => $this->facultyName,
        ], function (Message $message) use ($email) {
            $message->to($email);
            $message->subject('Ресетовање лозинке за Студент инфо');
        });

        if (!empty($mailer->failures())) {
            Log::error("Failed to send email to: " . $email . " at: " . time());
        }
    }
}