<?php

namespace StudentInfo\Repositories;


use Doctrine\ORM\EntityRepository;

class DoctrineGroupRepository extends EntityRepository implements GroupRepositoryInterface
{

    public function create($object)
    {
        $this->_em->persist($object);
        $this->_em->flush($object);
    }

    public function all($faculty, $start = 0, $count = 20, array $options = [])
    {
        return $query = $this->_em->createQuery('SELECT g FROM StudentInfo\Models\Group g, StudentInfo\Models\Faculty f
              WHERE g.organisation = f.id AND f.slug =:faculty')
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
        return $this->_em->find('StudentInfo\Models\Group', $id);
    }

    public function findByName($name, $faculty)
    {
        return $this->_em->createQuery('SELECT g FROM StudentInfo\Models\Group g, StudentInfo\Models\Faculty f
              WHERE c.organisation = f.id AND f.slug =:faculty AND g.name = :name')
            ->setParameter('faculty', $faculty)
            ->setParameter('name', $name)
            ->getOneOrNullResult();
    }

}