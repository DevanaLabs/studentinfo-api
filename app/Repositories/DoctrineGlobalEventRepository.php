<?php

namespace StudentInfo\Repositories;


use Doctrine\ORM\EntityRepository;

class DoctrineGlobalEventRepository extends EntityRepository implements GlobalEventRepositoryInterface
{
    public function create($object)
    {
        $this->_em->persist($object);
        $this->_em->flush($object);
    }

    public function all($start = 0, $count = 20)
    {
        return $query = $this->_em->createQuery('SELECT g FROM StudentInfo\Models\GlobalEvent g')
            ->setFirstResult($start)
            ->setMaxResults($count)
            ->getResult();
    }

    public function find($id)
    {
        return $this->_em->find('StudentInfo\Models\GlobalEvent', $id);
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
}