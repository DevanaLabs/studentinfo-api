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
        return $query = $this->_em->createQuery('SELECT u FROM StudentInfo\Models\User u')
            ->setFirstResult($start)
            ->setMaxResults($count)
            ->getArrayResult();
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
        return $this->_em->createQuery('SELECT u FROM StudentInfo\Models\User u WHERE u.email.email = :email')
            ->setParameter('email', $email->getEmail())
            ->getOneOrNullResult();
    }

    public function isAdmin($id)
    {
        return $this->_em->createQuery('SELECT u FROM StudentInfo\Models\Admin u WHERE u.id = :id')
            ->setParameter('id', $id)
            ->getOneOrNullResult() != null;
    }

    public function findByRegisterToken($registerToken)
    {
        return $this->_em->createQuery('SELECT u FROM StudentInfo\Models\User u WHERE u.registerToken = :registerToken')
            ->setParameter('registerToken', $registerToken)
            ->getOneOrNullResult();
    }
}