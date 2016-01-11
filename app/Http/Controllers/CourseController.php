<?php


namespace StudentInfo\Http\Controllers;


use Illuminate\Contracts\Auth\Guard;
use StudentInfo\ErrorCodes\CourseErrorCodes;
use StudentInfo\ErrorCodes\FacultyErrorCodes;
use StudentInfo\Http\Requests\AddFromCSVRequest;
use StudentInfo\Http\Requests\Create\CreateCourseRequest;
use StudentInfo\Http\Requests\Update\UpdateCourseRequest;
use StudentInfo\Models\Course;
use StudentInfo\Repositories\CourseRepositoryInterface;
use StudentInfo\Repositories\FacultyRepositoryInterface;

class CourseController extends ApiController
{
    /**
     * @var CourseRepositoryInterface $courseRepository
     */
    protected $courseRepository;

    /**
     * @var FacultyRepositoryInterface $facultyRepository
     */
    protected $facultyRepository;

    /**
     * @var Guard
     */
    protected $guard;

    /**
     * CourseController constructor.
     * @param CourseRepositoryInterface  $courseRepository
     * @param FacultyRepositoryInterface $facultyRepository
     * @param Guard                      $guard
     */
    public function __construct(CourseRepositoryInterface $courseRepository, FacultyRepositoryInterface $facultyRepository, Guard $guard)
    {
        $this->courseRepository   = $courseRepository;
        $this->facultyRepository   = $facultyRepository;
        $this->guard               = $guard;
    }

    public function createCourse(CreateCourseRequest $request)
    {
        $code = $request->get('code');
        $course = new Course();
        $course->setCode($code);
        $course->setEspb($request->get('espb'));
        $course->setSemester($request->get('semester'));
        $course->setName($request->get('name'));
        $course->setOrganisation($this->guard->user()->getOrganisation());

        $this->courseRepository->create($course);

        return $this->returnSuccess([
            'course' => $course,
        ]);
    }

    public function retrieveCourse($faculty, $id)
    {
        $course = $this->courseRepository->find($id);

        if ($course === null) {
            return $this->returnError(500, CourseErrorCodes::COURSE_NOT_IN_DB);
        }

        if ($course->getOrganisation()->getSlug() != $faculty) {
            return $this->returnError(500, CourseErrorCodes::COURSE_DOES_NOT_BELONG_TO_THIS_FACULTY);
        }

        return $this->returnSuccess([
            'course' => $course,
        ]);
    }

    public function retrieveCourses($faculty, $start = 0, $count = 2000)
    {
        $courses = $this->courseRepository->all($faculty, $start, $count);

        return $this->returnSuccess($courses);
    }

    public function updateCourse(UpdateCourseRequest $request, $id)
    {
        if ($this->courseRepository->find($id) === null) {
            return $this->returnError(500, CourseErrorCodes::COURSE_NOT_IN_DB);
        }

        /** @var  Course $course */
        $course = $this->courseRepository->find($id);

        $course->setCode($request->get('code'));
        $course->setEspb($request->get('espb'));
        $course->setSemester($request->get('semester'));
        $course->setName($request->get('name'));
        $course->setOrganisation($this->guard->user()->getOrganisation());

        $this->courseRepository->update($course);


        return $this->returnSuccess([
            'course' => $course,
        ]);
    }

    public function deleteCourse($id)
    {
        $course = $this->courseRepository->find($id);
        if ($course === null) {
            return $this->returnError(500, CourseErrorCodes::COURSE_NOT_IN_DB);
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
            $course->setOrganisation($this->guard->user()->getOrganisation());

            $this->courseRepository->create($course);

            $addedCourses[] = $course;
        }

        return $this->returnSuccess([
            "successful" => $addedCourses,
        ]);
    }
}