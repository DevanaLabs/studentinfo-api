<?php


namespace StudentInfo\Repositories;


use Doctrine\ORM\EntityRepository;

class DoctrineEventRepository extends EntityRepository implements EventRepositoryInterface
{

    public function find($id)
    {
        return $this->_em->find('StudentInfo\Models\Event', $id);
    }

    public function create($object)
    {
        $this->_em->persist($object);
        $this->_em->flush($object);
    }

    public function all()
    {
        return $query = $this->_em->createQuery('SELECT e FROM StudentInfo\Models\Event e')->getArrayResult();
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