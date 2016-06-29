<?php namespace StudentInfo\Repositories;

use Doctrine\ORM\EntityRepository;

class DoctrineVoterRepository extends EntityRepository implements VoterRepositoryInterface
{

    public function create($object)
    {
        $this->_em->persist($object);
        $this->_em->flush($object);
    }

    public function all($faculty, $start = 0, $count = 20, array $options = [])
    {
        return $query = $this->_em->createQuery('SELECT v FROM StudentInfo\Models\Voter v')
            ->setFirstResult($start)
//            ->setMaxResults($count)
            ->getResult();
    }

    public function find($id)
    {
        return $this->_em->find('StudentInfo\Models\Voter', $id);
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

    public function getVotersForQuestion($pollQuestionId)
    {
        return $query = $this->_em->createQuery('SELECT v FROM StudentInfo\Models\Voter v, StudentInfo\Models\PollQuestion pq
              WHERE v.question_id =:questionId')
            ->setParameter('questionId', $pollQuestionId)
            ->getResult();
    }
}