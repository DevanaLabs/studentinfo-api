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

    public function persist($object)
    {
        $this->_em->persist($object);
    }

    public function flush()
    {
        $this->_em->flush();
    }

    public function all($faculty, $start = 0, $count = 20)
    {
        return $query = $this->_em->createQuery('SELECT c FROM StudentInfo\Models\Course c, StudentInfo\Models\Faculty f
              WHERE c.organisation = f.id AND f.slug =:faculty')
            ->setParameter('faculty', $faculty)
            ->setFirstResult($start)
            ->setMaxResults($count)
            ->getResult();
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
        return $this->_em->createQuery('SELECT c FROM StudentInfo\Models\Course c WHERE c.code = :code')
            ->setParameter('code', $code)
            ->getOneOrNullResult();
    }

    public function findByName($name)
    {
        return $this->_em->createQuery('SELECT c FROM StudentInfo\Models\Course c WHERE c.name = :name')
            ->setParameter('name', $name)
            ->getOneOrNullResult();
    }
}