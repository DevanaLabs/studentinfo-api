<?php

namespace StudentInfo\Repositories;

use Doctrine\ORM\EntityRepository;
use StudentInfo\Models\Faculty;

class DoctrineStudentRepository extends EntityRepository implements StudentRepositoryInterface
{
    public function create($object)
    {
        $this->_em->persist($object);
        $this->_em->flush($object);
    }

    public function all($start = 0, $count = 20)
    {
        return $query = $this->_em->createQuery('SELECT s FROM StudentInfo\Models\Student s')->setFirstResult($start)->setMaxResults($count)->getArrayResult();
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
        return $this->_em->find('StudentInfo\Models\Student', $id);
    }

    public function getAllStudentsForFaculty(Faculty $faculty, $start = 0, $count = 20)
    {
        $query = $this->_em->createQuery('SELECT s FROM StudentInfo\Models\Student s WHERE s.organisation = :faculty_id');
        $query->setParameter('faculty_id', $faculty->getId());
        return $query->setFirstResult($start)->setMaxResults($count)->getArrayResult();
    }

    public function findByIndexNumber($indexNumber)
    {
        $query = $this->_em->createQuery('SELECT s FROM StudentInfo\Models\Student s WHERE s.indexNumber = :index_number');
        $query->setParameter('index_number', $indexNumber);
        return $query->getOneOrNullResult();
    }
}