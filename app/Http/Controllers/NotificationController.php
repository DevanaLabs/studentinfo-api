<?php


namespace StudentInfo\Http\Controllers;


use Carbon\Carbon;
use Illuminate\Contracts\Auth\Guard;
use StudentInfo\ErrorCodes\UserErrorCodes;
use StudentInfo\Repositories\EventRepositoryInterface;
use StudentInfo\Repositories\NotificationRepositoryInterface;

class NotificationController extends ApiController
{
    /**
     * @var NotificationRepositoryInterface
     */
    protected $notificationRepository;

    /**
     * @var Guard
     */
    protected $guard;
    /**
     * @var EventRepositoryInterface
     */
    protected $eventRepository;

    /**
     * NotificationController constructor.
     * @param NotificationRepositoryInterface $notificationRepository
     * @param Guard                           $guard
     * @param EventRepositoryInterface        $eventRepository
     */
    public function __construct(NotificationRepositoryInterface $notificationRepository, Guard $guard, EventRepositoryInterface $eventRepository)
    {
        $this->notificationRepository = $notificationRepository;
        $this->guard                  = $guard;
        $this->eventRepository        = $eventRepository;
    }

    public function getNotification($id)
    {
        $notification = $this->notificationRepository->find($id);

        if($notification  === null){
            return $this->returnError(500, UserErrorCodes::NOTIFICATION_NOT_IN_DB);
        }

        return $this->returnSuccess([
            'notification' => $notification
        ]);
    }

    public function getNotifications($start = 0, $count = 20)
    {
        $notifications = $this->notificationRepository->all($start, $count);

        return $this->returnSuccess($notifications);
    }

    public function deleteNotification($id)
    {
        $notification = $this->notificationRepository->find($id);
        if ($notification=== null) {
            return $this->returnError(500, UserErrorCodes::NOTIFICATION_NOT_IN_DB);
        }
        $this->notificationRepository->destroy($notification);

        return $this->returnSuccess();
    }

    public function getNotificationsInInterval($start, $end)
    {
        $startParsed = str_replace('_', ' ', $start);
        $startCarbon = Carbon::createFromFormat('Y-m-d H:i', $startParsed);
        $endParsed = str_replace('_', ' ', $end);
        $endCarbon = Carbon::createFromFormat('Y-m-d H:i', $endParsed);

        if ($startCarbon->lte($endCarbon))
        {
            return $this->returnError(500, UserErrorCodes::INCORRECT_TIME);
        }

        return $this->returnSuccess($this->notificationRepository->getForInterval($startCarbon,$endCarbon));
    }
}