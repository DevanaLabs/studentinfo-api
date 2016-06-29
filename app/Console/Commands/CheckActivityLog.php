<?php namespace StudentInfo\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Contracts\Mail\MailQueue;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Mail\Mailer;
use Illuminate\Support\Facades\Mail;
use StudentInfo\Repositories\ActivityLogRepositoryInterface;
use Illuminate\Mail\Message;

class CheckActivityLog extends Command
{
    private static $INACTIVE_DURATION = 30;

    /**
     * @var ActivityLogRepositoryInterface
     */
    private $activityLogRepository;

    /**
     * @var Mailer
     */
    private $mailer;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'activity';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check the activity of StudentInfo smart boards, and notify someone if they are down';

    /**
     * CheckActivityLog constructor.
     *
     * @param ActivityLogRepositoryInterface $activityLogRepository
     * @param Mailer                      $mail
     */
    public function __construct(ActivityLogRepositoryInterface $activityLogRepository, Mailer $mail)
    {
        parent::__construct();
        $this->activityLogRepository = $activityLogRepository;
        $this->mailer                = $mail;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $emails = ['vucic94@yahoo.com', 'malisa.pusonja@labs.devana.rs'];

        /** @var Collection[] $inactiveBoards */
        $inactiveBoards = $this->getActivityLogRepository()->getInactiveFor(1);
        foreach ($inactiveBoards as $inactiveBoard) {
            $this->getMailer()->send('emails.warning_inactive_board_mail_template', [
                'board' => $inactiveBoard->getSender(),
            ], function (Message $message) use ($emails) {
                $message->from('noreply@studentinfo.rs', 'StudentInfo');
                $message->to($emails);
                $message->subject('Upozorenje od mogucoj neaktivnosti StudentInfo table');
            });
        }
    }

    public function getActivityLogRepository()
    {
        return $this->activityLogRepository;
    }

    /**
     * @return Mailer
     */
    public function getMailer()
    {
        return $this->mailer;
    }


}