<?php

namespace StudentInfo\Jobs;

use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailer;
use Illuminate\Mail\Message;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SendRecoverWrongEmail extends Job implements SelfHandling, ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    /**
     * @var String
     */
    protected $email;


    /**
     * Create a new job instance.
     * @param      $email
     */
    public function __construct($email)
    {
        $this->email = $email;
    }

    /**
     * Execute the job.
     * @param Mailer $mailer
     */
    public function handle(Mailer $mailer)
    {
        $email = $this->email;

        $mailer->send('emails.recover_wrong_mail_template', [
            'email'   => $email,
        ], function (Message $message) use ($email) {
            $message->to($email);
            $message->subject('Ресетовање лозинке за Студент инфо');
        });

        if (!empty($mailer->failures())) {
            Log::error("Failed to send email to: " . $email . " at: " . time());
        }
    }
}