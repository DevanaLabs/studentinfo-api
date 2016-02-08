<?php

namespace StudentInfo\Http\Controllers;

use LucaDegasperi\OAuth2Server\Authorizer;
use StudentInfo\ErrorCodes\AssistantErrorCodes;
use StudentInfo\ErrorCodes\UserErrorCodes;
use StudentInfo\Http\Requests\AddFromCSVRequest;
use StudentInfo\Http\Requests\Create\CreateTeacherRequest;
use StudentInfo\Http\Requests\Update\UpdateTeacherRequest;
use StudentInfo\Models\Assistant;
use StudentInfo\Models\User;
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
     * @var Authorizer
     */
    protected $authorizer;

    /**
     * StudentController constructor.
     * @param UserRepositoryInterface      $userRepository
     * @param FacultyRepositoryInterface   $facultyRepository
     * @param AssistantRepositoryInterface $assistantRepository
     * @param Authorizer                   $authorizer
     */
    public function __construct(UserRepositoryInterface $userRepository, FacultyRepositoryInterface $facultyRepository, AssistantRepositoryInterface $assistantRepository, Authorizer $authorizer)
    {
        $this->userRepository      = $userRepository;
        $this->facultyRepository   = $facultyRepository;
        $this->assistantRepository = $assistantRepository;
        $this->authorizer = $authorizer;
    }

    public function createAssistant(CreateTeacherRequest $request, $faculty)
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
        $assistant->setOrganisation($this->userRepository->find($this->authorizer->getResourceOwnerId())->getOrganisation());

        $this->assistantRepository->create($assistant);

        return $this->returnSuccess([
            'assistant' => $assistant,
        ]);
    }

    public function retrieveAssistant($faculty, $id)
    {
        $assistant = $this->assistantRepository->find($id);

        if ($assistant === null) {
            return $this->returnError(500, AssistantErrorCodes::ASSISTANT_NOT_IN_DB);
        }

        if ($assistant->getOrganisation()->getSlug() != $faculty) {
            return $this->returnError(500, AssistantErrorCodes::ASSISTANT_DOES_NOT_BELONG_TO_THIS_FACULTY);
        }

        return $this->returnSuccess([
            'assistant' => $assistant,
        ]);
    }

    public function retrieveAssistants($faculty, $start = 0, $count = 2000)
    {
        $assistants = $this->assistantRepository->all($faculty, $start, $count);

        return $this->returnSuccess($assistants);
    }

    public function updateAssistant(UpdateTeacherRequest $request, $faculty, $id)
    {
        /** @var Assistant $assistant */
        $assistant = $this->assistantRepository->find($id);
        if ($assistant === null) {
            return $this->returnError(500, AssistantErrorCodes::ASSISTANT_NOT_IN_DB);
        }

        $email = new Email($request->get('email'));

        /** @var  User $user */
        $user = $this->userRepository->findByEmail($email);
        if ($user) {
            if ($user->getId() != $id) {
                return $this->returnError(500, UserErrorCodes::NOT_UNIQUE_EMAIL);
            }
        }

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

    public function deleteAssistant($faculty, $id)
    {
        $assistant = $this->assistantRepository->find($id);
        if ($assistant === null) {
            return $this->returnError(500, AssistantErrorCodes::ASSISTANT_NOT_IN_DB);
        }
        $this->assistantRepository->destroy($assistant);

        return $this->returnSuccess();
    }

    public function addAssistantFromCSV(AddFromCSVRequest $request, $faculty)
    {
        $handle = $request->file('import');

        $file_path = $handle->getPathname();
        $resource  = fopen($file_path, "r");

        $organisation = $this->userRepository->find($this->authorizer->getResourceOwnerId())->getOrganisation();

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
            $user = $this->userRepository->find($this->authorizer->getResourceOwnerId());
            $assistant->setOrganisation($organisation);

            $this->assistantRepository->persist($assistant);
        }
        $this->assistantRepository->flush();

        return $this->returnSuccess();
    }
}