<?php


namespace StudentInfo\Repositories;


use Doctrine\ORM\EntityRepository;

class DoctrineLectureRepository extends EntityRepository implements LectureRepositoryInterface
{

    public function getProfessor()
    {
        // TODO: Implement getProfessor() method.
    }

    public function getStudents()
    {
        // TODO: Implement getStudents() method.
    }

    public function getTime()
    {
        // TODO: Implement getTime() method.
    }

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
        $this->_em->flush($object);    }

    public function update($object)
    {
        $this->_em->flush($object);
    }
}