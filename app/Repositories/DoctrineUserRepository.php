<?php

namespace StudentInfo\Repositories;

use Doctrine\ORM\EntityRepository;

class DoctrineUserRepository extends EntityRepository implements UserRepositoryInterface
{
    public function create($object)
    {
        $this->_em->persist($object);
        $this->_em->flush();
    }

    public function all()
    {
        return $this->findAll();
    }

    public function destroy($ids)
    {
        // TODO
    }

    public function findByEmail($email)
    {
        return $this->createQueryBuilder('email')->select('SELECT * FROM users');
        return $this->findOneBy(['email' => $email]);
    }
}