<?php


namespace StudentInfo\Http\Controllers;


use Illuminate\Contracts\Auth\Guard;
use StudentInfo\Http\Requests\AddImageRequest;
use StudentInfo\Http\Requests\SetLanguageRequest;
use StudentInfo\Models\Faculty;
use StudentInfo\Repositories\FacultyRepositoryInterface;

class SettingsController extends ApiController
{
    /**
     * @var Guard
     */
    protected $guard;

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
     * @param Guard                      $guard
     * @param FacultyRepositoryInterface $facultyRepository
     */
    public function __construct(Guard $guard, FacultyRepositoryInterface $facultyRepository)
    {
        $this->guard = $guard;
        $this->facultyRepository = $facultyRepository;
        $this->faculty = $this->facultyRepository->findFacultyByName($this->guard->user()->getOrganisation()->getName());
    }

    public function setWallpaper(AddImageRequest $request)
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

    public function setLanguage(SetLanguageRequest $request)
    {
        $this->faculty->getSettings()->setLanguage($request->get('language'));
        $this->facultyRepository->update($this->faculty);
        return $this->returnSuccess([
            'faculty' => $this->faculty,
        ]);
    }


}