<?php namespace StudentInfo\Repositories;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityRepository;

class DoctrinePollQuestionRepository extends EntityRepository implements PollQuestionRepositoryInterface
{

    public function create($object)
    {
        $this->_em->persist($object);
        $this->_em->flush($object);
    }

    public function all($faculty, $start = 0, $count = 20, array $options = [])
    {
        /** @var Collection $allQuestions */
        $qb = $this->_em->createQueryBuilder();
        $qb->select('pq')
            ->from('StudentInfo\Models\PollQuestion', 'pq')
            ->innerJoin('pq.faculties', 'f')
            ->where(':facultyId = f.id')
            ->andWhere('pq.active = 1')
        ->setParameter('facultyId', $faculty->getId());

        $allQuestions = $qb->getQuery()->getResult();

        return $allQuestions;
    }

    public function find($id)
    {
        return $this->_em->find('StudentInfo\Models\PollQuestion', $id);
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

    public function getAnswers($questionId)
    {
        return $query = $this->_em->createQuery('SELECT a FROM StudentInfo\Models\PollAnswer a
              WHERE a.question_id =:questionId')
            ->setParameter('questionId', $questionId)
            ->getResult();
    }
}