<?php

namespace StudentInfo\Repositories;


interface VoterRepositoryInterface extends RepositoryInterface
{
    public function getVotersForQuestion($pollQuestionId);
}