<?php

namespace StudentInfo\Models;

use Doctrine\Common\Collections\ArrayCollection;
use StudentInfo\Http\Requests\EditCourseRequest;
use StudentInfo\Repositories\CourseRepositoryInterface;

class Course
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $code;

    /**
     * @var int
     */
    protected $semester;

    /**
     * @var ArrayCollection|Lecture[]
     */
    protected $lectures;

    /**
     * @var ArrayCollection|Student[]
     */
    protected $students;

    /**
     * Course constructor.
     */
    public function __construct()
    {
        $this->lectures = new ArrayCollection();
        $this->students = new ArrayCollection();
    }

    /**
     * @param CourseRepositoryInterface $courseRepository
     * @param                           $courses
     * @return array
     */
    public static function addCourse(CourseRepositoryInterface $courseRepository, $courses)
    {
        $addedCourses = [];

        for ($i = 0; $i < count($courses); $i++) {
            $course = new Course();
            $course->setCode($courses[$i]['code']);
            $course->setSemester($courses[$i]['semester']);
            $courseRepository->create($course);

            $addedCourses[] = $course;
        }
        return $addedCourses;
    }

    /**
     * @param EditCourseRequest                      $request
     * @param CourseRepositoryInterface              $courseRepository
     * @param                                        $id
     * @return Course
     */
    public static function editCourse(EditCourseRequest $request, CourseRepositoryInterface $courseRepository, $id)
    {
        /** @var  Course $course */
        $course = $courseRepository->find($id);

        $course->setCode($request->get('code'));
        $course->setSemester($request->get('semester'));

        $courseRepository->update($course);

        return $course;
    }

    /**
     * @return ArrayCollection|Lecture[]
     */
    public function getLectures()
    {
        return $this->lectures;
    }

    /**
     * @param ArrayCollection|Lecture[] $lectures
     */
    public function setLectures($lectures)
    {
        $this->lectures = $lectures;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param string $code
     */
    public function setCode($code)
    {
        $this->code = $code;
    }

    /**
     * @return int
     */
    public function getSemester()
    {
        return $this->semester;
    }

    /**
     * @param int $semester
     */
    public function setSemester($semester)
    {
        $this->semester = $semester;
    }

    /**
     * @return ArrayCollection|Student[]
     */
    public function getStudents()
    {
        return $this->students;
    }

    /**
     * @param ArrayCollection|Student[] $students
     */
    public function setStudents($students)
    {
        $this->students = $students;
    }

}