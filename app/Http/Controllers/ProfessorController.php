<?php

namespace StudentInfo\Http\Controllers;

use Illuminate\Auth\Guard;
use StudentInfo\Http\Requests\AddProfessorRequest;
use StudentInfo\Http\Requests\EditProfessorRequest;
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
        $addedProfessors = Professor::addProfessor($this->professorRepository, $request->get('professors'));

        return $this->returnSuccess([
            'professors' => $addedProfessors,
        ]);
    }

    public function getProfessors()
    {
        $professors = $this->professorRepository->all();

        foreach ($professors as $professor) {
            print_r($professor);
        }
    }

    public function getEditProfessor($id)
    {
        print_r($this->professorRepository->find($id));
    }

    public function putEditProfessor(EditProfessorRequest $request, $id)
    {
        $professor = Professor::editProfessor($request, $this->professorRepository, $id);

        return $this->returnSuccess([
            'professor' => $professor
        ]);
    }
}