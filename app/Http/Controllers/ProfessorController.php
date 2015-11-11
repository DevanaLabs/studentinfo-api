<?php

namespace StudentInfo\Http\Controllers;

use Illuminate\Auth\Guard;
use StudentInfo\Http\Requests\AddProfessorRequest;
use StudentInfo\Models\Professor;
use StudentInfo\Repositories\ClassroomRepositoryInterface;
use StudentInfo\Repositories\ProfessorRepositoryInterface;

class ProfessorController extends ApiController
{
    /**
     * @var ClassroomRepositoryInterface
     */
    protected $professorRepository;

    /**
     * @var Guard
     */
    protected $guard;

    /**
     * StudentController constructor.
     * @param ProfessorRepositoryInterface $professorRepository
     * @param Guard                        $guard
     */
    public function __construct(ProfessorRepositoryInterface $professorRepository, Guard $guard)
    {
        $this->professorRepository = $professorRepository;
        $this->guard          = $guard;
    }

    public function addProfessors(AddProfessorRequest $request)
    {
        $addedProfessors = [];

        $professors = $request->get('professors');

        for ($count = 0; $count < count($professors); $count++) {
            $professor = new Professor();
            $professor->setFirstName($professors[$count]['firstName']);
            $professor->setLastName($professors[$count]['lastName']);
            $professor->setTitle($professors[$count]['title']);
            $this->professorRepository->create($professor);

            $addedProfessors[] = $professor;
        }
        $this->returnSuccess($addedProfessors);
    }

    public function getProfessors()
    {
        $professors = $this->professorRepository->all();

        foreach ($professors as $professor) {
            print_r($professor);
        }
    }
}