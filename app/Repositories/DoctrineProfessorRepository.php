<?php

namespace StudentInfo\Repositories;

use Doctrine\ORM\EntityRepository;

class DoctrineProfessorRepository extends EntityRepository implements ProfessorRepositoryInterface {

    public function create($object)
    {
        $this->_em->persist($object);
        $this->_em->flush($object);
    }

    public function all()
    {
        return $query = $this->_em->createQuery('SELECT p FROM StudentInfo\Models\Professor p')->getArrayResult();
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
        $query = $this->_em->createQuery('SELECT p FROM StudentInfo\Models\Professor p WHERE p.firstName = :firstName and p.lastName = :lastName');
        $query->setParameter('firstName', $firstName);
        $query->setParameter('lastName', $lastName);
        return $query->getOneOrNullResult();
    }
}