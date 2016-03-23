<?php

namespace StudentInfo\ValueObjects;


class Settings
{
    /**
     * @var string
     */
    protected $wallpaperPath;

    /**
     * @var string
     */
    protected $language;

    /**
     * @var int
     */
    protected $semester;

    /**
     * @var int
     */
    protected $year;

    /**
     * @return string
     */
    public function getWallpaperPath()
    {
        return $this->wallpaperPath;
    }

    /**
     * @param string $wallpaperPath
     */
    public function setWallpaperPath($wallpaperPath)
    {
        $this->wallpaperPath = $wallpaperPath;
    }

    /**
     * @return string
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * @param string $language
     */
    public function setLanguage($language)
    {
        $this->language = $language;
    }

    /**
     * @return int
     */
    public function getSemester()
    {
        return $this->semester;
    }

    /**
     * @param int $semester
     */
    public function setSemester($semester)
    {
        $this->semester = $semester;
    }

    /**
     * @return int
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * @param int $year
     */
    public function setYear($year)
    {
        $this->year = $year;
    }
}