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
}