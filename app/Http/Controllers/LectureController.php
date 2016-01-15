<?php


namespace StudentInfo\Http\Controllers;


use Illuminate\Contracts\Auth\Guard;
use StudentInfo\ErrorCodes\ClassroomErrorCodes;
use StudentInfo\ErrorCodes\CourseErrorCodes;
use StudentInfo\ErrorCodes\LectureErrorCodes;
use StudentInfo\ErrorCodes\TeacherErrorCodes;
use StudentInfo\ErrorCodes\UserErrorCodes;
use StudentInfo\Http\Requests\AddFromCSVRequest;
use StudentInfo\Http\Requests\Create\CreateLectureRequest;
use StudentInfo\Http\Requests\Update\UpdateLectureRequest;
use StudentInfo\Models\Classroom;
use StudentInfo\Models\Course;
use StudentInfo\Models\Lecture;
use StudentInfo\Models\Teacher;
use StudentInfo\Repositories\ClassroomRepositoryInterface;
use StudentInfo\Repositories\CourseRepositoryInterface;
use StudentInfo\Repositories\GroupRepositoryInterface;
use StudentInfo\Repositories\LectureRepositoryInterface;
use StudentInfo\Repositories\TeacherRepositoryInterface;
use StudentInfo\ValueObjects\Time;

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
     * @var GroupRepositoryInterface
     */
    protected $groupRepository;

    /**
     * LectureController constructor.
     * @param LectureRepositoryInterface   $lectureRepository
     * @param Guard                        $guard
     * @param TeacherRepositoryInterface   $teacherRepository
     * @param CourseRepositoryInterface    $courseRepository
     * @param ClassroomRepositoryInterface $classroomRepository
     * @param GroupRepositoryInterface     $groupRepository
     */
    public function __construct(LectureRepositoryInterface $lectureRepository, Guard $guard, TeacherRepositoryInterface $teacherRepository, CourseRepositoryInterface $courseRepository, ClassroomRepositoryInterface $classroomRepository, GroupRepositoryInterface $groupRepository)
    {
        $this->lectureRepository   = $lectureRepository;
        $this->guard               = $guard;
        $this->teacherRepository = $teacherRepository;
        $this->courseRepository    = $courseRepository;
        $this->classroomRepository = $classroomRepository;
        $this->groupRepository = $groupRepository;
    }

    public function createLecture(CreateLectureRequest $request, $faculty)
    {
        /** @var Teacher $teacher */
        $teacher = $this->teacherRepository->find($request->get('teacherId'));

        /** @var Course $course */
        $course = $this->courseRepository->find($request->get('courseId'));

        /** @var Classroom $classroom */
        $classroom = $this->classroomRepository->find($request->get('classroomId'));

        if ($teacher == null) {
            return $this->returnError(500, TeacherErrorCodes::TEACHER_NOT_IN_DB);
        }
        if ($course == null) {
            return $this->returnError(500, CourseErrorCodes::COURSE_NOT_IN_DB);
        }
        if ($classroom == null) {
            return $this->returnError(500, ClassroomErrorCodes::CLASSROOM_NOT_IN_DB);
        }
        $startsAt = $request->get('startsAt');
        $endsAt   = $request->get('endsAt');

        if ($endsAt < $startsAt) {
            return $this->returnError(500, UserErrorCodes::INCORRECT_TIME);
        }
        $groupsEntry = $request->get('groups');
        $groups      = [];
        for ($i = 0; $i < count($groupsEntry); $i++) {
            $group = $this->groupRepository->findByName($groupsEntry[$i]);
            if ($group === null) {
                continue;
            }
            $groups[] = $group;
        }
        $time = new Time();
        $time->setStartsAt($startsAt);
        $time->setEndsAt($endsAt);

        $lecture = new Lecture();

        $lecture->setTeacher($teacher);
        $lecture->setCourse($course);
        $lecture->setClassroom($classroom);
        $lecture->setType($request->get('type'));
        $lecture->setTime($time);
        $lecture->setGroups($groups);

        $this->lectureRepository->create($lecture);
        return $this->returnSuccess([
            'lecture' => $lecture,
        ]);
    }

    public function retrieveLecture($faculty, $id)
    {
        $lecture = $this->lectureRepository->find($id);

        if ($lecture === null) {
            return $this->returnError(500, LectureErrorCodes::LECTURE_NOT_IN_DB);
        }

        if ($lecture->getCourse()->getOrganisation()->getSlug() != $faculty) {
            return $this->returnError(500, LectureErrorCodes::LECTURE_DOES_NOT_BELONG_TO_THIS_FACULTY);
        }

        return $this->returnSuccess([
            'lecture' => $lecture,
        ]);
    }

    public function retrieveLectures($faculty, $start = 0, $count = 2000)
    {
        $lectures = $this->lectureRepository->all($faculty, $start, $count);

        return $this->returnSuccess($lectures, [
            'display' => 'limited',
        ]);
    }

    public function updateLecture(UpdateLectureRequest $request, $faculty, $id)
    {
        if ($this->lectureRepository->find($id) === null) {
            return $this->returnError(500, LectureErrorCodes::LECTURE_NOT_IN_DB);
        }

        /** @var Teacher $teacher */
        $teacher = $this->teacherRepository->find($request->get('teacherId'));

        /** @var Course $course */
        $course = $this->courseRepository->find($request->get('courseId'));

        /** @var Classroom $classroom */
        $classroom = $this->classroomRepository->find($request->get('classroomId'));

        if ($teacher == null) {
            return $this->returnError(500, TeacherErrorCodes::TEACHER_NOT_IN_DB);
        }
        if ($course == null) {
            return $this->returnError(500, CourseErrorCodes::COURSE_NOT_IN_DB);
        }
        if ($classroom == null) {
            return $this->returnError(500, ClassroomErrorCodes::CLASSROOM_NOT_IN_DB);
        }

        $startsAt = $request->get('startsAt');
        $endsAt   = $request->get('endsAt');

        if ($endsAt < $startsAt) {
            return $this->returnError(500, UserErrorCodes::INCORRECT_TIME);
        }
        $groupsEntry = $request->get('groups');
        $groups      = [];
        for ($i = 0; $i < count($groupsEntry); $i++) {
            $group = $this->groupRepository->findByName($groupsEntry[$i]);
            if ($group === null) {
                continue;
            }
            $groups[] = $group;
        }
        $time = new Time();
        $time->setStartsAt($startsAt);
        $time->setStartsAt($endsAt);
        /** @var Lecture $lecture */
        $lecture = $this->lectureRepository->find($id);

        $lecture->setTeacher($teacher);
        $lecture->setCourse($course);
        $lecture->setClassroom($classroom);
        $lecture->setType($request->get('type'));
        $lecture->setTime($time);
        $lecture->setGroups($groups);

        $this->lectureRepository->update($lecture);

        return $this->returnSuccess([
            'lecture' => $lecture,
        ]);
    }

    public function deleteLecture($faculty, $id)
    {
        $lecture = $this->lectureRepository->find($id);
        if ($lecture === null) {
            return $this->returnError(500, LectureErrorCodes::LECTURE_NOT_IN_DB);
        }
        $this->lectureRepository->destroy($lecture);

        return $this->returnSuccess();
    }

    public function AddLecturesFromCSV(AddFromCSVRequest $request, $faculty)
    {
        $handle = $request->file('import');

        $file_path = $handle->getPathname();
        $resource  = fopen($file_path, "r");
        while (($data = fgetcsv($resource, 1000, ",")) !== FALSE) {
            $courseName    = $data[0];
            $type          = $data[1];
            $teacherName   = $data[2];
            $groups        = $data[3];
            $day           = $data[4];
            $time          = $data[5];
            $classroomName = $data[6];

            $course = $this->courseRepository->findByName($courseName);
            if ($course === null) {
                return $this->returnError(500, CourseErrorCodes::COURSE_NOT_IN_DB, $courseName);
            }
            $teacherNames = explode(" ", $teacherName);
            $teacher      = $this->teacherRepository->findByName($teacherNames[1], $teacherNames[0]);
            if ($teacher === null) {
                return $this->returnError(500, TeacherErrorCodes::TEACHER_NOT_IN_DB, $teacherNames);
            }
            $classroom = $this->classroomRepository->findByName($classroomName);
            if ($classroom === null) {
                return $this->returnError(500, ClassroomErrorCodes::CLASSROOM_NOT_IN_DB, $classroomName);
            }

            $timeSplit = explode("-", $time);
            $hourStart = explode(":", $timeSplit[0]);

            $groupsForLecture = [];
            $groupsSplit      = explode(" ", $groups);
            foreach ($groupsSplit as $g) {
                $gr                 = $this->groupRepository->findByName($g);
                $groupsForLecture[] = $gr;
            }


            switch ($day) {
                case "ПОН":
                    $startsAt = 0;
                    $endsAt   = 0;
                    break;
                case "УТО":
                    $startsAt = 24 * 60 * 60;
                    $endsAt   = 24 * 60 * 60;
                    break;
                case "СРЕ":
                    $startsAt = 2 * 24 * 60 * 60;
                    $endsAt   = 2 * 24 * 60 * 60;
                    break;
                case "ЧЕТ":
                    $startsAt = 3 * 24 * 60 * 60;
                    $endsAt   = 3 * 24 * 60 * 60;
                    break;
                case "ПЕТ":
                    $startsAt = 4 * 24 * 60 * 60;
                    $endsAt   = 4 * 24 * 60 * 60;
                    break;
                case "СУБ":
                    $startsAt = 5 * 24 * 60 * 60;
                    $endsAt   = 5 * 24 * 60 * 60;
                    break;
                default:
                    $startsAt = 6 * 24 * 60 * 60;
                    $endsAt   = 6 * 24 * 60 * 60;
                    break;
            }
            $time = new Time();
            $time->setStartsAt($startsAt + $hourStart[0] * 60 * 60 + $hourStart[1] * 60);
            $time->setEndsAt($endsAt + $timeSplit[1] * 60 * 60);

            if ($endsAt < $startsAt) {
                continue;
            }

            $lecture = new Lecture();
            $lecture->setType($type);
            $lecture->setCourse($course);
            $lecture->setClassroom($classroom);
            $lecture->setTime($time);
            $lecture->setTeacher($teacher);
            $lecture->setGroups($groupsForLecture);

            $this->lectureRepository->persist($lecture);
        }
        $this->lectureRepository->flush();

        return $this->returnSuccess();
    }
}