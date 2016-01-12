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

    public function all($faculty, $start = 0, $count = 20)
    {
        return $query = $this->_em->createQuery('SELECT c FROM StudentInfo\Models\Classroom c, StudentInfo\Models\Faculty f
              WHERE c.organisation = f.id AND f.slug =:faculty')
            ->setParameter('faculty', $faculty)
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

    public function findByName($name)
    {
        return $this->_em->createQuery('SELECT c FROM StudentInfo\Models\Classroom c WHERE c.name = :name')
            ->setParameter('name', $name)
            ->getOneOrNullResult();
    }

    public function find($id)
    {
        return $this->_em->find('StudentInfo\Models\Classroom', $id);
    }
}