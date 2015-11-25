<?php


namespace StudentInfo\Http\Controllers;


use Carbon\Carbon;
use Illuminate\Contracts\Auth\Guard;
use StudentInfo\ErrorCodes\UserErrorCodes;
use StudentInfo\Http\Requests\AddLectureRequest;
use StudentInfo\Http\Requests\Request;
use StudentInfo\Http\Requests\StandardRequest;
use StudentInfo\Models\Classroom;
use StudentInfo\Models\Course;
use StudentInfo\Models\Lecture;
use StudentInfo\Models\Professor;
use StudentInfo\Repositories\ClassroomRepositoryInterface;
use StudentInfo\Repositories\CourseRepositoryInterface;
use StudentInfo\Repositories\FacultyRepositoryInterface;
use StudentInfo\Repositories\LectureRepositoryInterface;
use StudentInfo\Repositories\ProfessorRepositoryInterface;

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
     * @var FacultyRepositoryInterface
     */
    protected $professorRepository;
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
     * @param ProfessorRepositoryInterface $professorRepository
     * @param CourseRepositoryInterface    $courseRepository
     * @param ClassroomRepositoryInterface $classroomRepository
     */
    public function __construct(LectureRepositoryInterface $lectureRepository, Guard $guard, ProfessorRepositoryInterface $professorRepository, CourseRepositoryInterface $courseRepository, ClassroomRepositoryInterface $classroomRepository)
    {
        $this->lectureRepository   = $lectureRepository;
        $this->guard               = $guard;
        $this->professorRepository = $professorRepository;
        $this->courseRepository    = $courseRepository;
        $this->classroomRepository = $classroomRepository;
    }


    public function addLecture(AddLectureRequest $request)
    {
        /** @var Professor $professor */
        $professor = $this->professorRepository->find($request->get('professorId'));

        /** @var Course $course */
        $course = $this->courseRepository->find($request->get('courseId'));

        /** @var Classroom $classroom */
        $classroom = $this->classroomRepository->find($request->get('classroomId'));

        if ($professor == null) {
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

        if($endsAt->lte($startsAt))
        {
            return $this->returnError(500, UserErrorCodes::INCORRECT_TIME);
        }

        $lecture = new Lecture();

        $professor->addLecture($lecture);
        $course->addLecture($lecture);
        $lecture->setProfessor($professor);
        $lecture->setCourse($course);
        $lecture->setClassroom($classroom);
        $lecture->setStartsAt($startsAt);
        $lecture->setEndsAt($endsAt);

        $this->lectureRepository->create($lecture);
        return $this->returnSuccess([
            'lecture' => $lecture,
        ]);
    }

    public function getLecture($id)
    {
        $lecture = $this->lectureRepository->find($id);

        if($lecture  === null){
            return $this->returnError(500, UserErrorCodes::LECTURE_NOT_IN_DB);
        }

        return $this->returnSuccess([
            'lecture' => $lecture
        ]);
    }

    public function getLectures($start, $count)
    {
        $lectures = $this->lectureRepository->all($start, $count);

        return $this->returnSuccess($lectures);
    }

    public function putEditLecture(Request $request, $id)
    {
        if($this->lectureRepository->find($id)  === null){
            return $this->returnError(500, UserErrorCodes::LECTURE_NOT_IN_DB);
        }

        /** @var Professor $professor */
        $professor = $this->professorRepository->find($request->get('professorId'));

        /** @var Course $course */
        $course = $this->courseRepository->find($request->get('courseId'));

        /** @var Classroom $classroom */
        $classroom = $this->classroomRepository->find($request->get('classroomId'));

        if ($professor == null) {
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

        $professor->addLecture($lecture);
        $course->addLecture($lecture);
        $lecture->setProfessor($professor);
        $lecture->setCourse($course);
        $lecture->setClassroom($classroom);
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