<?php

namespace StudentInfo\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use StudentInfo\Jobs\SendNotification;

class PushNotificationController extends ApiController
{
    use DispatchesJobs;

    public function pushNotification()
    {
        $notification = 'Hello world';
        $deviceToken  = '';
        $this->dispatch(new SendNotification($deviceToken, $notification));
    }
}