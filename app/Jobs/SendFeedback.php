<?php

namespace StudentInfo\Jobs;

use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Mail\Mailer;
use Illuminate\Mail\Message;

class SendFeedback extends Job implements SelfHandling
{
    /**
     * @var String
     */
    protected $feedback;

    /**
     * Create a new job instance.
     *
     * @param $feedback
     */
    public function __construct($feedback)
    {
        $this->feedback = $feedback;
    }

    /**
     * Execute the job.
     *
     * @param Mailer $mailer
     */
    public function handle(Mailer $mailer)
    {
        $emails = [
            'nebojsa.urosevic@labs.devana.rs',
            'nikola.vukovic@labs.devana.rs',
            'nikola.ninkovic@labs.devana.rs',
            'milan.vucic@labs.devana.rs',
            'vladimir.prelovac@devana.rs',
            'bogdan.habic@devana.rs',
        ];
        foreach ($emails as $email) {
            $mailer->send('emails.feedback_mail_template', [
                'email'    => $email,
                'feedback' => $this->feedback,
            ], function (Message $message) use ($email) {
                $message->to($email);
                $message->subject('Registration');
            });
        }
    }
}
