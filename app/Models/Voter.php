<?php namespace StudentInfo\Models;

class Voter
{
    private $id;

    /**
     * @var PollQuestion
     */
    private $question;

    /**
     * @var PollAnswer
     */
    private $answer;

    private $voterName;

    private $ipAddress;

    private $created_at;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return PollQuestion
     */
    public function getQuestion()
    {
        return $this->question;
    }

    /**
     * @param PollQuestion $question
     */
    public function setQuestion($question)
    {
        $this->question = $question;
    }

    /**
     * @return PollAnswer
     */
    public function getAnswer()
    {
        return $this->answer;
    }

    /**
     * @param PollAnswer $answer
     */
    public function setAnswer($answer)
    {
        $this->answer = $answer;
    }

    /**
     * @return mixed
     */
    public function getVoterName()
    {
        return $this->voterName;
    }

    /**
     * @param mixed $voterName
     */
    public function setVoterName($voterName)
    {
        $this->voterName = $voterName;
    }

    /**
     * @return mixed
     */
    public function getIpAddress()
    {
        return $this->ipAddress;
    }

    /**
     * @param mixed $ipAddress
     */
    public function setIpAddress($ipAddress)
    {
        $this->ipAddress = $ipAddress;
    }

    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * @param mixed $created_at
     */
    public function setCreatedAt($created_at)
    {
        $this->created_at = $created_at;
    }

}