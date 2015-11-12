<?php

namespace StudentInfo\Models;

use Doctrine\Common\Collections\ArrayCollection;
use StudentInfo\Http\Requests\EditLectureRequest;
use StudentInfo\Repositories\ClassroomRepositoryInterface;
use StudentInfo\Repositories\CourseRepositoryInterface;
use StudentInfo\Repositories\LectureRepositoryInterface;
use StudentInfo\Repositories\ProfessorRepositoryInterface;

class Lecture
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var Course
     */
    private $course;

    /**
     * @var Professor
     */
    private $professor;

    /**
     * @var Classroom
     */
    private $classroom;

    /**
     * @var ArrayCollection|Student[]
     */
    private $students;

    /**
     * Lecture constructor.
     */
    public function __construct()
    {
        $this->students = new ArrayCollection();
    }

    /**
     * @param EditLectureRequest         $request
     * @param LectureRepositoryInterface $lectureRepository
     * @param                            $id
     * @return Lecture
     */
    public static function editLecture(EditLectureRequest $request, LectureRepositoryInterface $lectureRepository, $id)
    {
        /** @var  Lecture $lecture */
        $lecture = $lectureRepository->find($id);

        $lecture->setProfessor($request->get('professorId'));
        $lecture->setCourse($request->get('courseId'));
        $lecture->setClassroom($request->get('classroomId'));

        $lectureRepository->update($lecture);

        return $lecture;
    }
    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return Course
     */
    public function getCourse()
    {
        return $this->course;
    }

    /**
     * @param Course $course
     */
    public function setCourse($course)
    {
        $this->course = $course;
    }

    /**
     * @return Professor
     */
    public function getProfessor()
    {
        return $this->professor;
    }

    /**
     * @param Professor $professor
     */
    public function setProfessor($professor)
    {
        $this->professor = $professor;
    }

    /**
     * @return Classroom
     */
    public function getClassroom()
    {
        return $this->classroom;
    }

    /**
     * @param Classroom $classroom
     */
    public function setClassroom($classroom)
    {
        $this->classroom = $classroom;
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