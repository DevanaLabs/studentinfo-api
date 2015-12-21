<?php

namespace StudentInfo\Http\Controllers;


use Carbon\Carbon;
use Illuminate\Contracts\Auth\Guard;
use StudentInfo\ErrorCodes\EventErrorCodes;
use StudentInfo\ErrorCodes\NotificationErrorCodes;
use StudentInfo\ErrorCodes\UserErrorCodes;
use StudentInfo\Http\Requests\Create\CreateEventNotificationRequest;
use StudentInfo\Http\Requests\Update\UpdateEventNotificationRequest;
use StudentInfo\Models\Event;
use StudentInfo\Models\EventNotification;
use StudentInfo\Repositories\EventRepositoryInterface;
use StudentInfo\Repositories\NotificationRepositoryInterface;

class EventNotificationController extends ApiController
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


    public function createNotification(CreateEventNotificationRequest $request)
    {
        $description = $request->get('description');

        $expiresAt = Carbon::createFromFormat('Y-m-d H:i', $request->get('expiresAt'));

        $eventId = $request->get('eventId');

        if ($expiresAt->lt(Carbon::now())) {
            return $this->returnError(500, UserErrorCodes::INCORRECT_TIME);
        }

        $event = $this->eventRepository->find($eventId);
        if ($event === null) {
            return $this->returnError(500, EventErrorCodes::EVENT_NOT_IN_DB);
        }

        $notification = new EventNotification();
        $notification->setDescription($description);
        $notification->setEvent($event);
        $notification->setExpiresAt($expiresAt);

        $this->notificationRepository->create($notification);

        return $this->returnSuccess([
            'successful' => $notification,
        ]);
    }

    public function retrieveNotification($id)
    {
        $notification = $this->notificationRepository->find($id);

        if ($notification === null) {
            return $this->returnError(500, NotificationErrorCodes::NOTIFICATION_NOT_IN_DB);
        }

        return $this->returnSuccess([
            'notification' => $notification,
        ]);
    }

    public function retrieveNotifications($start = 0, $count = 2000)
    {
        $notifications = $this->notificationRepository->all($start, $count);

        return $this->returnSuccess($notifications);
    }

    public function updateNotification(UpdateEventNotificationRequest $request, $id)
    {
        /** @var EventNotification $notification */
        $notification = $this->notificationRepository->find($id);

        if ($notification === null) {
            return $this->returnError(500, NotificationErrorCodes::NOTIFICATION_NOT_IN_DB);
        }

        $expiresAt = Carbon::createFromFormat('Y-m-d H:i', $request->get('expiresAt'));

        $eventId = $request->get('eventId');

        $event = $this->eventRepository->find($eventId);
        if ($expiresAt->lt(Carbon::now())) {
            return $this->returnError(500, UserErrorCodes::INCORRECT_TIME);
        }
        if ($event === null) {
            return $this->returnError(500, EventErrorCodes::EVENT_NOT_IN_DB);
        }

        $notification->setDescription($request->get('description'));
        $notification->setExpiresAt($expiresAt);
        $notification->setEvent($event);
        $this->notificationRepository->update($notification);

        return $this->returnSuccess([
            'notification' => $notification,
        ]);
    }

    public function deleteNotification($id)
    {
        $notification = $this->notificationRepository->find($id);
        if ($notification === null) {
            return $this->returnError(500, NotificationErrorCodes::NOTIFICATION_NOT_IN_DB);
        }
        $this->notificationRepository->destroy($notification);

        return $this->returnSuccess();
    }

    public function getNotificationsInInterval($start, $end)
    {
        $startParsed = str_replace('_', ' ', $start);
        $startCarbon = Carbon::createFromFormat('Y-m-d H:i', $startParsed);
        $endParsed   = str_replace('_', ' ', $end);
        $endCarbon   = Carbon::createFromFormat('Y-m-d H:i', $endParsed);

        if ($startCarbon->lte($endCarbon)) {
            return $this->returnError(500, UserErrorCodes::INCORRECT_TIME);
        }

        return $this->returnSuccess($this->notificationRepository->getForInterval($startCarbon, $endCarbon));
    }

    public function getNotificationsForEvent($eventId)
    {
        /** @var Event $event */
        $event = $this->eventRepository->find($eventId);

        if ($event === null) {
            return $this->returnError(500, EventErrorCodes::EVENT_NOT_IN_DB);
        }

        return $this->returnSuccess([
            'notifications' => $event->getNotifications(),
        ]);
    }
}