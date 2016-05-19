<?php

namespace StudentInfo\Http\Controllers;

use LucaDegasperi\OAuth2Server\Authorizer;
use StudentInfo\Http\Requests\AddImageRequest;
use StudentInfo\Http\Requests\SetLanguageRequest;
use StudentInfo\Http\Requests\SetSemesterYearRequest;
use StudentInfo\Models\Faculty;
use StudentInfo\Repositories\FacultyRepositoryInterface;
use StudentInfo\Repositories\UserRepositoryInterface;

class SettingsController extends ApiController
{
    /**
     * @var UserRepositoryInterface
     */
    protected $userRepository;
    /**
     * @var Authorizer
     */
    protected $authorizer;

    /**
     * @var FacultyRepositoryInterface
     */
    protected $facultyRepository;

    /**
     * @var Faculty
     */
    protected $faculty;

    /**
     * SettingsController constructor.
     * @param UserRepositoryInterface $userRepository
     * @param Authorizer              $authorizer
     * @param FacultyRepositoryInterface $facultyRepository
     */
    public function __construct(UserRepositoryInterface $userRepository, Authorizer $authorizer, FacultyRepositoryInterface $facultyRepository)
    {
        $this->userRepository = $userRepository;
        $this->authorizer     = $authorizer;
        $this->facultyRepository = $facultyRepository;
        $this->faculty        = $this->userRepository->find($this->authorizer->getResourceOwnerId())->getOrganisation();
    }

    public function setWallpaper(AddImageRequest $request, $faculty)
    {
        $facultyName = $this->faculty->getName();
        $handle      = $request->file('import')->move('../settings/' . $facultyName . '/wallpaper', 'wallpaper.png');
        $file_path   = $handle->getPathname();

        $this->faculty->getSettings()->setWallpaperPath($file_path);
        $this->facultyRepository->update($this->faculty);

        return $this->returnSuccess([
            'faculty' => $this->faculty,
        ]);
    }

    public function setLanguage(SetLanguageRequest $request, $faculty)
    {
        $this->faculty->getSettings()->setLanguage($request->get('language'));
        $this->facultyRepository->update($this->faculty);

        return $this->returnSuccess([
            'faculty' => $this->faculty,
        ]);
    }

    public function setSemesterYear(SetSemesterYearRequest $request, $faculty)
    {
        $settings = $this->faculty->getSettings();
        $settings->setSemester($request->get('semester'));
        $settings->setYear($request->get('year'));
        $this->faculty->setSettings($settings);
        $this->facultyRepository->update($this->faculty);

        return $this->returnSuccess([
            'faculty' => $this->faculty,
        ]);
    }

    public function getSemesterYear($faculty)
    {
        return $this->returnSuccess([
            'faculty' => $this->faculty,
        ]);
    }
}