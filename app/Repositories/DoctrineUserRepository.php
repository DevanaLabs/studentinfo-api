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

    public function all()
    {
        return $this->findAll();
    }

    public function destroy($ids)
    {
        // TODO
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

    public function findByRememberToken($rememberToken)
    {
        $query = $this->_em->createQuery('SELECT u FROM StudentInfo\Models\User u WHERE u.rememberToken = :rememberToken');
        $query->setParameter('rememberToken', $rememberToken);
        return $query->getOneOrNullResult();
    }

    public function updatePassword($object)
    {
        $this->_em->flush($object);
    }
}