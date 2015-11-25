<?php

namespace StudentInfo\Http\Controllers;

use Illuminate\Auth\Guard;
use StudentInfo\ErrorCodes\UserErrorCodes;
use StudentInfo\Http\Requests\AddProfessorRequest;
use StudentInfo\Http\Requests\DeleteProfessorRequest;
use StudentInfo\Http\Requests\EditProfessorRequest;
use StudentInfo\Http\Requests\Request;
use StudentInfo\Http\Requests\StandardRequest;
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

        $failedToAddProfessors = [];

        $professors = $request->get('professors');

        for ($count = 0; $count < count($professors); $count++) {
            $professor = new Professor();
            $professor->setFirstName($professors[$count]['firstName']);
            $professor->setLastName($professors[$count]['lastName']);
            $professor->setTitle($professors[$count]['title']);
            if ($this->professorRepository->findByName($professors[$count]['firstName'],$professors[$count]['lastName'])) {
                $failedToAddProfessors[] = $professor;
                continue;
            }
            $this->professorRepository->create($professor);

            $addedProfessors[] = $professor;
        }

        return $this->returnSuccess([
            'successful'   => $addedProfessors,
            'unsuccessful' => $failedToAddProfessors,
        ]);
    }

    public function getProfessor($id)
    {
        $professor = $this->professorRepository->find($id);

        if($professor === null){
            return $this->returnError(500, UserErrorCodes::PROFESSOR_NOT_IN_DB);
        }

        return $this->returnSuccess([
            'professor' => $professor
        ]);
    }

    public function getProfessors($start = 0, $count = 20)
    {
        $professors = $this->professorRepository->all($start, $count);

        return $this->returnSuccess($professors);
    }

    public function putEditProfessor(StandardRequest $request, $id)
    {
        if($this->professorRepository->find($id) === null){
            return $this->returnError(500, UserErrorCodes::PROFESSOR_NOT_IN_DB);
        }

        /** @var Professor $professor */
        $professor = $this->professorRepository->find($id);

        $professor->setFirstName($request->get('firstName'));
        $professor->setLastName($request->get('lastName'));
        $professor->setTitle($request->get('title'));

        $this->professorRepository->update($professor);

        return $this->returnSuccess([
            'professor' => $professor
        ]);
    }

    public function deleteProfessor($id)
    {
        $professor = $this->professorRepository->find($id);
        if ($professor === null)
        {
            return $this->returnError(500, UserErrorCodes::PROFESSOR_NOT_IN_DB);
        }
        $this->professorRepository->destroy($professor);

        return $this->returnSuccess();
    }
}