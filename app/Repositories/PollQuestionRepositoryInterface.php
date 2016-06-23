<?php

namespace StudentInfo\Repositories;


interface PollQuestionRepositoryInterface extends RepositoryInterface
{
    public function getAnswers($questionId);
}