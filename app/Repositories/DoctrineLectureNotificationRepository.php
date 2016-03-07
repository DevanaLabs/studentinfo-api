<?php


namespace StudentInfo\Repositories;


use Doctrine\ORM\EntityRepository;

class DoctrineLectureNotificationRepository extends EntityRepository implements LectureNotificationRepositoryInterface
{

    public function find($id)
    {
        return $this->_em->find('StudentInfo\Models\LectureNotification', $id);
    }

    public function create($object)
    {
        $this->_em->persist($object);
        $this->_em->flush($object);
    }

    public function all($faculty, $start = 0, $count = 20, array $options = [])
    {
        return $query = $this->_em->createQuery('SELECT e FROM StudentInfo\Models\LectureNotification e, StudentInfo\Models\Faculty f
              WHERE e.organisation = f.id AND f.slug =:faculty')
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

    public function getForInterval($faculty, $startsAt, $endsAt)
    {
        // TODO: Implement getForInterval() method.
    }
}