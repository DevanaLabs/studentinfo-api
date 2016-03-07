<?php

namespace StudentInfo\Jobs;

use Davibennun\LaravelPushNotification\Facades\PushNotification;
use Illuminate\Contracts\Bus\SelfHandling;

class SendNotification extends Job implements SelfHandling
{
    /**
     * @var String
     */
    protected $deviceToken;

    /**
     * @var String
     */
    protected $notification;

    /**
     * Create a new job instance.
     *
     * @param $deviceToken
     * @param $notification
     */
    public function __construct($deviceToken, $notification)
    {
        $this->deviceToken  = $deviceToken;
        $this->notification = $notification;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        PushNotification::app('appNameAndroid')
            ->to('eOkIwhJpKAs:APA91bEWSYWBoMcITYEHC2MKfkaJiNxJpn1kKG5JfDcVOAzufhRqlVRF7nWxQ04prQ8sUilEYdMeL50VVWmja1wfUqut5nk3MpJ0lVGkS_f0TdfV5TS7LLcLgppAMIp20cLjElLHGd0z')
            ->send($this->notification);
    }
}
