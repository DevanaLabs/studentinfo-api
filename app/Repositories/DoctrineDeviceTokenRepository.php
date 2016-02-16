<?php

namespace StudentInfo\Repositories;


use Doctrine\ORM\EntityRepository;

class DoctrineDeviceTokenRepository extends EntityRepository implements DeviceTokenRepositoryInterface
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
        $this->flush();
    }

    public function all($faculty = null, $start = 0, $count = 20)
    {
        return $query = $this->_em->createQuery('SELECT d FROM StudentInfo\Models\DeviceToken d')
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

    public function findByDeviceToken($deviceToken)
    {
        return $this->_em->createQuery('SELECT d FROM StudentInfo\Models\DeviceToken d WHERE d.token = :deviceToken')
            ->setParameter('deviceToken', $deviceToken)
            ->getOneOrNullResult();
    }

    public function find($id)
    {
        return $this->_em->find('StudentInfo\Models\DeviceToken', $id);
    }
}