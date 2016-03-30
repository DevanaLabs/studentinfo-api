<?php

namespace StudentInfo\Jobs;

use Davibennun\LaravelPushNotification\Facades\PushNotification;
use Doctrine\Common\Collections\ArrayCollection;
use Illuminate\Contracts\Bus\SelfHandling;
use StudentInfo\Models\DeviceToken;

class SendNotification extends Job implements SelfHandling
{
    /**
     * @var ArrayCollection|DeviceToken[]
     */
    protected $deviceTokens;

    /**
     * @var String
     */
    protected $notification;

    /**
     * Create a new job instance.
     *
     * @param $deviceTokens
     * @param $notification
     */
    public function __construct($deviceTokens, $notification)
    {
        $this->deviceTokens = $deviceTokens;
        $this->notification = $notification;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        foreach ($this->deviceTokens as $deviceToken) {
            PushNotification::app('appNameAndroid')
                ->to($deviceToken->getToken())
                ->send($this->notification);
        }
    }
}
