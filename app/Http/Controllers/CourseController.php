<?php


namespace StudentInfo\Http\Controllers;


use Illuminate\Contracts\Auth\Guard;
use StudentInfo\Http\Requests\AddCourseRequest;
use StudentInfo\Http\Requests\DeleteCourseRequest;
use StudentInfo\Models\Course;
use StudentInfo\Repositories\CourseRepositoryInterface;

class CourseController extends ApiController
{
    /**
     * @var CourseRepositoryInterface
     */
    protected $courseRepository;

    /**
     * @var Guard
     */
    protected $guard;

    /**
     * CourseController constructor.
     * @param CourseRepositoryInterface $courseRepository
     * @param Guard                     $guard
     */
    public function __construct(CourseRepositoryInterface $courseRepository, Guard $guard)
    {
        $this->courseRepository = $courseRepository;
        $this->guard            = $guard;
    }

    /**
     * @param AddCourseRequest $request
     * @return \Illuminate\Http\Response
     */
    public function addCourses(AddCourseRequest $request)
    {
        $added_courses = [];

        $courses = $request->get('courses');

        for ($i = 0; $i < count($courses); $i++) {
            $course = new Course();
            $course->setCode($courses[$i]['courseCode']);
            $course->setSemester($courses[$i]['courseSemester']);
            $this->courseRepository->create($course);
            $added_courses[] = $course;
        }

        return $this->returnSuccess([
            'courses' => $added_courses,
        ]);

        /*
        $lecture   = new Lecture();
        $professor = new Professor();
        $classroom = new Classroom();
        $classroom->setName("Gigantski amfiteatar Milan Vucic");
        $classroom->setDirections("Ne mozes da ga omasis");
        $professor->setFirstName("Milovan");
        $professor->setLastName("Mitic");
        $professor->setLectures([$lecture]);
        $lecture->setProfessor($professor);
        $lecture->setClassroom($classroom);
        $lecture->setCourse($course);
        $course->setLectures([$lecture]);
        */
    }

    public function getCourses()
    {
        $courses = $this->courseRepository->all();

        foreach ($courses as $course) {
            print_r($course);
        }
    }

    public function deleteCourses(DeleteCourseRequest $request)
    {
        $ids = $request->get('ids');
        foreach ($ids as $id) {
            $course = $this->courseRepository->find($id);
            if ($course === null) {
                continue;
            }
            $this->courseRepository->destroy($course);
        }
        return $this->returnSuccess();
    }
}