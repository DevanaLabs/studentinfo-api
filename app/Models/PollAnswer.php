<?php namespace StudentInfo\Models;

use StudentInfo\ErrorCodes\PollErrorCodes;

class PollAnswer
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    private $text;

    /**
     * @var integer
     */
    private $voteCount;

    /**
     * @var PollQuestion
     */
    private $question;

    /**
     * PollAnswer constructor.
     *
     */
    public function __construct()
    {
        $this->voteCount = 0;
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
    public function setQuestion(PollQuestion $question)
    {
        $this->question = $question;
    }

    public function incrementVoteCount()
    {
        $this->voteCount++;
    }

    /**
     * @return int
     */
    public function getVoteCount()
    {
        return $this->voteCount;
    }

    /**
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @param string $text
     */
    public function setText($text)
    {
        $this->text = $text;
    }

    function __toString()
    {
        return 'ODGOVOR: '.$this->text;
    }

}