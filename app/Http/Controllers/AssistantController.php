<?php

namespace StudentInfo\Http\Controllers;


use Illuminate\Contracts\Auth\Guard;
use StudentInfo\ErrorCodes\AssistantErrorCodes;
use StudentInfo\ErrorCodes\UserErrorCodes;
use StudentInfo\Http\Requests\AddFromCSVRequest;
use StudentInfo\Http\Requests\Create\CreateTeacherRequest;
use StudentInfo\Http\Requests\Update\UpdateTeacherRequest;
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

    public function createAssistant(CreateTeacherRequest $request)
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
            return $this->returnError(500, AssistantErrorCodes::ASSISTANT_NOT_IN_DB);
        }

        return $this->returnSuccess([
            'assistant' => $assistant,
        ]);
    }

    public function retrieveAssistants($start = 0, $count = 2000)
    {
        $assistants = $this->assistantRepository->all($start, $count);

        return $this->returnSuccess($assistants);
    }

    public function updateAssistant(UpdateTeacherRequest $request, $id)
    {
        if ($this->assistantRepository->find($id) === null) {
            return $this->returnError(500, AssistantErrorCodes::ASSISTANT_NOT_IN_DB);
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
            return $this->returnError(500, AssistantErrorCodes::ASSISTANT_NOT_IN_DB);
        }
        $this->assistantRepository->destroy($assistant);

        return $this->returnSuccess();
    }

    public function addProfessorsFromCSV(AddFromCSVRequest $request)
    {
        $handle = $request->file('import');

        $file_path = $handle->getPathname();
        $resource  = fopen($file_path, "r");

        while (($data = fgetcsv($resource, 1000, ",")) !== FALSE) {
            $firstName = $data[0];
            $lastName  = $data[1];
            $title     = $data[2];
            $email     = new Email($data[3]);

            if ($this->userRepository->findByEmail($email)) {
                return $this->returnError(500, UserErrorCodes::NOT_UNIQUE_EMAIL);
            }
            $assistant = new Assistant();
            $assistant->setFirstName($firstName);
            $assistant->setLastName($lastName);
            $assistant->setTitle($title);
            $assistant->setEmail($email);
            $assistant->setPassword(new Password('password'));
            $assistant->generateRegisterToken();
            $assistant->setOrganisation($this->facultyRepository->findFacultyByName($this->guard->user()->getOrganisation()->getName()));

            $this->assistantRepository->persist($assistant);
        }
        $this->assistantRepository->flush();

        return $this->returnSuccess();
    }
}