<?php


namespace StudentInfo\Repositories;


use Doctrine\ORM\EntityRepository;

class DoctrineLectureRepository extends EntityRepository implements LectureRepositoryInterface
{
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
        return $query = $this->_em->createQuery('SELECT l FROM StudentInfo\Models\Lecture l, StudentInfo\Models\Faculty f,
              StudentInfo\Models\Course c WHERE l.course = c.id AND c.organisation = f.id AND f.slug =:faculty')
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
        return $this->_em->find('StudentInfo\Models\Lecture', $id);
    }
}