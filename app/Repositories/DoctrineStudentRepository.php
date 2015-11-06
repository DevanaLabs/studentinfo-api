<?php

namespace StudentInfo\Repositories;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityRepository;
use StudentInfo\Models\Faculty;
use StudentInfo\ValueObjects\Email;
use StudentInfo\ValueObjects\Password;

class DoctrineStudentRepository extends EntityRepository implements StudentRepositoryInterface
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
        $this->_em->remove($object);
        $this->_em->flush($object);
    }

    public function update($object)
    {
        $this->_em->flush($object);
    }

    /**
     * @param $faculty Faculty
     */
    public function getAllStudentsForFaculty($faculty)
    {
        // TODO : Exctract real data
        return new ArrayCollection();
    }
}