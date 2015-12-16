<?php


namespace StudentInfo\Http\Controllers;


use Carbon\Carbon;
use Illuminate\Contracts\Auth\Guard;
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
use StudentInfo\Repositories\StudentRepositoryInterface;
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

        if ($endsAt->lte($startsAt)) {
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
        $lecture = new Lecture();

        $lecture->setTeacher($teacher);
        $lecture->setCourse($course);
        $lecture->setClassroom($classroom);
        $lecture->setType($request->get('type'));
        $lecture->setStartsAt($startsAt);
        $lecture->setEndsAt($endsAt);
        $lecture->setGroups($groups);

        $this->lectureRepository->create($lecture);
        return $this->returnSuccess([
            'lecture' => $lecture,
        ]);
    }

    public function retrieveLecture($id)
    {
        $lecture = $this->lectureRepository->find($id);

        if ($lecture === null) {
            return $this->returnError(500, UserErrorCodes::LECTURE_NOT_IN_DB);
        }

        return $this->returnSuccess([
            'lecture' => $lecture,
        ]);
    }

    public function retrieveLectures($start = 0, $count = 2000)
    {
        $lectures = $this->lectureRepository->all($start, $count);

        return $this->returnSuccess($lectures);
    }

    public function updateLecture(UpdateLectureRequest $request, StudentRepositoryInterface $repository, $id)
    {
        if ($this->lectureRepository->find($id) === null) {
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

        if ($endsAt->lt($startsAt)) {
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

        /** @var Lecture $lecture */
        $lecture = $this->lectureRepository->find($id);

        $lecture->setTeacher($teacher);
        $lecture->setCourse($course);
        $lecture->setClassroom($classroom);
        $lecture->setType($request->get('type'));
        $lecture->setStartsAt($startsAt);
        $lecture->setEndsAt($endsAt);
        $lecture->setGroups($groups);
//        $student = $repository->find(68);
//        $lecture->setStudents([$student]);

        //return $this->returnSuccess([$lecture]);

        $this->lectureRepository->update($lecture);

        return $this->returnSuccess([
            'lecture' => $lecture,
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

    public function AddLecturesFromCSV(AddFromCSVRequest $request)
    {
        $addedLectures       = [];
        $failedToAddLectures = [];

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
                dd($courseName);
                continue;
            }
            $teacherNames = explode(" ", $teacherName);
            $teacher      = $this->teacherRepository->findByName($teacherNames[1], $teacherNames[0]);
            if ($teacher === null) {
                dd($teacherNames[1] . " " . $teacherNames[0]);
                continue;
            }
            $classroom = $this->classroomRepository->findByName($classroomName);
            if ($classroom === null) {
                dd($classroomName);
                continue;
            }
            $startsAt = null;
            $endsAt   = null;

            switch ($day) {
                case "ПОН":
                    $startsAt = "2016-1-25 ";
                    $endsAt   = "2016-1-25 ";
                    break;
                case "УТО":
                    $startsAt = "2016-1-26 ";
                    $endsAt   = "2016-1-26 ";
                    break;

                case "СРЕ":
                    $startsAt = "2016-1-27 ";
                    $endsAt   = "2016-1-27 ";

                    break;
                case "ЧЕТ":
                    $startsAt = "2016-1-28 ";
                    $endsAt   = "2016-1-28 ";
                    break;
                case "ПЕТ":
                    $startsAt = "2016-1-29 ";
                    $endsAt   = "2016-1-29 ";
                    break;
                case "СУБ":
                    $startsAt = "2016-1-30 ";
                    $endsAt   = "2016-1-30 ";
                    break;
                default:
                    $startsAt = "2016-1-31 ";
                    $endsAt   = "2016-1-31 ";
                    break;
            }
            $timeSplit = explode("-", $time);
            $hourStart = explode(":", $timeSplit[0]);
            $startsAt .= $hourStart[0] . ":00";
            $endsAt .= $timeSplit[1] . ":00";

            $groupsForLecture = [];
            $groupsSplit      = explode(" ", $groups);
            foreach ($groupsSplit as $g) {
                $gr                 = $this->groupRepository->findByName($g);
                $groupsForLecture[] = $gr;
            }

            $startsAtCarbon = Carbon::createFromFormat('Y-m-d H:i', $startsAt);
            $endsAtCarbon   = Carbon::createFromFormat('Y-m-d H:i', $endsAt);
            if ($endsAtCarbon->lte($startsAtCarbon)) {
                continue;
            }

            $lecture = new Lecture();
            $lecture->setType($type);
            $lecture->setCourse($course);
            $lecture->setClassroom($classroom);
            $lecture->setStartsAt($startsAtCarbon);
            $lecture->setEndsAt($endsAtCarbon);
            $lecture->setTeacher($teacher);
            $lecture->setGroups($groupsForLecture);

            $this->lectureRepository->create($lecture);
            $addedLectures[] = $lecture->getId();
        }

        return $this->returnSuccess([
            "successful"   => $addedLectures,
            "unsuccessful" => $failedToAddLectures,
        ]);
    }
}