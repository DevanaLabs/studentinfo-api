<?php

namespace StudentInfo\Repositories;

interface RepositoryInterface
{
    public function create($object);

    public function all();

    public function find($id);

    public function destroy($ids);
}