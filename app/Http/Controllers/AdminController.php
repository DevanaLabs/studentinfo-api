<?php

namespace StudentInfo\Http\Controllers;


use Illuminate\Contracts\Auth\Guard;
use StudentInfo\ErrorCodes\UserErrorCodes;
use StudentInfo\Http\Requests\AddAdminRequest;
use StudentInfo\Http\Requests\StandardRequest;
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
     * @var Guard
     */
    protected $guard;

    public function __construct(UserRepositoryInterface $userRepository, FacultyRepositoryInterface $facultyRepository, AdminRepositoryInterface $adminRepository, Guard $guard)
    {
        $this->userRepository        = $userRepository;
        $this->facultyRepository     = $facultyRepository;
        $this->adminRepository       = $adminRepository;
        $this->guard                 = $guard;
    }


    public function addAdmin(AddAdminRequest $request)
    {
        /** @var Email $email */
        $email = new Email($request->get('email'));
        if ($this->userRepository->findByEmail($email)) {
            return $this->returnError(500, UserErrorCodes::NOT_UNIQUE_EMAIL);
        }
        $faculty = $this->facultyRepository->findFacultyByName($request->get('faculty'));
        if ($faculty === null){
            return $this->returnError(500, UserErrorCodes::FACULTY_NOT_IN_DB);
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

    public function getAdmin($id)
    {
        $admin = $this->adminRepository->find($id);

        if($admin === null){
            return $this->returnError(500, UserErrorCodes::ADMIN_NOT_IN_DB);
        }

        return $this->returnSuccess([
            'admin' => $admin
        ]);
    }

    public function getAdmins($start = 0, $count = 20)
    {
        $admins  = $this->adminRepository->all($start, $count);

        return $this->returnSuccess($admins);
    }

    public function putEditAdmin(StandardRequest $request, $id)
    {
        /** @var  Admin $admin */
        $admin = $this->adminRepository->find($id);
        if($admin  === null){
            return $this->returnError(500, UserErrorCodes::ADMIN_NOT_IN_DB);
        }

        $email = new Email($request->get('email'));

        /** @var  User $user */
        $user = $this->userRepository->findByEmail($email);
        if ($user) {
            if ($user->getId() != $id) {
                return $this->returnError(500, UserErrorCodes::NOT_UNIQUE_EMAIL);
            }
        }

        $admin = new Admin();
        $admin->setFirstName($request->get('firstName'));
        $admin->setLastName($request->get('lastName'));
        $admin->setEmail($email);
        $admin->setPassword(new Password('password'));
        $admin->generateRegisterToken();
        $admin->setOrganisation($request->get('Faculty'));

        $this->adminRepository->update($admin);

        return $this->returnSuccess([
            'admin' => $admin
        ]);
    }

    public function deleteAdmin($id)
    {
        $admin = $this->adminRepository->find($id);
        if ($admin === null) {
            return $this->returnError(500, UserErrorCodes::ADMIN_NOT_IN_DB);
        }
        $this->adminRepository->destroy($admin);

        return $this->returnSuccess();
    }
}