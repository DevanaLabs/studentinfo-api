<?php

namespace StudentInfo\Repositories;


use Doctrine\ORM\EntityRepository;

class DoctrineTeacherRepository extends EntityRepository implements TeacherRepositoryInterface
{
    public function create($object)
    {
        $this->_em->persist($object);
        $this->_em->flush($object);
    }

    public function all($start = 0, $count = 20)
    {
        return $query = $this->_em->createQuery('SELECT t FROM StudentInfo\Models\Teacher t')
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
        return $this->_em->find('StudentInfo\Models\Teacher', $id);
    }

    public function findByName($firstName, $lastName)
    {
        return $this->_em->createQuery('SELECT t FROM StudentInfo\Models\Teacher t WHERE t.firstName = :firstName and t.lastName = :lastName')
            ->setParameter('firstName', $firstName)
            ->setParameter('lastName', $lastName)
            ->getOneOrNullResult();
    }
}