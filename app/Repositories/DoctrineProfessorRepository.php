<?php

namespace StudentInfo\Repositories;

use Doctrine\ORM\EntityRepository;
use StudentInfo\Models\Faculty;

class DoctrineProfessorRepository extends EntityRepository implements ProfessorRepositoryInterface {

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
        return $query = $this->_em->createQuery('SELECT p FROM StudentInfo\Models\Professor p, StudentInfo\Models\Faculty f
              WHERE p.organisation = f.id AND f.slug =:faculty')
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
        return $this->_em->find('StudentInfo\Models\Professor', $id);
    }

    public function findByName($firstName, $lastName)
    {
        return $this->_em->createQuery('SELECT p FROM StudentInfo\Models\Professor p WHERE p.firstName = :firstName and p.lastName = :lastName')
            ->setParameter('firstName', $firstName)
            ->setParameter('lastName', $lastName)
            ->getOneOrNullResult();
    }

    public function getAllProfessorForFaculty(Faculty $faculty, $start = 0, $count = 20)
    {
        return $this->_em->createQuery('SELECT p FROM StudentInfo\Models\Professor p WHERE p.organisation = :faculty_id')
            ->setParameter('faculty_id', $faculty->getId())
            ->setFirstResult($start)
            ->setMaxResults($count)
            ->getResult();
    }
}