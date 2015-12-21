<?php

namespace StudentInfo\Http\Controllers;


use Illuminate\Contracts\Auth\Guard;
use StudentInfo\ErrorCodes\TeacherErrorCodes;
use StudentInfo\Repositories\TeacherRepositoryInterface;

class TeacherController extends ApiController
{
    /**
     * @var TeacherRepositoryInterface
     */
    protected $teacherRepository;

    /**
     * @var Guard
     */
    protected $guard;

    /**
     * StudentController constructor.
     * @param TeacherRepositoryInterface $teacherRepository
     * @param Guard                      $guard
     */
    public function __construct(TeacherRepositoryInterface $teacherRepository, Guard $guard)
    {
        $this->teacherRepository = $teacherRepository;
        $this->guard             = $guard;
    }

    public function retrieveTeacher($id)
    {
        $teacher = $this->teacherRepository->find($id);

        if ($teacher === null) {
            return $this->returnError(500, TeacherErrorCodes::TEACHER_NOT_IN_DB);
        }

        return $this->returnSuccess([
            'teacher' => $teacher,
        ]);
    }

    public function retrieveTeachers($start = 0, $count = 2000)
    {
        $teachers = $this->teacherRepository->all($start, $count);

        return $this->returnSuccess($teachers);
    }
}