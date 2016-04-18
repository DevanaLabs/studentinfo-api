<?php

namespace StudentInfo\Http\Controllers;


use LucaDegasperi\OAuth2Server\Authorizer;
use StudentInfo\ErrorCodes\PanelErrorCodes;
use StudentInfo\ErrorCodes\UserErrorCodes;
use StudentInfo\Http\Requests\Create\CreatePanelRequest;
use StudentInfo\Http\Requests\StandardRequest;
use StudentInfo\Http\Requests\Update\UpdatePanelRequest;
use StudentInfo\Models\Panel;
use StudentInfo\Models\User;
use StudentInfo\Repositories\FacultyRepositoryInterface;
use StudentInfo\Repositories\PanelRepositoryInterface;
use StudentInfo\Repositories\UserRepositoryInterface;
use StudentInfo\ValueObjects\Email;
use StudentInfo\ValueObjects\Password;

class PanelController extends ApiController
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
     * @var $panelRepositoryInterface
     */
    protected $panelRepository;

    /**
     * @var Authorizer
     */
    protected $authorizer;

    /**
     * StudentController constructor.
     * @param UserRepositoryInterface    $userRepository
     * @param FacultyRepositoryInterface $facultyRepository
     * @param PanelRepositoryInterface   $panelRepository
     * @param Authorizer                 $authorizer
     */
    public function __construct(UserRepositoryInterface $userRepository, FacultyRepositoryInterface $facultyRepository, PanelRepositoryInterface $panelRepository, Authorizer $authorizer)
    {
        $this->userRepository    = $userRepository;
        $this->facultyRepository = $facultyRepository;
        $this->panelRepository   = $panelRepository;
        $this->authorizer        = $authorizer;
    }

    public function createPanel(CreatePanelRequest $request, $faculty)
    {
        /** @var Email $email */
        $email = new Email($request->get('email'));
        if ($this->userRepository->findByEmail($email)) {
            return $this->returnError(500, UserErrorCodes::NOT_UNIQUE_EMAIL);
        }
        $panel = new Panel();
        $panel->setFirstName($request->get('firstName'));
        $panel->setLastName($request->get('lastName'));
        $panel->setEmail($email);
        $panel->setPassword(new Password('password'));
        $panel->generateRegisterToken();
        $panel->setOrganisation($this->userRepository->find($this->authorizer->getResourceOwnerId())->getOrganisation());

        $this->panelRepository->create($panel);

        return $this->returnSuccess([
            'panel' => $panel,
        ]);
    }

    public function retrievePanel(StandardRequest $request, $faculty, $id)
    {
        /** @var Panel $panel */
        $panel = $this->panelRepository->find($id);

        if ($panel === null) {
            return $this->returnError(500, PanelErrorCodes::PANEL_NOT_IN_DB);
        }

        if ($panel->getOrganisation()->getSlug() != $faculty) {
            return $this->returnError(500, PanelErrorCodes::PANEL_DOES_NOT_BELONG_TO_THIS_FACULTY);
        }

        return $this->returnSuccess([
            'panel' => $panel,
        ]);
    }

    public function retrievePanels(StandardRequest $request, $faculty, $start = 0, $count = 2000)
    {
        /** @var Panel[] $panels */
        $panels = $this->panelRepository->all($faculty, $start, $count);

        return $this->returnSuccess($panels);
    }

    public function updatePanel(UpdatePanelRequest $request, $faculty, $id)
    {
        /** @var Panel $panels */
        $assistant = $this->panelRepository->find($id);
        if ($assistant === null) {
            return $this->returnError(500, PanelErrorCodes::PANEL_NOT_IN_DB);
        }

        $email = new Email($request->get('email'));

        /** @var  User $user */
        $user = $this->userRepository->findByEmail($email);
        if ($user) {
            if ($user->getId() != $id) {
                return $this->returnError(500, UserErrorCodes::NOT_UNIQUE_EMAIL);
            }
        }

        $panels->setFirstName($request->get('firstName'));
        $panels->setLastName($request->get('lastName'));
        $panels->setEmail($email);

        $this->panelRepository->update($panels);

        return $this->returnSuccess([
            'assistant' => $assistant,
        ]);
    }

    public function deletePanel($faculty, $id)
    {
        $assistant = $this->panelRepository->find($id);
        if ($assistant === null) {
            return $this->returnError(500, PanelErrorCodes::PANEL_NOT_IN_DB);
        }
        $this->panelRepository->destroy($assistant);

        return $this->returnSuccess();
    }
}