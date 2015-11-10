<?php

namespace StudentInfo\Repositories;

use Doctrine\ORM\EntityRepository;

class DoctrineClassroomRepository extends EntityRepository implements ClassroomRepositoryInterface
{
    public function create($object)
    {
        $this->_em->persist($object);
        $this->_em->flush($object);
    }

    public function all()
    {
        return $query = $this->_em->createQuery('SELECT c FROM StudentInfo\Models\Classroom c')->getArrayResult();
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

    public function findByName($name)
    {
        $query = $this->_em->createQuery('SELECT c FROM StudentInfo\Models\Classroom c WHERE c.name = :name');
        $query->setParameter('name', $name);
        return $query->getOneOrNullResult();
    }

    public function find($id)
    {
        return $this->_em->find('StudentInfo\Models\Classroom', $id);
    }
}