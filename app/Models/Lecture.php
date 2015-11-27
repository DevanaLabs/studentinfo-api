<?php

namespace StudentInfo\Models;

use Carbon\Carbon;
use Doctrine\Common\Collections\ArrayCollection;
use StudentInfo\Http\Requests\EditLectureRequest;
use StudentInfo\Http\Requests\StandardRequest;
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
     * @var ArrayCollection|Group[]
     */
    private $groups;

    /**
     * @var Carbon
     */
    private $startsAt;

    /**
     * @var Carbon
     */
    private $endsAt;

    /**
     * Lecture constructor.
     */
    public function __construct()
    {
        $this->students = new ArrayCollection();
        $this->groups = new ArrayCollection();
        $this->events = new ArrayCollection();
    }

    /**
     * @param StandardRequest         $request
     * @param LectureRepositoryInterface $lectureRepository
     * @param                            $id
     * @return Lecture
     */
    public static function editLecture(StandardRequest $request, LectureRepositoryInterface $lectureRepository, $id)
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

    /**
     * @return ArrayCollection|Group[]
     */
    public function getGroups()
    {
        return $this->groups;
    }

    /**
     * @param ArrayCollection|Group[] $groups
     */
    public function setGroups($groups)
    {
        $this->groups = $groups;
    }

    /**
     * @return Carbon
     */
    public function getStartsAt()
    {
        return $this->startsAt;
    }

    /**
     * @param Carbon $startsAt
     */
    public function setStartsAt($startsAt)
    {
        $this->startsAt = $startsAt;
    }

    /**
     * @return Carbon
     */
    public function getEndsAt()
    {
        return $this->endsAt;
    }

    /**
     * @param Carbon $endsAt
     */
    public function setEndsAt($endsAt)
    {
        $this->endsAt = $endsAt;
    }
}