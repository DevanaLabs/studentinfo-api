<?php


namespace StudentInfo\Http\Controllers;

use Carbon\Carbon;
use StudentInfo\ErrorCodes\NotificationErrorCodes;
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
     * @var EventRepositoryInterface
     */
    protected $eventRepository;

    /**
     * NotificationController constructor.
     * @param NotificationRepositoryInterface $notificationRepository
     * @param EventRepositoryInterface        $eventRepository
     */
    public function __construct(NotificationRepositoryInterface $notificationRepository, EventRepositoryInterface $eventRepository)
    {
        $this->notificationRepository = $notificationRepository;
        $this->eventRepository        = $eventRepository;
    }

    public function retrieveNotification($faculty, $id)
    {
        $notification = $this->notificationRepository->find($id);

        if($notification  === null){
            return $this->returnError(500, NotificationErrorCodes::NOTIFICATION_NOT_IN_DB);
        }

        if ($notification->getOrganisation()->getSlug() != $faculty) {
            return $this->returnError(500, NotificationErrorCodes::NOTIFICATION_DOES_NOT_BELONG_TO_THIS_FACULTY);
        }

        return $this->returnSuccess([
            'notification' => $notification
        ]);
    }

    public function retrieveNotifications($faculty, $start = 0, $count = 2000)
    {
        $notifications = $this->notificationRepository->all($faculty, $start, $count);

        return $this->returnSuccess($notifications);
    }

    public function deleteNotification($faculty, $id)
    {
        $notification = $this->notificationRepository->find($id);

        if ($notification=== null) {
            return $this->returnError(500, NotificationErrorCodes::NOTIFICATION_NOT_IN_DB);
        }
        $this->notificationRepository->destroy($notification);

        return $this->returnSuccess();
    }

    public function getNotificationsInInterval($faculty, $start, $end)
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