<?php

namespace StudentInfo\Http\Controllers;


use Carbon\Carbon;
use Illuminate\Contracts\Auth\Guard;
use StudentInfo\ErrorCodes\UserErrorCodes;
use StudentInfo\Http\Requests\Create\CreateLectureNotificationRequest;
use StudentInfo\Http\Requests\Update\UpdateLectureNotificationRequest;
use StudentInfo\Models\Lecture;
use StudentInfo\Models\LectureNotification;
use StudentInfo\Repositories\LectureRepositoryInterface;
use StudentInfo\Repositories\NotificationRepositoryInterface;

class LectureNotificationController extends ApiController
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
     * @var LectureRepositoryInterface
     */
    protected $lectureRepository;

    /**
     * NotificationController constructor.
     * @param NotificationRepositoryInterface $notificationRepository
     * @param Guard                           $guard
     * @param LectureRepositoryInterface      $lectureRepository
     */
    public function __construct(NotificationRepositoryInterface $notificationRepository, Guard $guard, LectureRepositoryInterface $lectureRepository)
    {
        $this->notificationRepository = $notificationRepository;
        $this->guard                  = $guard;
        $this->lectureRepository      = $lectureRepository;
    }


    public function createNotification(CreateLectureNotificationRequest $request)
    {
        $description = $request->get('description');

        $expiresAt = Carbon::createFromFormat('Y-m-d H:i', $request->get('expiresAt'));

        $lectureId = $request->get('lectureId');

        if ($expiresAt->lt(Carbon::now())) {
            return $this->returnError(500, UserErrorCodes::INCORRECT_TIME);
        }

        $lecture = $this->lectureRepository->find($lectureId);
        if ($lecture === null) {
            return $this->returnError(500, UserErrorCodes::LECTURE_NOT_IN_DB);
        }

        $notification = new LectureNotification();
        $notification->setDescription($description);
        $notification->setLecture($lecture);
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
            return $this->returnError(500, UserErrorCodes::NOTIFICATION_NOT_IN_DB);
        }

        return $this->returnSuccess([
            'notification' => $notification,
        ]);
    }

    public function retrieveNotifications($start = 0, $count = 20)
    {
        $notifications = $this->notificationRepository->all($start, $count);

        return $this->returnSuccess($notifications);
    }

    public function updateNotification(UpdateLectureNotificationRequest $request, $id)
    {
        /** @var LectureNotification $notification */
        $notification = $this->notificationRepository->find($id);

        if ($notification === null) {
            return $this->returnError(500, UserErrorCodes::NOTIFICATION_NOT_IN_DB);
        }

        $expiresAt = Carbon::createFromFormat('Y-m-d H:i', $request->get('expiresAt'));

        $lectureId = $request->get('lectureId');

        $lecture = $this->lectureRepository->find($lectureId);
        if ($expiresAt->lt(Carbon::now())) {
            return $this->returnError(500, UserErrorCodes::INCORRECT_TIME);
        }
        if ($lecture === null) {
            return $this->returnError(500, UserErrorCodes::LECTURE_NOT_IN_DB);
        }

        $notification->setDescription($request->get('description'));
        $notification->setExpiresAt($expiresAt);
        $notification->setLecture($lecture);
        $this->notificationRepository->update($notification);

        return $this->returnSuccess([
            'notification' => $notification,
        ]);
    }

    public function deleteNotification($id)
    {
        $notification = $this->notificationRepository->find($id);
        if ($notification === null) {
            return $this->returnError(500, UserErrorCodes::NOTIFICATION_NOT_IN_DB);
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

    public function getNotificationsForLecture($lectureId)
    {
        /** @var Lecture $lecture */
        $lecture = $this->lectureRepository->find($lectureId);

        if ($lecture === null) {
            return $this->returnError(500, UserErrorCodes::LECTURE_NOT_IN_DB);
        }

        return $this->returnSuccess([
            'notifications' => $lecture->getNotification(),
        ]);
    }
}