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
use StudentInfo\Repositories\EventNotificationRepositoryInterface;
use StudentInfo\Repositories\EventRepositoryInterface;

class EventNotificationController extends ApiController
{
    /**
     * @var EventNotificationRepositoryInterface
     */
    protected $eventNotificationRepository;

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
     * @param EventNotificationRepositoryInterface $eventNotificationRepository
     * @param Guard                                $guard
     * @param EventRepositoryInterface             $eventRepository
     */
    public function __construct(EventNotificationRepositoryInterface $eventNotificationRepository, Guard $guard, EventRepositoryInterface $eventRepository)
    {
        $this->eventNotificationRepository = $eventNotificationRepository;
        $this->guard                       = $guard;
        $this->eventRepository             = $eventRepository;
    }


    public function createNotification(CreateEventNotificationRequest $request, $faculty)
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
        $notification->setOrganisation($this->guard->user()->getOrganisation());

        $this->eventNotificationRepository->create($notification);

        return $this->returnSuccess([
            'successful' => $notification,
        ]);
    }

    public function retrieveNotification($faculty, $id)
    {
        $notification = $this->eventNotificationRepository->find($id);

        if ($notification === null) {
            return $this->returnError(500, NotificationErrorCodes::NOTIFICATION_NOT_IN_DB);
        }

        if ($notification->getOrganisation()->getSlug() != $faculty) {
            return $this->returnError(500, NotificationErrorCodes::NOTIFICATION_DOES_NOT_BELONG_TO_THIS_FACULTY);
        }

        return $this->returnSuccess([
            'notification' => $notification,
        ]);
    }

    public function retrieveNotifications($faculty, $start = 0, $count = 2000)
    {
        $notifications = $this->eventNotificationRepository->all($faculty, $start, $count);

        return $this->returnSuccess($notifications);
    }

    public function updateNotification(UpdateEventNotificationRequest $request, $faculty, $id)
    {
        /** @var EventNotification $notification */
        $notification = $this->eventNotificationRepository->find($id);

        if ($notification === null) {
            return $this->returnError(500, NotificationErrorCodes::NOTIFICATION_NOT_IN_DB);
        }

        $expiresAt = Carbon::createFromFormat('Y-m-d H:i', $request->get('expiresAt'));

        if ($expiresAt->lt(Carbon::now())) {
            return $this->returnError(500, UserErrorCodes::INCORRECT_TIME);
        }

        $notification->setDescription($request->get('description'));
        $notification->setExpiresAt($expiresAt);
        $this->eventNotificationRepository->update($notification);

        return $this->returnSuccess([
            'notification' => $notification,
        ]);
    }

    public function deleteNotification($faculty, $id)
    {
        $notification = $this->eventNotificationRepository->find($id);
        if ($notification === null) {
            return $this->returnError(500, NotificationErrorCodes::NOTIFICATION_NOT_IN_DB);
        }
        $this->eventNotificationRepository->destroy($notification);

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

        return $this->returnSuccess($this->eventNotificationRepository->getForInterval($startCarbon, $endCarbon));
    }

    public function retrieveNotificationsForEvent($faculty, $eventId)
    {
        /** @var Event $event */
        $event = $this->eventRepository->find($eventId);

        if ($event === null) {
            return $this->returnError(500, EventErrorCodes::EVENT_NOT_IN_DB);
        }

        if ($this->guard->user()->getOrganisation()->getSlug() != $faculty) {
            return $this->returnError(500, NotificationErrorCodes::NOTIFICATION_DOES_NOT_BELONG_TO_THIS_FACULTY);
        }

        return $this->returnSuccess([
            'notifications' => $event->getNotifications(),
        ]);
    }
}