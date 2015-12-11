<?php

namespace StudentInfo\Http\Controllers;


use Illuminate\Contracts\Auth\Guard;
use StudentInfo\ErrorCodes\UserErrorCodes;
use StudentInfo\Http\Requests\AddTeacherRequest;
use StudentInfo\Models\Assistant;
use StudentInfo\Repositories\AssistantRepositoryInterface;
use StudentInfo\Repositories\FacultyRepositoryInterface;
use StudentInfo\Repositories\UserRepositoryInterface;
use StudentInfo\ValueObjects\Email;
use StudentInfo\ValueObjects\Password;

class AssistantController extends ApiController
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
     * @var AssistantRepositoryInterface
     */
    protected $assistantRepository;

    /**
     * @var Guard
     */
    protected $guard;

    /**
     * StudentController constructor.
     * @param UserRepositoryInterface      $userRepository
     * @param FacultyRepositoryInterface   $facultyRepository
     * @param AssistantRepositoryInterface $assistantRepository
     * @param Guard                        $guard
     */
    public function __construct(UserRepositoryInterface $userRepository, FacultyRepositoryInterface $facultyRepository, AssistantRepositoryInterface $assistantRepository, Guard $guard)
    {
        $this->userRepository      = $userRepository;
        $this->facultyRepository   = $facultyRepository;
        $this->assistantRepository = $assistantRepository;
        $this->guard               = $guard;
    }

    public function addAssistant(AddTeacherRequest $request)
    {
        /** @var Email $email */
        $email = new Email($request->get('email'));
        if ($this->userRepository->findByEmail($email)) {
            return $this->returnError(500, UserErrorCodes::NOT_UNIQUE_EMAIL);
        }
        $assistant = new Assistant();
        $assistant->setFirstName($request->get('firstName'));
        $assistant->setLastName($request->get('lastName'));
        $assistant->setTitle($request->get('title'));
        $assistant->setEmail($email);
        $assistant->setPassword(new Password('password'));
        $assistant->generateRegisterToken();
        $assistant->setOrganisation($this->facultyRepository->findFacultyByName($this->guard->user()->getOrganisation()->getName()));

        $this->assistantRepository->create($assistant);

        return $this->returnSuccess([
            'assistant' => $assistant,
        ]);
    }

    public function retrieveAssistant($id)
    {
        $assistant = $this->assistantRepository->find($id);

        if ($assistant === null) {
            return $this->returnError(500, UserErrorCodes::ASSISTANT_NOT_IN_DB);
        }

        return $this->returnSuccess([
            'assistant' => $assistant,
        ]);
    }

    public function retrieveAssistants($start = 0, $count = 20)
    {
        $assistants = $this->assistantRepository->getAllAssistantsForFaculty($this->facultyRepository->findFacultyByName($this->guard->user()->getOrganisation()->getName()), $start, $count);

        return $this->returnSuccess($assistants);
    }

    public function updateAssistant(AddTeacherRequest $request, $id)
    {
        if ($this->assistantRepository->find($id) === null) {
            return $this->returnError(500, UserErrorCodes::ASSISTANT_NOT_IN_DB);
        }

        /** @var Email $email */
        $email = new Email($request->get('email'));
        if ($this->userRepository->findByEmail($email)) {
            return $this->returnError(500, UserErrorCodes::NOT_UNIQUE_EMAIL);
        }

        /** @var Assistant $assistant */
        $assistant = $this->assistantRepository->find($id);

        $assistant->setFirstName($request->get('firstName'));
        $assistant->setLastName($request->get('lastName'));
        $assistant->setTitle($request->get('title'));
        $assistant->setEmail($email);
        $assistant->setPassword(new Password('password'));
        $assistant->generateRegisterToken();

        $this->assistantRepository->update($assistant);

        return $this->returnSuccess([
            'assistant' => $assistant,
        ]);
    }

    public function deleteAssistant($id)
    {
        $assistant = $this->assistantRepository->find($id);
        if ($assistant === null) {
            return $this->returnError(500, UserErrorCodes::ASSISTANT_NOT_IN_DB);
        }
        $this->assistantRepository->destroy($assistant);

        return $this->returnSuccess();
    }
}