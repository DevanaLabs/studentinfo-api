<?php


namespace StudentInfo\Repositories;


use Doctrine\ORM\EntityRepository;

class DoctrineCourseRepository extends EntityRepository implements CourseRepositoryInterface
{

    public function getAllStudentsListening($courseId)
    {
        //TODO: Finish the query
        $query = $this->_em->createQuery('SELECT s FROM StudentInfo\Models\Student s,
        StudentInfo\Models\Course c WHERE c.id = :course_id');
        $query->setParameter('course_id', $courseId);
        return $query->getArrayResult();
    }

    public function getAllProfessorsTeaching($courseId)
    {
        // TODO: Implement getAllProfessorsTeaching() method.
    }

    public function create($object)
    {
        $this->_em->persist($object);
        $this->_em->flush($object);
    }

    public function all()
    {
        return $query = $this->_em->createQuery('SELECT c FROM StudentInfo\Models\Course c')->getArrayResult();
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
        return $this->_em->find('StudentInfo\Models\Course', $id);
    }

    public function findByCode($code)
    {
        $query = $this->_em->createQuery('SELECT c FROM StudentInfo\Models\Course c WHERE c.code = :code');
        $query->setParameter('code', $code);
        return $query->getOneOrNullResult();
    }
}