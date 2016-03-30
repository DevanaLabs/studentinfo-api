<?php

namespace StudentInfo\Http\Controllers;

use Carbon\Carbon;
use DateTime;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\SerializerBuilder;
use LucaDegasperi\OAuth2Server\Authorizer;
use StudentInfo\ErrorCodes\LectureErrorCodes;
use StudentInfo\ErrorCodes\NotificationErrorCodes;
use StudentInfo\ErrorCodes\UserErrorCodes;
use StudentInfo\Http\Requests\Create\CreateLectureNotificationRequest;
use StudentInfo\Http\Requests\Update\UpdateLectureNotificationRequest;
use StudentInfo\Jobs\SendNotification;
use StudentInfo\Models\Lecture;
use StudentInfo\Models\LectureNotification;
use StudentInfo\Repositories\DeviceTokenRepositoryInterface;
use StudentInfo\Repositories\FacultyRepositoryInterface;
use StudentInfo\Repositories\LectureNotificationRepositoryInterface;
use StudentInfo\Repositories\LectureRepositoryInterface;
use StudentInfo\Repositories\UserRepositoryInterface;

class LectureNotificationController extends ApiController
{
    /**
     * @var UserRepositoryInterface
     */
    protected $userRepository;

    /**
     * @var LectureNotificationRepositoryInterface
     */
    protected $lectureNotificationRepository;

    /**
     * @var LectureRepositoryInterface
     */
    protected $lectureRepository;

    /**
     * @var FacultyRepositoryInterface
     */
    protected $facultyRepository;

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
     * @param UserRepositoryInterface                              $userRepository
     * @param LectureNotificationRepositoryInterface $lectureNotificationRepository
     * @param LectureRepositoryInterface             $lectureRepository
     * @param FacultyRepositoryInterface             $facultyRepository
     * @param DeviceTokenRepositoryInterface                       $deviceTokenRepositoryInterface
     * @param Authorizer                                           $authorizer
     */
    public function __construct(UserRepositoryInterface $userRepository, LectureNotificationRepositoryInterface $lectureNotificationRepository, LectureRepositoryInterface $lectureRepository,
                                FacultyRepositoryInterface $facultyRepository, DeviceTokenRepositoryInterface $deviceTokenRepositoryInterface, Authorizer $authorizer)
    {
        $this->userRepository = $userRepository;
        $this->lectureNotificationRepository = $lectureNotificationRepository;
        $this->lectureRepository             = $lectureRepository;
        $this->facultyRepository             = $facultyRepository;
        $this->deviceTokenRepository = $deviceTokenRepositoryInterface;
        $this->authorizer     = $authorizer;
    }


    public function createNotification(CreateLectureNotificationRequest $request, $faculty)
    {
        $description = $request->get('description');

        $expiresAt = DateTime::createFromFormat('Y-m-d H:i', $request->get('expiresAt'));

        $lectureId = $request->get('lectureId');

        if ($expiresAt < Carbon::now()) {
            return $this->returnError(500, UserErrorCodes::INCORRECT_TIME);
        }

        $lecture = $this->lectureRepository->find($lectureId);
        if ($lecture === null) {
            return $this->returnError(500, LectureErrorCodes::LECTURE_NOT_IN_DB);
        }

        $notification = new LectureNotification();
        $notification->setDescription($description);
        $notification->setLecture($lecture);
        $notification->setExpiresAt($expiresAt);
        $notification->setOrganisation($this->userRepository->find($this->authorizer->getResourceOwnerId())->getOrganisation());

        $this->lectureNotificationRepository->create($notification);

        $serializer = SerializerBuilder::create()
            ->addMetadataDir(base_path() . '/serializations/')
            ->build();

        $display = $request->get('display', 'notification');

        $jsonData = $serializer->serialize($notification, 'json', SerializationContext::create()->setGroups(array($display)));

        $this->dispatch(new SendNotification($this->deviceTokenRepository->all($faculty), $jsonData));
        // deviceTokens repository limit

        return $this->returnSuccess([
            'notification' => $notification,
        ]);
    }

    public function retrieveNotification($faculty, $id)
    {
        $notification = $this->lectureNotificationRepository->find($id);

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
        $notifications = $this->lectureNotificationRepository->all($faculty, $start, $count);

        return $this->returnSuccess($notifications);
    }

    public function updateNotification(UpdateLectureNotificationRequest $request, $faculty, $id)
    {
        /** @var LectureNotification $notification */
        $notification = $this->lectureNotificationRepository->find($id);

        if ($notification === null) {
            return $this->returnError(500, NotificationErrorCodes::NOTIFICATION_NOT_IN_DB);
        }

        $expiresAt = DateTime::createFromFormat('Y-m-d H:i', $request->get('expiresAt'));

        if ($expiresAt < Carbon::now()) {
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

        $this->dispatch(new SendNotification($this->deviceTokenRepository->all($faculty), $jsonData));
        // deviceTokens repository limit

        $this->lectureNotificationRepository->update($notification);

        return $this->returnSuccess([
            'notification' => $notification,
        ]);
    }

    public function deleteNotification($faculty, $id)
    {
        $notification = $this->lectureNotificationRepository->find($id);
        if ($notification === null) {
            return $this->returnError(500, NotificationErrorCodes::NOTIFICATION_NOT_IN_DB);
        }
        $this->lectureNotificationRepository->destroy($notification);

        return $this->returnSuccess();
    }

    public function getNotificationsInInterval($faculty, $start, $end)
    {
        $startParsed = str_replace('_', ' ', $start);
        $startCarbon = DateTime::createFromFormat('Y-m-d H:i', $startParsed);
        $endParsed   = str_replace('_', ' ', $end);
        $endCarbon = DateTime::createFromFormat('Y-m-d H:i', $endParsed);

        if ($startCarbon < $endCarbon) {
            return $this->returnError(500, UserErrorCodes::INCORRECT_TIME);
        }

        return $this->returnSuccess($this->lectureNotificationRepository->getForInterval($faculty, $startCarbon, $endCarbon));
    }

    public function retrieveNotificationsForLecture($faculty, $lectureId)
    {
        /** @var Lecture $lecture */
        $lecture = $this->lectureRepository->find($lectureId);

        if ($lecture === null) {
            return $this->returnError(500, LectureErrorCodes::LECTURE_NOT_IN_DB);
        }

        if ($this->userRepository->find($this->authorizer->getResourceOwnerId())->getOrganisation()->getSlug() != $faculty) {
            return $this->returnError(500, NotificationErrorCodes::NOTIFICATION_DOES_NOT_BELONG_TO_THIS_FACULTY);
        }

        return $this->returnSuccess($lecture->getNotification()->getValues());
    }
}