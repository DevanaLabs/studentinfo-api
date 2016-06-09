<?php namespace StudentInfo\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Contracts\Mail\MailQueue;
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
     * @var MailQueue
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
     * @param MailQueue                      $mailQueue
     */
    public function __construct(ActivityLogRepositoryInterface $activityLogRepository, MailQueue $mailQueue)
    {
        parent::__construct();
        $this->activityLogRepository = $activityLogRepository;
        $this->mailer                = $mailQueue;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $emails = ['vucic94@yahoo.com', 'malisa.pusonja@labs.devana.rs'];
        $inactiveBoards = $this->getActivityLogRepository()->getInactiveFor(self::$INACTIVE_DURATION);
        foreach ($inactiveBoards as $inactiveBoard) {
            $this->getMailer()->queue('emails.warning_inactive_board_mail_template.blade', [
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
     * @return MailQueue
     */
    public function getMailer()
    {
        return $this->mailer;
    }


}