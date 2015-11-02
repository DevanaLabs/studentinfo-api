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
}