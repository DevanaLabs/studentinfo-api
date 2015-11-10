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

    public function all()
    {
        $query = $this->_em->createQuery('SELECT s FROM StudentInfo\Models\Student s');
        return $query->getArrayResult();
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

    public function getAllStudentsForFaculty(Faculty $faculty)
    {
        $query = $this->_em->createQuery('SELECT s FROM StudentInfo\Models\Student s WHERE s.organisation = :faculty_id');
        $query->setParameter('faculty_id', $faculty->getId());
        return $query->getArrayResult();
    }
}