<?php namespace StudentInfo\Http\Controllers;

use StudentInfo\Models\Faculty;
use StudentInfo\Repositories\VoterRepositoryInterface;

class VoterController extends ApiController
{
    /**
     * @var VoterRepositoryInterface
     */
    private $voterRepository;

    /**
     * VoterController constructor.
     *
     * @param VoterRepositoryInterface $voterRepository
     */
    public function __construct(VoterRepositoryInterface $voterRepository)
    {
        $this->voterRepository = $voterRepository;
    }


    public function getAllVoters()
    {
        $allVoters = $this->voterRepository->all(new Faculty());

        return $this->returnSuccess([
            'voters' => $allVoters
        ]);
    }
}