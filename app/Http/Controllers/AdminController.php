<?php

namespace StudentInfo\Http\Controllers;


use LucaDegasperi\OAuth2Server\Authorizer;
use StudentInfo\ErrorCodes\AdminErrorCodes;
use StudentInfo\ErrorCodes\FacultyErrorCodes;
use StudentInfo\ErrorCodes\UserErrorCodes;
use StudentInfo\Http\Requests\Create\CreateAdminRequest;
use StudentInfo\Http\Requests\Update\UpdateAdminRequest;
use StudentInfo\Models\Admin;
use StudentInfo\Models\User;
use StudentInfo\Repositories\AdminRepositoryInterface;
use StudentInfo\Repositories\FacultyRepositoryInterface;
use StudentInfo\Repositories\UserRepositoryInterface;
use StudentInfo\ValueObjects\Email;
use StudentInfo\ValueObjects\Password;

class AdminController extends ApiController
{
    /**
     * @var userRepositoryInterface
     */
    protected $userRepository;

    /**
     * @var FacultyRepositoryInterface
     */
    protected $facultyRepository;

    /**
     * @var AdminRepositoryInterface
     */
    protected $adminRepository;

    /**
     * @var Authorizer
     */
    protected $authorizer;

    public function __construct(UserRepositoryInterface $userRepository, FacultyRepositoryInterface $facultyRepository, AdminRepositoryInterface $adminRepository, Authorizer $authorizer)
    {
        $this->userRepository    = $userRepository;
        $this->facultyRepository = $facultyRepository;
        $this->adminRepository   = $adminRepository;
        $this->authorizer = $authorizer;
    }


    public function createAdmin(CreateAdminRequest $request)
    {
        /** @var Email $email */
        $email = new Email($request->get('email'));
        if ($this->userRepository->findByEmail($email)) {
            return $this->returnError(500, UserErrorCodes::NOT_UNIQUE_EMAIL);
        }
        $faculty = $this->facultyRepository->findFacultyByName($request->get('faculty'));
        if ($faculty === null) {
            return $this->returnError(500, FacultyErrorCodes::FACULTY_NOT_IN_DB);
        }
        $admin = new Admin();
        $admin->setFirstName($request->get('firstName'));
        $admin->setLastName($request->get('lastName'));
        $admin->setEmail($email);
        $admin->setPassword(new Password('password'));
        $admin->generateRegisterToken();
        $admin->setOrganisation($faculty);
        $this->userRepository->create($admin);

        return $this->returnSuccess([
            'admin' => $admin,
        ]);
    }

    public function retrieveAdmin($id)
    {
        $admin = $this->adminRepository->find($id);

        if ($admin === null) {
            return $this->returnError(500, AdminErrorCodes::ADMIN_NOT_IN_DB);
        }

        return $this->returnSuccess([
            'admin' => $admin,
        ]);
    }

    public function retrieveAdmins($start = 0, $count = 2000)
    {
        $admins = $this->adminRepository->all(null, $start, $count);

        return $this->returnSuccess($admins);
    }

    public function updateAdmin(UpdateAdminRequest $request, $id)
    {
        /** @var  Admin $admin */
        $admin = $this->adminRepository->find($id);
        if ($admin === null) {
            return $this->returnError(500, AdminErrorCodes::ADMIN_NOT_IN_DB);
        }

        $email = new Email($request->get('email'));

        /** @var  User $user */
        $user = $this->userRepository->findByEmail($email);
        if ($user) {
            if ($user->getId() != $id) {
                return $this->returnError(500, UserErrorCodes::NOT_UNIQUE_EMAIL);
            }
        }
        $faculty = $this->facultyRepository->findFacultyByName($request->get('faculty'));
        if ($faculty === null) {
            return $this->returnError(500, FacultyErrorCodes::FACULTY_NOT_IN_DB);
        }

        $admin->setFirstName($request->get('firstName'));
        $admin->setLastName($request->get('lastName'));
        $admin->setEmail($email);
        $admin->setPassword(new Password('password'));
        $admin->generateRegisterToken();
        $admin->setOrganisation($faculty);
        $this->adminRepository->update($admin);

        return $this->returnSuccess([
            'admin' => $admin,
        ]);
    }

    public function deleteAdmin($id)
    {
        $admin = $this->adminRepository->find($id);
        if ($admin === null) {
            return $this->returnError(500, AdminErrorCodes::ADMIN_NOT_IN_DB);
        }
        $this->adminRepository->destroy($admin);

        return $this->returnSuccess();
    }
}