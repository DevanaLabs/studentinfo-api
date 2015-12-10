<?php

namespace StudentInfo\Http\Controllers;

use Illuminate\Auth\Guard;
use StudentInfo\ErrorCodes\UserErrorCodes;
use StudentInfo\Http\Requests\AddFromCSVRequest;
use StudentInfo\Http\Requests\AddProfessorRequest;
use StudentInfo\Models\Professor;
use StudentInfo\Repositories\FacultyRepositoryInterface;
use StudentInfo\Repositories\ProfessorRepositoryInterface;
use StudentInfo\Repositories\UserRepositoryInterface;
use StudentInfo\ValueObjects\Email;
use StudentInfo\ValueObjects\Password;

class ProfessorController extends ApiController
{
    /**
     * @var UserRepositoryInterface
     */
    protected $userRepository;

    /**
     * @var FacultyRepositoryInterface
     */
    protected $facultyRepository;

    /**
     * @var ProfessorRepositoryInterface
     */
    protected $professorRepository;

    /**
     * @var Guard
     */
    protected $guard;

    /**
     * StudentController constructor.
     * @param UserRepositoryInterface    $userRepository
     * @param FacultyRepositoryInterface $facultyRepository
     * @param ProfessorRepositoryInterface $professorRepository
     * @param Guard                        $guard
     */
    public function __construct(UserRepositoryInterface $userRepository, FacultyRepositoryInterface $facultyRepository, ProfessorRepositoryInterface $professorRepository, Guard $guard)
    {
        $this->userRepository    = $userRepository;
        $this->facultyRepository = $facultyRepository;
        $this->professorRepository = $professorRepository;
        $this->guard             = $guard;
    }

    public function addProfessor(AddProfessorRequest $request)
    {
        /** @var Email $email */
        $email = new Email($request->get('email'));
        if ($this->userRepository->findByEmail($email)) {
            return $this->returnError(500, UserErrorCodes::STUDENT_NOT_UNIQUE_EMAIL);
        }
        $professor = new Professor();
        $professor->setFirstName($request->get('firstName'));
        $professor->setLastName($request->get('lastName'));
        $professor->setTitle($request->get('title'));
        $professor->setEmail($email);
        $professor->setPassword(new Password('password'));
        $professor->generateRegisterToken();
        $professor->setOrganisation($this->facultyRepository->findFacultyByName($this->guard->user()->getOrganisation()->getName()));

        $this->professorRepository->create($professor);

        return $this->returnSuccess([
            'professor'   => $professor,
        ]);
    }

    public function addProfessorsFromCSV(AddFromCSVRequest $request)
    {
        $addedProfessors       = [];
        $failedToAddProfessors = [];
        $handle = $request->file('import');

        $file_path = $handle->getPathname();
        $resource  = fopen($file_path, "r");
        while (($data = fgetcsv($resource, 1000, ",")) !== FALSE) {
            $firstName = $data[0];
            $lastName  = $data[1];
            $title = $data[2];
            $email = new Email($data[3]);

            if ($this->userRepository->findByEmail($email))
            {
                $failedToAddProfessors[] = $email;
                continue;
            }
            $professor = new Professor();
            $professor->setFirstName($firstName);
            $professor->setLastName($lastName);
            $professor->setTitle($title);
            $professor->setEmail($email);
            $professor->setPassword(new Password('password'));
            $professor->generateRegisterToken();
            $professor->setOrganisation($this->facultyRepository->findFacultyByName($this->guard->user()->getOrganisation()->getName()));
            $this->professorRepository->create($professor);

            $addedProfessors[] = $professor;
        }

        return $this->returnSuccess([
            "successful"   => $addedProfessors,
            "unsuccessful" => $failedToAddProfessors,
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
        $professors = $this->professorRepository->getAllProfessorForFaculty($this->facultyRepository->findFacultyByName($this->guard->user()->getOrganisation()->getName()), $start, $count);

        return $this->returnSuccess($professors);
    }

    public function putEditProfessor(AddProfessorRequest $request, $id)
    {
        if($this->professorRepository->find($id) === null){
            return $this->returnError(500, UserErrorCodes::PROFESSOR_NOT_IN_DB);
        }

        /** @var Email $email */
        $email = new Email($request->get('email'));
        if ($this->userRepository->findByEmail($email)) {
            return $this->returnError(500, UserErrorCodes::STUDENT_NOT_UNIQUE_EMAIL);
        }

        /** @var Professor $professor */
        $professor = $this->professorRepository->find($id);

        $professor->setFirstName($request->get('firstName'));
        $professor->setLastName($request->get('lastName'));
        $professor->setTitle($request->get('title'));
        $professor->setEmail($email);
        $professor->setPassword(new Password('password'));
        $professor->generateRegisterToken();

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