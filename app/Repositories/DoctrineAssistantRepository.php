<?php

namespace StudentInfo\Repositories;

use Doctrine\ORM\EntityRepository;
use StudentInfo\Models\Faculty;

class DoctrineAssistantRepository extends EntityRepository implements AssistantRepositoryInterface
{
    public function create($object)
    {
        $this->_em->persist($object);
        $this->_em->flush($object);
    }

    public function all($start = 0, $count = 20)
    {
        return $query = $this->_em->createQuery('SELECT a FROM StudentInfo\Models\Assistant a')
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
        return $this->_em->find('StudentInfo\Models\Assistant', $id);
    }

    public function getAllAssistantsForFaculty(Faculty $faculty, $start = 0, $count = 20)
    {
        return $this->_em->createQuery('SELECT a FROM StudentInfo\Models\Assistant a WHERE a.organisation = :faculty_id')
            ->setParameter('faculty_id', $faculty->getId())
            ->setFirstResult($start)
            ->setMaxResults($count)
            ->getResult();
    }
}