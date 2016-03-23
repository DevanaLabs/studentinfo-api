<?php

namespace StudentInfo\Http\Controllers;

use LucaDegasperi\OAuth2Server\Authorizer;
use StudentInfo\ErrorCodes\TeacherErrorCodes;
use StudentInfo\Http\Requests\StandardRequest;
use StudentInfo\Models\Teacher;
use StudentInfo\Models\User;
use StudentInfo\Repositories\TeacherRepositoryInterface;
use StudentInfo\Repositories\UserRepositoryInterface;

class TeacherController extends ApiController
{
    /**
     * @var UserRepositoryInterface
     */
    protected $userRepository;
    /**
     * @var TeacherRepositoryInterface
     */
    protected $teacherRepository;

    /**
     * @var UserRepositoryInterface
     */
    protected $userRepositoryInterface;

    /**
     * @var Authorizer
     */
    protected $authorizer;

    /**
     * StudentController constructor.
     * @param UserRepositoryInterface    $userRepository
     * @param TeacherRepositoryInterface $teacherRepository
     * @param UserRepositoryInterface    $userRepositoryInterface
     * @param Authorizer                 $authorizer
     */
    public function __construct(UserRepositoryInterface $userRepository, TeacherRepositoryInterface $teacherRepository, UserRepositoryInterface $userRepositoryInterface, Authorizer $authorizer)
    {
        $this->userRepository = $userRepository;
        $this->teacherRepository = $teacherRepository;
        $this->userRepositoryInterface = $userRepositoryInterface;
        $this->authorizer     = $authorizer;
    }

    public function retrieveTeacher(StandardRequest $request, $faculty, $id)
    {
        /** @var Teacher $teacher */
        $teacher = $this->teacherRepository->find($id);

        if ($teacher === null) {
            return $this->returnError(500, TeacherErrorCodes::TEACHER_NOT_IN_DB);
        }

        if ($teacher->getOrganisation()->getSlug() != $faculty) {
            return $this->returnError(500, TeacherErrorCodes::TEACHER_DOES_NOT_BELONG_TO_THIS_FACULTY);
        }

        $semester = $request->get('semester', 'current');
        $year     = $request->get('year', 'current');

        if (($semester == 'current') || ($year == 'current')) {
            $userId = $this->authorizer->getResourceOwnerId();
            /** @var User $user */
            $user = $this->userRepositoryInterface->find($userId);
            if ($semester == 'current') {
                $semester = $user->getOrganisation()->getSettings()->getSemester();
            }
            if ($year == 'current') {
                $year = $user->getOrganisation()->getSettings()->getYear();
            }
        } else {
            $semester = (int)$request->get('semester');
            $year     = (int)$request->get('year');
        }

        $lectures = [];
        foreach ($teacher->getLectures() as $lecture) {
            if (($lecture->getCourse()->getSemester() % 2 === $semester % 2) && ($lecture->getYear() === $year)) {
                $lectures[] = $lecture;
            }
        }
        $teacher->setLectures($lectures);

        return $this->returnSuccess([
            'teacher' => $teacher,
        ]);
    }

    public function retrieveTeachers(StandardRequest $request, $faculty, $start = 0, $count = 2000)
    {
        /** @var Teacher[] $teachers */
        $teachers = $this->teacherRepository->all($faculty, $start, $count);

        $semester = $request->get('semester', 'current');
        $year     = $request->get('year', 'current');

        if (($semester == 'current') || ($year == 'current')) {
            $userId = $this->authorizer->getResourceOwnerId();
            /** @var User $user */
            $user = $this->userRepositoryInterface->find($userId);
            if ($semester == 'current') {
                $semester = $user->getOrganisation()->getSettings()->getSemester();
            }
            if ($year == 'current') {
                $year = $user->getOrganisation()->getSettings()->getYear();
            }
        } else {
            $semester = (int)$request->get('semester');
            $year     = (int)$request->get('year');
        }

        foreach ($teachers as $teacher) {
            $lectures = [];
            foreach ($teacher->getLectures() as $lecture) {
                if (($lecture->getCourse()->getSemester() % 2 === $semester % 2) && ($lecture->getYear() === $year)) {
                    $lectures[] = $lecture;
                }
            }
            $teacher->setLectures($lectures);
        }

        return $this->returnSuccess($teachers);
    }
}