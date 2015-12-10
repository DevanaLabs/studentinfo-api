<?php

namespace StudentInfo\Repositories;


use StudentInfo\Models\Faculty;

interface AssistantRepositoryInterface extends RepositoryInterface
{
    public function getAllAssistantsForFaculty(Faculty $faculty, $start = 0, $count = 20);
}