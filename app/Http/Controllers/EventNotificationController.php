<?php

namespace StudentInfo\Http\Controllers;

use Carbon\Carbon;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\SerializerBuilder;
use LucaDegasperi\OAuth2Server\Authorizer;
use StudentInfo\ErrorCodes\EventErrorCodes;
use StudentInfo\ErrorCodes\NotificationErrorCodes;
use StudentInfo\ErrorCodes\UserErrorCodes;
use StudentInfo\Http\Requests\Create\CreateEventNotificationRequest;
use StudentInfo\Http\Requests\Update\UpdateEventNotificationRequest;
use StudentInfo\Jobs\SendNotification;
use StudentInfo\Models\Event;
use StudentInfo\Models\EventNotification;
use StudentInfo\Repositories\DeviceTokenRepositoryInterface;
use StudentInfo\Repositories\EventNotificationRepositoryInterface;
use StudentInfo\Repositories\EventRepositoryInterface;
use StudentInfo\Repositories\UserRepositoryInterface;

class EventNotificationController extends ApiController
{
    /**
     * @var UserRepositoryInterface
     */
    protected $userRepository;

    /**
     * @var EventNotificationRepositoryInterface
     */
    protected $eventNotificationRepository;

    /**
     * @var EventRepositoryInterface
     */
    protected $eventRepository;

    /**
     * @var DeviceTokenRepositoryInterface
     */
    protected $deviceTokenRepository;

    /**
     * @var Authorizer
     */
    protected $authorizer;

    /**
     * NotificationController constructor.
     * @param UserRepositoryInterface              $userRepository
     * @param EventNotificationRepositoryInterface $eventNotificationRepository
     * @param DeviceTokenRepositoryInterface       $deviceTokenRepositoryInterface
     * @param EventRepositoryInterface             $eventRepository
     * @param Authorizer                           $authorizer
     */
    public function __construct(UserRepositoryInterface $userRepository, EventNotificationRepositoryInterface $eventNotificationRepository,
                                DeviceTokenRepositoryInterface $deviceTokenRepositoryInterface, EventRepositoryInterface $eventRepository, Authorizer $authorizer)
    {
        $this->userRepository = $userRepository;
        $this->eventNotificationRepository = $eventNotificationRepository;
        $this->eventRepository             = $eventRepository;
        $this->deviceTokenRepository = $deviceTokenRepositoryInterface;
        $this->authorizer     = $authorizer;
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
        $notification->setOrganisation($this->userRepository->find($this->authorizer->getResourceOwnerId())->getOrganisation());

        $serializer = SerializerBuilder::create()
            ->addMetadataDir(base_path() . '/serializations/')
            ->build();

        $display = $request->get('display', 'all');

        $jsonData = $serializer->serialize($notification, 'json', SerializationContext::create()->enableMaxDepthChecks()->setGroups(array($display)));

        $this->dispatch(new SendNotification($this->deviceTokenRepository->all($faculty), $jsonData));
        // deviceTokens repository limit

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
        $notification->setOrganisation($this->userRepository->find($this->authorizer->getResourceOwnerId())->getOrganisation());

        $serializer = SerializerBuilder::create()
            ->addMetadataDir(base_path() . '/serializations/')
            ->build();

        $display = $request->get('display', 'all');

        $jsonData = $serializer->serialize($notification, 'json', SerializationContext::create()->enableMaxDepthChecks()->setGroups(array($display)));
        $this->lectureNotificationRepository->create($notification);

        $this->dispatch(new SendNotification($this->deviceTokenRepository->all($faculty), $jsonData));
        // deviceTokens repository limit

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

    public function getNotificationsInInterval($faculty, $start, $end)
    {
        $startParsed = str_replace('_', ' ', $start);
        $startCarbon = Carbon::createFromFormat('Y-m-d H:i', $startParsed);
        $endParsed   = str_replace('_', ' ', $end);
        $endCarbon   = Carbon::createFromFormat('Y-m-d H:i', $endParsed);

        if ($startCarbon->lte($endCarbon)) {
            return $this->returnError(500, UserErrorCodes::INCORRECT_TIME);
        }

        return $this->returnSuccess($this->eventNotificationRepository->getForInterval($faculty, $startCarbon, $endCarbon));
    }

    public function retrieveNotificationsForEvent($faculty, $eventId)
    {
        /** @var Event $event */
        $event = $this->eventRepository->find($eventId);

        if ($event === null) {
            return $this->returnError(500, EventErrorCodes::EVENT_NOT_IN_DB);
        }

        if ($this->userRepository->find($this->authorizer->getResourceOwnerId())->getOrganisation()->getSlug() != $faculty) {
            return $this->returnError(500, NotificationErrorCodes::NOTIFICATION_DOES_NOT_BELONG_TO_THIS_FACULTY);
        }

        return $this->returnSuccess($event->getNotifications()->getValues());
    }
}