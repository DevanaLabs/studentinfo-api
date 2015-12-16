<?php

namespace StudentInfo\Repositories;


use Doctrine\ORM\EntityRepository;

class DoctrineGroupRepository extends EntityRepository implements GroupRepositoryInterface
{

    public function create($object)
    {
        $this->_em->persist($object);
        $this->_em->flush($object);
    }

    public function all($start = 0, $count = 20)
    {
        return $query = $this->_em->createQuery('SELECT g FROM StudentInfo\Models\Group g')
            ->setFirstResult($start)
            ->setMaxResults($count)
            ->getResult();
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

    public function find($id)
    {
        return $this->_em->find('StudentInfo\Models\Group', $id);
    }

    public function findByName($name)
    {
        return $this->_em->createQuery('SELECT g FROM StudentInfo\Models\Group g WHERE g.name = :name')
            ->setParameter('name', $name)
            ->getOneOrNullResult();
    }

    public function getAllYears()
    {
        return $query = $this->_em->createQuery('SELECT DISTINCT g.year FROM StudentInfo\Models\Group g')->getArrayResult();
    }

    public function getAllGroups($year)
    {
        return $this->_em->createQuery('SELECT g.name FROM StudentInfo\Models\Group g WHERE g.year =:year')
            ->setParameter('year', $year)
            ->getResult();
    }
}