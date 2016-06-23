<?php namespace StudentInfo\Repositories;

use Doctrine\ORM\EntityRepository;

class DoctrinePollAnswerRepository extends EntityRepository implements PollAnswerRepositoryInterface
{

    public function create($object)
    {
        $this->_em->persist($object);
        $this->_em->flush($object);
    }

    public function all($questionId, $start = 0, $count = 20, array $options = [])
    {
        return $query = $this->_em->createQuery('SELECT a FROM StudentInfo\Models\PollAnswer a
              WHERE a.question_id =:questionId')
            ->setParameter('questionId', $questionId)
            ->setFirstResult($start)
            ->setMaxResults($count)
            ->getResult();
    }

    public function find($id)
    {
        return $this->_em->find('StudentInfo\Models\PollAnswer', $id);
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