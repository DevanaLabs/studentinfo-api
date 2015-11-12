<?php

namespace StudentInfo\Models;


use Doctrine\Common\Collections\ArrayCollection;
use StudentInfo\Http\Requests\EditProfessorRequest;
use StudentInfo\Repositories\ProfessorRepositoryInterface;

class Professor
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $firstName;

    /**
     * @var string
     */
    protected $lastName;

    /**
     * @var string
     */
    protected $title;

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @var ArrayCollection|Lecture[]
     */
    protected $lectures;

    /**
     * Professor constructor.
     */
    public function __construct()
    {
        $this->lectures = new ArrayCollection();
    }

    /**
     * @param ProfessorRepositoryInterface $professorRepository
     * @param ArrayCollection|Professor[]  $professors
     * @return array
     */
    public static function addProfessor(ProfessorRepositoryInterface $professorRepository, $professors)
    {
        $addedProfessors = [];

        for ($count = 0; $count < count($professors); $count++) {
            $professor = new Professor();
            $professor->setFirstName($professors[$count]['firstName']);
            $professor->setLastName($professors[$count]['lastName']);
            $professor->setTitle($professors[$count]['title']);
            $professorRepository->create($professor);

            $addedProfessors[] = $professor;
        }
        return $addedProfessors;
    }

    public static function editProfessor(EditProfessorRequest $request, ProfessorRepositoryInterface $professorRepository, $id)
    {
        /** @var  Professor $professor */
        $professor = $professorRepository->find($id);

        $professor->setFirstName($request->get('firstName'));
        $professor->setLastName($request->get('lastName'));
        $professor->setTitle($request->get('title'));

        $professorRepository->update($professor);

        return $professor;
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
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    /**
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

}
