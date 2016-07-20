<?php namespace StudentInfo\Jobs;


use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailer;
use Illuminate\Mail\Message;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SendInactiveBoardEmail extends Job implements SelfHandling, ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    /**
     * @var
     */
    private $inactiveBoards;

    /**
     * @var
     */
    private $email;

    /**
     * SendInactiveBoardEmail constructor.
     *
     * @param $inactiveBoards
     * @param $email
     */
    public function __construct($inactiveBoards, $email)
    {
        $this->inactiveBoards = $inactiveBoards;
        $this->email          = $email;
    }

    public function handle(Mailer $mailer)
    {
        $email = $this->email;

        foreach ($this->inactiveBoards as $inactiveBoard) {
            $mailer->send('emails.warning_inactive_board_mail_template', [
                'board' => $inactiveBoard->getSender(),
            ], function (Message $message) use ($email) {
                $message->from('noreply@studentinfo.rs', 'StudentInfo');
                $message->to($email);
                $message->subject('Upozorenje od mogucoj neaktivnosti StudentInfo table');
            });
        }

        if (!empty($mailer->failures())) {
            Log::error("Failed to send email to: ".$email." at: ".time());
        }
    }

}