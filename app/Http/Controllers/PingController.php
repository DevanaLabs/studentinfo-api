<?php namespace StudentInfo\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use StudentInfo\Models\ActivityLog;
use StudentInfo\Repositories\ActivityLogRepositoryInterface;

class PingController extends ApiController
{
    /**
     * @var Guard
     */
    protected $guard;

    /**
     * @var ActivityLogRepositoryInterface
     */
    protected $activityLogRepository;

    /**
     * PingController constructor.
     *
     * @param Guard                         $guard
     * @param ActivityLogRepositoryInterface $activityLogRepository
     */
    public function __construct(Guard $guard, ActivityLogRepositoryInterface $activityLogRepository)
    {
        $this->guard                 = $guard;
        $this->activityLogRepository = $activityLogRepository;
    }

    public function ping(Request $request, $slug)
    {
        $time = Carbon::now();
        $sender = $slug;

        /** @var ActivityLog $activityLog */
        $activityLog = $this->activityLogRepository->findBySender($sender);
        if($activityLog != null) {
            $activityLog->setCreatedAt($time);
            $this->activityLogRepository->update($activityLog);

            return $this->returnSuccess([$activityLog]);
        }
        $activityLog = new ActivityLog();
        $activityLog->setCreatedAt($time);
        $activityLog->setSender($sender);

        $this->activityLogRepository->create($activityLog);

        $this->returnSuccess([$activityLog]);

    }


}