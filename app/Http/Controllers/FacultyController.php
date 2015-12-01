<?php

namespace StudentInfo\Http\Controllers;


use Exception;
use Illuminate\Contracts\Auth\Guard;
use StudentInfo\ErrorCodes\UserErrorCodes;
use StudentInfo\Http\Requests\AddFacultyRequest;
use StudentInfo\Http\Requests\StandardRequest;
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
     * @param Guard                     $guard
     */
    public function __construct(FacultyRepositoryInterface $facultyRepository, Guard $guard)
    {
        $this->facultyRepository = $facultyRepository;
        $this->guard            = $guard;
    }

    /**
     * @param AddFacultyRequest $request
     * @return \Illuminate\Http\Response
     */
    public function addFaculty(AddFacultyRequest $request)
    {
        $name = $request->get('name');
        if ($this->facultyRepository->findFacultyByName($name)) {
            return $this->returnError(500, UserErrorCodes::FACULTY_ALREADY_EXISTS);
        }
        $faculty = new Faculty();
        $faculty->setName($name);

        $this->facultyRepository->create($faculty);

        return $this->returnSuccess([
            'faculty'   => $faculty
        ]);
    }

    public function getFaculty($id)
    {
        $faculty = $this->facultyRepository->find($id);

        if($faculty === null){
            return $this->returnError(500, UserErrorCodes::FACULTY_NOT_IN_DB);
        }

        return $this->returnSuccess([
            'faculty' => $faculty
        ]);
    }

    public function getFaculties($start = 0, $count = 20)
    {
        $faculty = $this->facultyRepository->all($start, $count);

        return $this->returnSuccess($faculty);
    }

    public function putEditFaculty(StandardRequest $request, $id)
    {
        if($this->facultyRepository->find($id) === null){
            return $this->returnError(500, UserErrorCodes::FACULTY_NOT_IN_DB);
        }

        /** @var  Faculty $faculty */
        $faculty = $this->facultyRepository->find($id);

        $faculty->setName($request->get('name'));

        $this->facultyRepository->update($faculty);


        return $this->returnSuccess([
            'faculty' => $faculty
        ]);
    }

    public function deleteFaculty($id)
    {
        $faculty = $this->facultyRepository->find($id);
        if ($faculty === null) {
            return $this->returnError(500, UserErrorCodes::FACULTY_NOT_IN_DB);
        }
        try {
            $this->facultyRepository->destroy($faculty);
        } catch (Exception $e) {
            return $this->returnError(500, UserErrorCodes::USER_BELONGS_TO_THIS_FACULTY);
        }

        return $this->returnSuccess();
    }
}