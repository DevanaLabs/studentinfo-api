<?php


namespace StudentInfo\Repositories;


use DateTime;
use Doctrine\ORM\EntityRepository;

class DoctrineNotificationRepository extends EntityRepository implements NotificationRepositoryInterface
{


    public function create($object)
    {
        $this->_em->persist($object);
        $this->_em->flush($object);
    }

    public function all($faculty, $start = 0, $count = 20, array $options = [])
    {
        return $query = $this->_em->createQuery('SELECT n FROM StudentInfo\Models\Notification n, StudentInfo\Models\Faculty f
              WHERE n.organisation = f.id AND f.slug =:faculty')
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
        return $this->_em->find('StudentInfo\Models\Notification', $id);
    }

    public function getForInterval(DateTime $start, DateTime $end)
    {
        return $this->_em->createQuery('SELECT n FROM StudentInfo\Models\Notification n WHERE n.expiresAt BETWEEN :start AND :end ORDER BY n.expiresAt')
            ->setParameter('start', $start)
            ->setParameter('end', $end)
            ->getResult();
    }
}