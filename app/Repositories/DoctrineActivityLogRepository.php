<?php namespace StudentInfo\Repositories;

use Carbon\Carbon;
use Doctrine\ORM\EntityRepository;

class DoctrineActivityLogRepository extends EntityRepository implements ActivityLogRepositoryInterface
{
    public function create($object)
    {
        $this->_em->persist($object);
        $this->_em->flush($object);
    }

    public function all($faculty, $start = 0, $count = 20, array $options = [])
    {
        return $query = $this->_em->createQuery('SELECT a FROM StudentInfo\Models\ActivityLog a')
            ->setFirstResult($start)
            ->setMaxResults($count)
            ->getResult();
    }

    public function find($id)
    {
        return $this->_em->find('StudentInfo\Models\ActivityLog', $id);
    }

    public function destroy($object)
    {
        $this->_em->remove($object);
        $this->_em->persist($object);
        $this->_em->flush($object);
    }

    public function update($object)
    {
        $this->_em->persist($object);
        $this->_em->flush($object);
    }

    public function getInactiveFor($minutes)
    {
        $time = Carbon::now()->subMinutes($minutes);
        return $query = $this->_em->createQuery('SELECT a FROM StudentInfo\Models\ActivityLog a WHERE a.created_at <:time')
            ->setParameter('time', $time)
            ->getResult();
    }

    public function findBySender($sender)
    {
        return $query = $this->_em->createQuery('SELECT a FROM StudentInfo\Models\ActivityLog a WHERE a.sender =:sender')
            ->setParameter('sender', $sender)
            ->getOneOrNullResult();
    }
}