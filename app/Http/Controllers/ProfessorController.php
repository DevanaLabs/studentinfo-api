<?php

namespace StudentInfo\Http\Controllers;

use Illuminate\Auth\Guard;
use StudentInfo\Http\Requests\AddProfessorRequest;
use StudentInfo\Http\Requests\DeleteProfessorRequest;
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

        return $this->returnSuccess($professors);
//        foreach ($professors as $professor) {
//            print_r($professor);
//        }
    }

    public function getEditProfessor($id)
    {
        return $this->returnSuccess($this->professorRepository->find($id));
    }

    public function putEditProfessor(EditProfessorRequest $request, $id)
    {
        $professor = Professor::editProfessor($request, $this->professorRepository, $id);

        return $this->returnSuccess([
            'professor' => $professor
        ]);
    }

    public function deleteProfessors(DeleteProfessorRequest $request)
    {
        $ids = $request->get('ids');
        $deletedProfessors = [];

        foreach($ids as $id)
        {
            $professor = $this->professorRepository->find($id);
            if ($professor === null)
            {
                continue;
            }
            $this->professorRepository->destroy($professor);
            $deletedProfessors[] = $id;
        }
        return $this->returnSuccess([
            'deletedProfessors' => $deletedProfessors
        ]);
    }
}