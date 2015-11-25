<?php


namespace StudentInfo\Http\Controllers;


use Illuminate\Contracts\Auth\Guard;
use StudentInfo\ErrorCodes\UserErrorCodes;
use StudentInfo\Http\Requests\AddCourseRequest;
use StudentInfo\Http\Requests\Request;
use StudentInfo\Http\Requests\StandardRequest;
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
        $addedCourses = [];

        $failedToAddCourses =[];
        $courses = $request->get('courses');

        for ($count = 0; $count < count($courses); $count++) {
            $course = new Course();
            $course->setCode($courses[$count]['code']);
            $course->setSemester($courses[$count]['semester']);
            if ($this->courseRepository->findByCode($courses[$count]['code'])) {
                $failedToAddCourses[] = $course;
                continue;
            }
            $this->courseRepository->create($course);

            $addedCourses[] = $course;
        }

        return $this->returnSuccess([
            'successful'   => $addedCourses,
            'unsuccessful' => $failedToAddCourses,
        ]);
    }

    public function getCourse($id)
    {
        $course = $this->courseRepository->find($id);

        if($course === null){
            return $this->returnError(500, UserErrorCodes::COURSE_NOT_IN_DB);
        }

        return $this->returnSuccess([
            'course' => $course
        ]);
    }

    public function getCourses($start = 0, $count = 20)
    {
        $courses = $this->courseRepository->all($start, $count);

        return $this->returnSuccess($courses);
    }

    public function putEditCourse(StandardRequest $request, $id)
    {
        if($this->courseRepository->find($id) === null){
            return $this->returnError(500, UserErrorCodes::COURSE_NOT_IN_DB);
        }

        /** @var  Course $course */
        $course = $this->courseRepository->find($id);

        $course->setCode($request->get('code'));
        $course->setSemester($request->get('semester'));

        $this->courseRepository->update($course);


        return $this->returnSuccess([
            'course' => $course
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

}