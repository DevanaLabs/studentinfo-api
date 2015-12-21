<?php

namespace StudentInfo\Http\Controllers;


use Exception;
use Illuminate\Contracts\Auth\Guard;
use StudentInfo\ErrorCodes\FacultyErrorCodes;
use StudentInfo\ErrorCodes\UserErrorCodes;
use StudentInfo\Http\Requests\Create\CreateFacultyRequest;
use StudentInfo\Http\Requests\Update\UpdateFacultyRequest;
use StudentInfo\Models\Faculty;
use StudentInfo\Repositories\FacultyRepositoryInterface;

class FacultyController extends ApiController
{
    /**
     * @var FacultyRepositoryInterface
     */
    protected $facultyRepository;

    /**
     * @var Guard
     */
    protected $guard;

    /**
     * FacultyController constructor.
     * @param FacultyRepositoryInterface $facultyRepository
     * @param Guard                      $guard
     */
    public function __construct(FacultyRepositoryInterface $facultyRepository, Guard $guard)
    {
        $this->facultyRepository = $facultyRepository;
        $this->guard             = $guard;
    }

    public function createFaculty(CreateFacultyRequest $request)
    {
        $name = $request->get('name');
        if ($this->facultyRepository->findFacultyByName($name)) {
            return $this->returnError(500, FacultyErrorCodes::FACULTY_ALREADY_EXISTS);
        }
        $faculty = new Faculty();
        $faculty->setName($name);
        $faculty->setUniversity($request->get('university'));

        $this->facultyRepository->create($faculty);

        return $this->returnSuccess([
            'faculty' => $faculty,
        ]);
    }

    public function retrieveFaculty($id)
    {
        $faculty = $this->facultyRepository->find($id);

        if ($faculty === null) {
            return $this->returnError(500, FacultyErrorCodes::FACULTY_NOT_IN_DB);
        }

        return $this->returnSuccess([
            'faculty' => $faculty,
        ]);
    }

    public function retrieveFaculties($start = 0, $count = 2000)
    {
        $faculty = $this->facultyRepository->all($start, $count);

        return $this->returnSuccess($faculty);
    }

    public function updateFaculty(UpdateFacultyRequest $request, $id)
    {
        if ($this->facultyRepository->find($id) === null) {
            return $this->returnError(500, FacultyErrorCodes::FACULTY_NOT_IN_DB);
        }

        /** @var  Faculty $faculty */
        $faculty = $this->facultyRepository->find($id);

        $faculty->setName($request->get('name'));
        $faculty->setUniversity($request->get('university'));

        $this->facultyRepository->update($faculty);


        return $this->returnSuccess([
            'faculty' => $faculty,
        ]);
    }

    public function deleteFaculty($id)
    {
        $faculty = $this->facultyRepository->find($id);
        if ($faculty === null) {
            return $this->returnError(500, FacultyErrorCodes::FACULTY_NOT_IN_DB);
        }
        try {
            $this->facultyRepository->destroy($faculty);
        } catch (Exception $e) {
            return $this->returnError(500, UserErrorCodes::USER_BELONGS_TO_THIS_FACULTY);
        }

        return $this->returnSuccess();
    }
}