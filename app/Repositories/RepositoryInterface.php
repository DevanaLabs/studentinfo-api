<?php

namespace StudentInfo\Repositories;

interface RepositoryInterface
{
    public function create($object);

    public function all($start = 0, $count = 20);

    public function find($id);

    public function destroy($object);

    public function update($object);

}