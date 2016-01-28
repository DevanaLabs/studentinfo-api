<?php

namespace StudentInfo\Repositories;


use Doctrine\ORM\EntityRepository;

class DoctrineAdminRepository extends EntityRepository implements AdminRepositoryInterface
{
    public function create($object)
    {
        $this->_em->persist($object);
        $this->_em->flush($object);
    }

    public function all($faculty, $start = 0, $count = 20)
    {
        return $query = $this->_em->createQuery('SELECT a FROM StudentInfo\Models\Admin a')
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
        return $this->_em->find('StudentInfo\Models\Admin', $id);
    }
}