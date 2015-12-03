<?php


namespace StudentInfo\Http\Controllers;


use Illuminate\Contracts\Auth\Guard;
use StudentInfo\Http\Requests\AddImageRequest;

class SettingsController extends ApiController
{
    /**
     * @var Guard
     */
    protected $guard;

    /**
     * SettingsController constructor.
     * @param Guard $guard
     */
    public function __construct(Guard $guard)
    {
        $this->guard = $guard;
    }

    public function addImageForBackground(AddImageRequest $request)
    {
        $facultyName = $this->guard->user()->getOrganisation()->getName();
        $handle      = $request->file('import')->move('../settings/' . $facultyName . '/wallpaper');
        $file_path   = $handle->getPathname();

        return $this->returnSuccess([
            'path' => $file_path,
        ]);
    }


}