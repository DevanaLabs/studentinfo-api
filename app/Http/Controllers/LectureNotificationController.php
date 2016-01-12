<?php

namespace StudentInfo\Http\Controllers;


use Carbon\Carbon;
use Illuminate\Contracts\Auth\Guard;
use StudentInfo\ErrorCodes\LectureErrorCodes;
use StudentInfo\ErrorCodes\NotificationErrorCodes;
use StudentInfo\ErrorCodes\UserErrorCodes;
use StudentInfo\Http\Requests\Create\CreateLectureNotificationRequest;
use StudentInfo\Http\Requests\Update\UpdateLectureNotificationRequest;
use StudentInfo\Models\LectureNotification;
use StudentInfo\Repositories\FacultyRepositoryInterface;
use StudentInfo\Repositories\LectureNotificationRepositoryInterface;
use StudentInfo\Repositories\LectureRepositoryInterface;

class LectureNotificationController extends ApiController
{
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
     * @var Guard
     */
    protected $guard;

    /**
     * NotificationController constructor.
     * @param LectureNotificationRepositoryInterface $lectureNotificationRepository
     * @param LectureRepositoryInterface      $lectureRepository
     * @param Guard                                  $guard
     * @param FacultyRepositoryInterface             $facultyRepository
     */
    public function __construct(LectureNotificationRepositoryInterface $lectureNotificationRepository, LectureRepositoryInterface $lectureRepository,
                                FacultyRepositoryInterface $facultyRepository, Guard $guard)
    {
        $this->lectureNotificationRepository = $lectureNotificationRepository;
        $this->lectureRepository             = $lectureRepository;
        $this->facultyRepository             = $facultyRepository;
        $this->guard                         = $guard;
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
            return $this->returnError(500, LectureErrorCodes::LECTURE_NOT_IN_DB);
        }

        $notification = new LectureNotification();
        $notification->setDescription($description);
        $notification->setLecture($lecture);
        $notification->setExpiresAt($expiresAt);
        $notification->setOrganisation($this->facultyRepository->findFacultyByName($this->guard->user()->getOrganisation()->getName()));

        $this->lectureNotificationRepository->create($notification);

        return $this->returnSuccess([
            'successful' => $notification,
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

    public function updateNotification(UpdateLectureNotificationRequest $request, $id)
    {
        /** @var LectureNotification $notification */
        $notification = $this->lectureNotificationRepository->find($id);

        if ($notification === null) {
            return $this->returnError(500, NotificationErrorCodes::NOTIFICATION_NOT_IN_DB);
        }

        $expiresAt = Carbon::createFromFormat('Y-m-d H:i', $request->get('expiresAt'));

        if ($expiresAt->lt(Carbon::now())) {
            return $this->returnError(500, UserErrorCodes::INCORRECT_TIME);
        }

        $notification->setDescription($request->get('description'));
        $notification->setExpiresAt($expiresAt);
        $this->lectureNotificationRepository->update($notification);

        return $this->returnSuccess([
            'notification' => $notification,
        ]);
    }

    public function deleteNotification($id)
    {
        $notification = $this->lectureNotificationRepository->find($id);
        if ($notification === null) {
            return $this->returnError(500, NotificationErrorCodes::NOTIFICATION_NOT_IN_DB);
        }
        $this->lectureNotificationRepository->destroy($notification);

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

        return $this->returnSuccess($this->lectureNotificationRepository->getForInterval($startCarbon, $endCarbon));
    }
}