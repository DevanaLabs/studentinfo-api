<?php


namespace StudentInfo\Http\Controllers;


use Illuminate\Contracts\Auth\Guard;
use StudentInfo\Http\Requests\AddCourseRequest;
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
     */
    public function addCourse(AddCourseRequest $request)
    {
        $course = new Course();
        $course->setCode($request->get('CourseCode'));
        $course->setSemester($request->get('CourseSemester'));

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
        $this->courseRepository->create($course);
    }

}