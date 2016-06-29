<?php namespace StudentInfo\Http\Controllers;

use Carbon\Carbon;
use LucaDegasperi\OAuth2Server\Authorizer;
use StudentInfo\ErrorCodes\FacultyErrorCodes;
use StudentInfo\ErrorCodes\PollErrorCodes;
use StudentInfo\Http\Requests\Create\CreatePollRequest;
use StudentInfo\Http\Requests\StandardRequest;
use StudentInfo\Models\PollAnswer;
use StudentInfo\Models\PollQuestion;
use StudentInfo\Models\User;
use StudentInfo\Models\Voter;
use StudentInfo\Repositories\FacultyRepositoryInterface;
use StudentInfo\Repositories\PollAnswerRepositoryInterface;
use StudentInfo\Repositories\PollQuestionRepositoryInterface;
use StudentInfo\Repositories\UserRepositoryInterface;
use StudentInfo\Repositories\VoterRepositoryInterface;

class PollController extends ApiController
{
    /**
     * @var PollQuestionRepositoryInterface
     */
    private $pollQuestionRepository;

    /**
     * @var PollAnswerRepositoryInterface
     */
    private $pollAnswerRepository;

    /**
     * @var FacultyRepositoryInterface
     */
    private $facultyRepository;

    /**
     * @var UserRepositoryInterface
     */
    private $userRepository;

    /**
     * @var VoterRepositoryInterface
     */
    private $voterRepository;

    /**
     * @var Authorizer
     */
    private $authorizer;

    /**
     * PollController constructor.
     *
     * @param PollQuestionRepositoryInterface $pollQuestionRepository
     * @param PollAnswerRepositoryInterface   $pollAnswerRepository
     * @param FacultyRepositoryInterface      $facultyRepository
     * @param VoterRepositoryInterface        $voterRepository
     * @param Authorizer                      $authorizer
     * @param UserRepositoryInterface         $userRepository
     */
    public function __construct(PollQuestionRepositoryInterface $pollQuestionRepository, PollAnswerRepositoryInterface $pollAnswerRepository, FacultyRepositoryInterface $facultyRepository,
                                VoterRepositoryInterface $voterRepository, Authorizer $authorizer, UserRepositoryInterface $userRepository)
    {
        $this->pollQuestionRepository = $pollQuestionRepository;
        $this->pollAnswerRepository   = $pollAnswerRepository;
        $this->facultyRepository      = $facultyRepository;
        $this->authorizer             = $authorizer;
        $this->userRepository         = $userRepository;
        $this->voterRepository        = $voterRepository;

    }

    public function createPoll(CreatePollRequest $request)
    {
        //SuperAdmin will be able to make polls for more faculties
        // At the moment the admin adds poll for his own faculty
//        $facultyIds   = $request->get('faculties');
        $questionText = $request->get('question');
        $answerTexts  = $request->get('answers');

        $userId = $this->authorizer->getResourceOwnerId();
        /** @var User $user */
        $user = $this->userRepository->find($userId);

        $question = new PollQuestion();

//        foreach ($facultyIds as $facultyId) {
//            $faculty = $this->facultyRepository->find($facultyId);
//            if ($faculty != null) {
//                $faculties[] = $faculty;
//            }
//        }

        $question->setText($questionText);
        $question->setActive(true);
        $question->getFaculties()->add($user->getOrganisation());

        $this->pollQuestionRepository->create($question);

        foreach ($answerTexts as $answerText) {
            $answer = new PollAnswer();
            $answer->setText($answerText);
            $answer->setQuestion($question);
            $this->pollAnswerRepository->create($answer);
            $question->getAnswers()->add($answer);
        }

        return $this->returnSuccess([
            'question' => $question,
        ]);
    }

    public function retrievePoll($id)
    {
        $question = $this->pollQuestionRepository->find($id);
        if ($question) {
            return $this->returnSuccess([
                'question' => $question,
            ]);
        }

        return $this->returnError(500, PollErrorCodes::QUESTION_NOT_IN_DB);
    }

    public function retrievePolls($facultyId)
    {
        $faculty = $this->facultyRepository->find($facultyId);

        if ($faculty == null) {
            return $this->returnError(500, FacultyErrorCodes::FACULTY_NOT_IN_DB);
        }

        $questions = $this->pollQuestionRepository->all($faculty);

        return $this->returnSuccess($questions);
    }

    public function voteOnPoll(StandardRequest $request)
    {
        $answerId = $request->get('answer');

        /** @var PollAnswer $answer */
        $answer = $this->pollAnswerRepository->find($answerId);
        if ($answer == null) {
            return $this->returnError(500, PollErrorCodes::ANSWER_NOT_IN_DB);
        }
        $voter = new Voter();
        $voter->setAnswer($answer);
        $voter->setQuestion($answer->getQuestion());
        $voter->setCreatedAt(Carbon::now());
        $voter->setIpAddress($request->getClientIp());

        /** @var User $user */
        $user = $this->userRepository->find($this->authorizer->getResourceOwnerId());

        $voter->setVoterName($user->getEmail()->getEmail());
        $this->voterRepository->create($voter);

        $answer->incrementVoteCount();

        $this->pollAnswerRepository->update($answer);

        return $this->returnSuccess([
            'answer' => $answer,
            'voter' => $voter
        ]);
    }
}