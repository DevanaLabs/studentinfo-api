<?php

namespace StudentInfo\Repositories;

use Doctrine\ORM\EntityRepository;

class DoctrineFacultyRepository extends EntityRepository implements FacultyRepositoryInterface
{
    public function create($object)
    {
        $this->_em->persist($object);
        $this->_em->flush($object);
    }

    public function all()
    {
        return $this->findAll();
    }

    public function find($id)
    {
        return $this->_em->find('StudentInfo\Models\Faculty', $id);
    }

    public function destroy($object)
    {
        $this->_em->remove($object);
        $this->_em->flush($object);
    }

    public function update($object)
    {
        $this->_em->flush($object);
    }

    public function findFacultyByName($name)
    {
        $query = $this->_em->createQuery('SELECT f FROM StudentInfo\Models\Faculty f WHERE f.name = :name');
        $query->setParameter('name', $name);
        return $query->getOneOrNullResult();
    }
}