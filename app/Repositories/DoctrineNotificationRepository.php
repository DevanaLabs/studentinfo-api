<?php


namespace StudentInfo\Repositories;


use Carbon\Carbon;
use Doctrine\ORM\EntityRepository;

class DoctrineNotificationRepository extends EntityRepository implements NotificationRepositoryInterface
{


    public function create($object)
    {
        $this->_em->persist($object);
        $this->_em->flush($object);
    }

    public function all($start = 0, $count = 20)
    {
        return $query = $this->_em->createQuery('SELECT n FROM StudentInfo\Models\Notification n')->setFirstResult($start)->setMaxResults($count)->getArrayResult();
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

    public function getForInterval(Carbon $start, Carbon $end)
    {
        $query = $this->_em->createQuery('SELECT n FROM StudentInfo\Models\Notification n
                  WHERE n.expiresAt BETWEEN :start AND :end ORDER BY n.expiresAt');
        $query->setParameter('start', $start);
        $query->setParameter('end', $end);
        return $query->getArrayResult();
    }
}