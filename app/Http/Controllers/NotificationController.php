<?php


namespace StudentInfo\Http\Controllers;


use Carbon\Carbon;
use Illuminate\Contracts\Auth\Guard;
use StudentInfo\ErrorCodes\UserErrorCodes;
use StudentInfo\Http\Requests\AddNotificationRequest;
use StudentInfo\Http\Requests\StandardRequest;
use StudentInfo\Models\Notification;
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


    public function addNotification(AddNotificationRequest $request)
    {
        $description = $request->get('description');

        $expiresAt = Carbon::createFromFormat('Y-m-d H:i', $request->get('expiresAt'));

        $eventId = $request->get('eventId');

        if ($expiresAt->lt(Carbon::now()))
        {
            return $this->returnError(500, UserErrorCodes::INCORRECT_TIME);
        }

        $event = $this->eventRepository->find($eventId);
        if ($event === null) {
            return $this->returnError(500, UserErrorCodes::EVENT_NOT_IN_DB);
        }

        $notification = new Notification();
        $notification->setDescription($description);
        $notification->setEvent($event);
        $notification->setExpiresAt($expiresAt);

        $this->notificationRepository->create($notification);

        return $this->returnSuccess([
            'successful'   => $notification
        ]);
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

    public function putEditNotification(StandardRequest $request, $id)
    {
        /** @var Notification $notification */
        $notification = $this->notificationRepository->find($id);

        if($notification === null){
            return $this->returnError(500, UserErrorCodes::NOTIFICATION_NOT_IN_DB);
        }

        $expiresAt = Carbon::createFromFormat('Y-m-d H:i', $request->get('expiresAt'));

        $eventId = $request->get('eventId');

        $event = $this->eventRepository->find($eventId);
        if ($expiresAt->lt(Carbon::now()))
        {
            return $this->returnError(500, UserErrorCodes::INCORRECT_TIME);
        }
        if ($event === null) {
            return $this->returnError(500, UserErrorCodes::EVENT_NOT_IN_DB);
        }

        $notification->setDescription($request->get('description'));
        $notification->setExpiresAt($expiresAt);
        $notification->setEvent($event);
        $this->notificationRepository->update($notification);

        return $this->returnSuccess([
            'notification' => $notification
        ]);
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

}