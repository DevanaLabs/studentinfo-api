<?php

namespace StudentInfo\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use StudentInfo\ErrorCodes\DeviceTokenErrorCodes;
use StudentInfo\Http\Requests\Create\CreatePushNotificationRequest;
use StudentInfo\Jobs\SendNotification;
use StudentInfo\Models\DeviceToken;
use StudentInfo\Repositories\DeviceTokenRepositoryInterface;

class PushNotificationController extends ApiController
{
    use DispatchesJobs;

    public function pushNotification(CreatePushNotificationRequest $request, DeviceTokenRepositoryInterface $deviceTokenRepository)
    {
        /** @var DeviceToken $deviceToken */
        $deviceToken = $deviceTokenRepository->find($request->get('id'));
        if ($deviceToken === null) {
            return $this->returnError(500, DeviceTokenErrorCodes::DEVICE_TOKEN_DOES_NOT_EXIST);
        }
        $notification = $request->get('message');
        $this->dispatch(new SendNotification($deviceToken->getToken(), $notification));

        return $this->returnSuccess();
    }
}