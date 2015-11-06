<?php

namespace StudentInfo\Repositories;

use Doctrine\ORM\EntityRepository;
use StudentInfo\ValueObjects\Email;
use StudentInfo\ValueObjects\Password;

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

    public function destroy($object)
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

    public function findByRegisterToken($registerToken)
    {
        $query = $this->_em->createQuery('SELECT u FROM StudentInfo\Models\User u WHERE u.registerToken = :registerToken');
        $query->setParameter('registerToken', $registerToken);
        return $query->getOneOrNullResult();
    }

    public function update($object)
    {
        $this->_em->flush($object);
    }

    public function findFacultyByName($name)
    {
        $query = $this->_em->createQuery('SELECT f FROM StudentInfo\Models\Faculty f WHERE f.name = :name');
        $query->setParameter('name', $name);
        return $query->getOneOrNullResult();
    }

    public function getAllStudents()
    {
        $query = $this->_em->createQuery('SELECT s FROM StudentInfo\Models\Student s ');
        return $query->getArrayResult();
    }

    public function findById($id)
    {
        return $this->findOneBy(array('id' => $id));
    }

}