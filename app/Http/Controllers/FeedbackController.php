<?php

namespace StudentInfo\Http\Controllers;


use Illuminate\Contracts\Auth\Guard;
use StudentInfo\ErrorCodes\FeedbackErrorCodes;
use StudentInfo\Http\Requests\Create\CreateFeedbackRequest;
use StudentInfo\Http\Requests\Update\UpdateFeedbackRequest;
use StudentInfo\Models\Feedback;
use StudentInfo\Repositories\FeedbackRepositoryInterface;

class FeedbackController extends ApiController
{
    /**
     * @var FeedbackRepositoryInterface
     */
    protected $feedbackRepository;

    /**
     * @var Guard
     */
    protected $guard;

    /**
     * FacultyController constructor.
     * @param FeedbackRepositoryInterface $feedbackRepository
     * @param Guard                       $guard
     */
    public function __construct(FeedbackRepositoryInterface $feedbackRepository, Guard $guard)
    {
        $this->feedbackRepository = $feedbackRepository;
        $this->guard              = $guard;
    }

    public function createFeedback(CreateFeedbackRequest $request)
    {
        $feedback = new Feedback();
        $feedback->setText($request->get('text'));

        $this->feedbackRepository->create($feedback);

        return $this->returnSuccess([
            'feedback' => $feedback,
        ]);
    }

    public function retrieveFeedback($faculty, $id)
    {
        $feedback = $this->feedbackRepository->find($id);

        if ($feedback === null) {
            return $this->returnError(500, FeedbackErrorCodes::FEEDBACK_NOT_IN_DB);
        }

        if ($feedback->getOrganisation()->getSlug() != $faculty) {
            return $this->returnError(500, FeedbackErrorCodes::FEEDBACK_DOES_NOT_BELONG_TO_THIS_FACULTY);
        }

        return $this->returnSuccess([
            'feedback' => $feedback,
        ]);
    }

    public function retrieveFeedbacks($faculty, $start = 0, $count = 2000)
    {
        $faculty = $this->feedbackRepository->all($faculty, $start, $count);

        return $this->returnSuccess($faculty);
    }

    public function updateFeedback(UpdateFeedbackRequest $request, $id)
    {
        if ($this->feedbackRepository->find($id) === null) {
            return $this->returnError(500, FeedbackErrorCodes::FEEDBACK_NOT_IN_DB);
        }

        /** @var  Feedback $feedback */
        $feedback = $this->feedbackRepository->find($id);

        $feedback->setText($request->get('text'));

        $this->feedbackRepository->update($feedback);


        return $this->returnSuccess([
            'feedback' => $feedback,
        ]);
    }

    public function deleteFeedback($id)
    {
        $feedback = $this->feedbackRepository->find($id);

        if ($feedback === null) {
            return $this->returnError(500, FeedbackErrorCodes::FEEDBACK_NOT_IN_DB);
        }

        $this->feedbackRepository->destroy($feedback);

        return $this->returnSuccess();
    }
}