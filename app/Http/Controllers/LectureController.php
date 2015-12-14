<?php


namespace StudentInfo\Http\Controllers;


use Carbon\Carbon;
use Illuminate\Contracts\Auth\Guard;
use StudentInfo\ErrorCodes\UserErrorCodes;
use StudentInfo\Http\Requests\Create\CreateLectureRequest;
use StudentInfo\Http\Requests\Update\UpdateLectureRequest;
use StudentInfo\Models\Classroom;
use StudentInfo\Models\Course;
use StudentInfo\Models\Lecture;
use StudentInfo\Models\Teacher;
use StudentInfo\Repositories\ClassroomRepositoryInterface;
use StudentInfo\Repositories\CourseRepositoryInterface;
use StudentInfo\Repositories\LectureRepositoryInterface;
use StudentInfo\Repositories\TeacherRepositoryInterface;

class LectureController extends ApiController
{
    /**
     * @var LectureRepositoryInterface
     */
    protected $lectureRepository;

    /**
     * @var Guard
     */
    protected $guard;

    /**
     * @var TeacherRepositoryInterface
     */
    protected $teacherRepository;

    /**
     * @var CourseRepositoryInterface
     */
    protected $courseRepository;

    /**
     * @var ClassroomRepositoryInterface
     */
    protected $classroomRepository;

    /**
     * LectureController constructor.
     * @param LectureRepositoryInterface   $lectureRepository
     * @param Guard                        $guard
     * @param TeacherRepositoryInterface   $teacherRepository
     * @param CourseRepositoryInterface    $courseRepository
     * @param ClassroomRepositoryInterface $classroomRepository
     */
    public function __construct(LectureRepositoryInterface $lectureRepository, Guard $guard, TeacherRepositoryInterface $teacherRepository, CourseRepositoryInterface $courseRepository, ClassroomRepositoryInterface $classroomRepository)
    {
        $this->lectureRepository   = $lectureRepository;
        $this->guard               = $guard;
        $this->teacherRepository = $teacherRepository;
        $this->courseRepository    = $courseRepository;
        $this->classroomRepository = $classroomRepository;
    }

    public function createLecture(CreateLectureRequest $request)
    {
        /** @var Teacher $teacher */
        $teacher = $this->teacherRepository->find($request->get('teacherId'));

        /** @var Course $course */
        $course = $this->courseRepository->find($request->get('courseId'));

        /** @var Classroom $classroom */
        $classroom = $this->classroomRepository->find($request->get('classroomId'));

        if ($teacher == null) {
            return $this->returnError(500, UserErrorCodes::TEACHER_NOT_IN_DB);
        }
        if ($course == null) {
            return $this->returnError(500, UserErrorCodes::COURSE_NOT_IN_DB);
        }
        if ($classroom == null) {
            return $this->returnError(500, UserErrorCodes::CLASSROOM_NOT_IN_DB);
        }

        $startsAt = Carbon::createFromFormat('Y-m-d H:i', $request->get('startsAt'));
        $endsAt = Carbon::createFromFormat('Y-m-d H:i', $request->get('endsAt'));

        if($endsAt->lte($startsAt))
        {
            return $this->returnError(500, UserErrorCodes::INCORRECT_TIME);
        }

        $lecture = new Lecture();

        $lecture->setTeacher($teacher);
        $lecture->setCourse($course);
        $lecture->setClassroom($classroom);
        $lecture->setType($request->get('type'));
        $lecture->setStartsAt($startsAt);
        $lecture->setEndsAt($endsAt);

        $this->lectureRepository->create($lecture);
        return $this->returnSuccess([
            'lecture' => $lecture,
        ]);
    }

    public function retrieveLecture($id)
    {
        $lecture = $this->lectureRepository->find($id);

        if($lecture  === null){
            return $this->returnError(500, UserErrorCodes::LECTURE_NOT_IN_DB);
        }

        return $this->returnSuccess([
            'lecture' => $lecture
        ]);
    }

    public function retrieveLectures($start = 0, $count = 20)
    {
        $lectures = $this->lectureRepository->all($start, $count);

        return $this->returnSuccess($lectures);
    }

    public function updateLecture(UpdateLectureRequest $request, $id)
    {
        if($this->lectureRepository->find($id)  === null){
            return $this->returnError(500, UserErrorCodes::LECTURE_NOT_IN_DB);
        }

        /** @var Teacher $teacher */
        $teacher = $this->teacherRepository->find($request->get('teacherId'));

        /** @var Course $course */
        $course = $this->courseRepository->find($request->get('courseId'));

        /** @var Classroom $classroom */
        $classroom = $this->classroomRepository->find($request->get('classroomId'));

        if ($teacher == null) {
            return $this->returnError(500, UserErrorCodes::PROFESSOR_NOT_IN_DB);
        }
        if ($course == null) {
            return $this->returnError(500, UserErrorCodes::COURSE_NOT_IN_DB);
        }
        if ($classroom == null) {
            return $this->returnError(500, UserErrorCodes::CLASSROOM_NOT_IN_DB);
        }

        $startsAt = Carbon::createFromFormat('Y-m-d H:i', $request->get('startsAt'));
        $endsAt = Carbon::createFromFormat('Y-m-d H:i', $request->get('endsAt'));

        if($endsAt->lt($startsAt))
        {
            return $this->returnError(500, UserErrorCodes::INCORRECT_TIME);
        }
        /** @var Lecture $lecture */
        $lecture = $this->lectureRepository->find($id);

        $lecture->setTeacher($teacher);
        $lecture->setCourse($course);
        $lecture->setClassroom($classroom);
        $lecture->setType($request->get('type'));
        $lecture->setStartsAt($startsAt);
        $lecture->setEndsAt($endsAt);

        $this->lectureRepository->update($lecture);

        return $this->returnSuccess([
            'lecture' => $lecture
        ]);
    }

    public function deleteLecture($id)
    {
        $lecture = $this->lectureRepository->find($id);
        if ($lecture === null) {
            return $this->returnError(500, UserErrorCodes::LECTURE_NOT_IN_DB);
        }
        $this->lectureRepository->destroy($lecture);

        return $this->returnSuccess();
    }
}