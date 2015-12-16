<?php


namespace StudentInfo\Http\Controllers;


use Illuminate\Contracts\Auth\Guard;
use StudentInfo\ErrorCodes\UserErrorCodes;
use StudentInfo\Http\Requests\AddFromCSVRequest;
use StudentInfo\Http\Requests\Create\CreateCourseRequest;
use StudentInfo\Http\Requests\Update\UpdateCourseRequest;
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

    public function createCourse(CreateCourseRequest $request)
    {
        $code = $request->get('code');
        $course = new Course();
        $course->setCode($code);
        $course->setEspb($request->get('espb'));
        $course->setSemester($request->get('semester'));
        $course->setName($request->get('name'));

        $this->courseRepository->create($course);

        return $this->returnSuccess([
            'course' => $course,
        ]);
    }

    public function retrieveCourse($id)
    {
        $course = $this->courseRepository->find($id);

        if ($course === null) {
            return $this->returnError(500, UserErrorCodes::COURSE_NOT_IN_DB);
        }

        return $this->returnSuccess([
            'course' => $course,
        ]);
    }

    public function retrieveCourses($start = 0, $count = 20)
    {
        $courses = $this->courseRepository->all($start, $count);

        return $this->returnSuccess($courses);
    }

    public function updateCourse(UpdateCourseRequest $request, $id)
    {
        if ($this->courseRepository->find($id) === null) {
            return $this->returnError(500, UserErrorCodes::COURSE_NOT_IN_DB);
        }

        /** @var  Course $course */
        $course = $this->courseRepository->find($id);

        $course->setCode($request->get('code'));
        $course->setEspb($request->get('espb'));
        $course->setSemester($request->get('semester'));
        $course->setName($request->get('name'));

        $this->courseRepository->update($course);


        return $this->returnSuccess([
            'course' => $course,
        ]);
    }

    public function deleteCourse($id)
    {
        $course = $this->courseRepository->find($id);
        if ($course === null) {
            return $this->returnError(500, UserErrorCodes::COURSE_NOT_IN_DB);
        }
        $this->courseRepository->destroy($course);

        return $this->returnSuccess();
    }

    public function addCoursesFromCSV(AddFromCSVRequest $request)
    {
        $addedCourses = [];

        $handle = $request->file('import');

        $file_path = $handle->getPathname();
        $resource  = fopen($file_path, "r");
        while (($data = fgetcsv($resource, 1000, ",")) !== FALSE) {
            $name     = $data[0];
            $code     = $data[1];
            $espb     = $data[2];
            $semester = $data[3];

            $course = new Course();
            $course->setName($name);
            $course->setCode($code);
            $course->setEspb($espb);
            $course->setSemester($semester);

            $this->courseRepository->create($course);

            $addedCourses[] = $course;
        }

        return $this->returnSuccess([
            "successful" => $addedCourses,
        ]);
    }
}