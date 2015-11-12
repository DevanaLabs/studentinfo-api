<?php

namespace StudentInfo\Models;

use Doctrine\Common\Collections\ArrayCollection;
use StudentInfo\Http\Requests\EditClassroomRequest;
use StudentInfo\Repositories\ClassroomRepositoryInterface;

class Classroom
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $directions;

    /**
     * @var ArrayCollection|Lecture[]
     */
    private $lectures;

    /**
     * Classroom constructor.
     */
    public function __construct()
    {
        $this->lectures = new ArrayCollection();
    }

    /**
     * @param ClassroomRepositoryInterface $classroomRepository
     * @param ArrayCollection|Classroom[]  $classrooms
     * @return array|ArrayCollection|Classroom[]
     */
    public static function addClassrooms(ClassroomRepositoryInterface $classroomRepository, $classrooms)
    {
        $addedClassrooms = [];

        for ($count = 0; $count < count($classrooms); $count++) {
            $classroom = new Classroom();
            $classroom->setName($classrooms[$count]['name']);
            $classroom->setDirections($classrooms[$count]['directions']);
            $classroomRepository->create($classroom);

            $addedClassrooms[]=$classroom;
        }
        return $addedClassrooms;
    }

    /**
     * @param EditClassroomRequest         $request
     * @param ClassroomRepositoryInterface $classroomRepository
     * @param                              $id
     * @return Classroom
     */
    public static function editClassrooms(EditClassroomRequest $request, ClassroomRepositoryInterface $classroomRepository, $id)
    {
        /** @var  Classroom $classroom */
        $classroom = $classroomRepository->find($id);

        $classroom->setName($request->get('name'));
        $classroom->setDirections($request->get('directions'));

        $classroomRepository->update($classroom);

        return $classroom;
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
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getDirections()
    {
        return $this->directions;
    }

    /**
     * @param string $directions
     */
    public function setDirections($directions)
    {
        $this->directions = $directions;
    }
}