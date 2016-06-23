<?php

namespace StudentInfo\Repositories;


interface PollAnswerRepositoryInterface
{
    public function create($object);

    public function all($question, $start = 0, $count = 20, array $options = []);

    public function find($id);

    public function destroy($object);

    public function update($object);
}