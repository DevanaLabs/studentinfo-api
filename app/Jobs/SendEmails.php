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

class SendEmails extends Job implements SelfHandling, ShouldQueue
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
     * @param $email
     */
    public function __construct(User $user, $email)
    {
        $this->email = $email;
        $this->user  = $user;
    }

    /**
     * Execute the job.
     * @param Mailer $mailer
     */
    public function handle(Mailer $mailer)
    {
        $email = $this->email;

        $mailer->send('emails.register_mail_template', [
            'email' => $email,
            'token' => $this->user->getRegisterToken(),
        ], function (Message $message) use ($email) {
            $message->from('noreply@studentinfo.rs', 'noreply');
            $message->to($email);
            $message->subject('Registration');
        });

        if (!empty($mailer->failures())) {
            Log::error("Failed to send email to: " . $email . " at: " . time());
        }
    }
}
