<?php

namespace StudentInfo\Repositories;

use Doctrine\ORM\EntityRepository;
use StudentInfo\ValueObjects\Email;

class DoctrineUserRepository extends EntityRepository implements UserRepositoryInterface
{
    public function create($object)
    {
        $this->_em->persist($object);
        $this->_em->flush($object);
    }

    public function all($start = 0, $count = 20)
    {
        return $query = $this->_em->createQuery('SELECT u FROM StudentInfo\Models\User u')->setFirstResult($start)->setMaxResults($count)->getArrayResult();
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
        return $this->_em->find('StudentInfo\Models\User', $id);
    }

    public function findByEmail(Email $email)
    {
        $query = $this->_em->createQuery('SELECT u FROM StudentInfo\Models\User u WHERE u.email.email = :email');
        $query->setParameter('email', $email->getEmail());
        return $query->getOneOrNullResult();
    }

    public function isAdmin($id)
    {
        $query = $this->_em->createQuery('SELECT u FROM StudentInfo\Models\Admin u WHERE u.id = :id');
        $query->setParameter('id', $id);
        return $query->getOneOrNullResult() != null;
    }

    public function findByRegisterToken($registerToken)
    {
        $query = $this->_em->createQuery('SELECT u FROM StudentInfo\Models\User u WHERE u.registerToken = :registerToken');
        $query->setParameter('registerToken', $registerToken);
        return $query->getOneOrNullResult();
    }
}