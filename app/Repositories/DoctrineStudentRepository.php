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

    public function persist($object)
    {
        $this->_em->persist($object);
    }

    public function flush()
    {
        $this->_em->flush();
    }

    public function all($faculty, $start = 0, $count = 20, array $options = [])
    {
        return $query = $this->_em->createQuery('SELECT s FROM StudentInfo\Models\Student s, StudentInfo\Models\Faculty f
              WHERE s.organisation = f.id AND f.slug =:faculty')
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

    public function find($id)
    {
        return $this->_em->find('StudentInfo\Models\Student', $id);
    }

    public function getAllStudentsForFaculty(Faculty $faculty, $start = 0, $count = 20)
    {
        return $this->_em->createQuery('SELECT s FROM StudentInfo\Models\Student s WHERE s.organisation = :faculty_id')
            ->setParameter('faculty_id', $faculty->getId())
            ->setFirstResult($start)
            ->setMaxResults($count)
            ->getResult();
    }

    public function findByIndexNumber($indexNumber)
    {
        return $this->_em->createQuery('SELECT s FROM StudentInfo\Models\Student s WHERE s.indexNumber = :index_number')
            ->setParameter('index_number', $indexNumber)
            ->getOneOrNullResult();
    }
}