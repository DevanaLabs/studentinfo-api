<?php

namespace StudentInfo\Http\Controllers;


use StudentInfo\ErrorCodes\DeviceTokenErrorCodes;
use StudentInfo\ErrorCodes\UserErrorCodes;
use StudentInfo\Http\Requests\Create\CreateDeviceTokenRequest;
use StudentInfo\Http\Requests\Update\UpdateDeviceTokenRequest;
use StudentInfo\Jobs\SendNotification;
use StudentInfo\Models\DeviceToken;
use StudentInfo\Repositories\DeviceTokenRepositoryInterface;
use StudentInfo\Repositories\UserRepositoryInterface;

class DeviceTokenController extends ApiController
{
    /**
     * @var UserRepositoryInterface
     */
    protected $userRepositoryInterface;

    /**
     * @var DeviceTokenRepositoryInterface
     */
    protected $deviceTokenRepositoryInterface;

    /**
     * @param UserRepositoryInterface        $userRepositoryInterface
     * @param DeviceTokenRepositoryInterface $deviceTokenRepositoryInterface
     */
    public function __construct(UserRepositoryInterface $userRepositoryInterface, DeviceTokenRepositoryInterface $deviceTokenRepositoryInterface)
    {
        $this->userRepositoryInterface        = $userRepositoryInterface;
        $this->deviceTokenRepositoryInterface = $deviceTokenRepositoryInterface;
    }

    public function createDeviceToken(CreateDeviceTokenRequest $request)
    {
        $token  = $request->get('token');
        $userId = $request->get('userId');

        $user = $this->userRepositoryInterface->find($userId);
        if ($user === null) {
            return $this->returnError(500, UserErrorCodes::USER_DOES_NOT_EXIST);
        }
        $deviceToken = new DeviceToken();
        $deviceToken->setToken($token);
        $deviceToken->setUser($user);

        $notification = 'Hello world';
        $this->dispatch(new SendNotification($token, $notification));

        $this->deviceTokenRepositoryInterface->create($deviceToken);

        return $this->returnSuccess([
            'deviceToken' => $deviceToken,
        ]);
    }

    public function retrieveDeviceToken($id)
    {
        $deviceToken = $this->deviceTokenRepositoryInterface->find($id);

        if ($deviceToken === null) {
            return $this->returnError(500, DeviceTokenErrorCodes::DEVICE_TOKEN_DOES_NOT_EXIST);
        }

        return $this->returnSuccess([
            'deviceToken' => $deviceToken,
        ]);
    }

    public function retrieveDeviceTokens($start = 0, $count = 2000)
    {
        $deviceTokens = $this->deviceTokenRepositoryInterface->all(null, $start, $count);

        return $this->returnSuccess($deviceTokens);
    }

    public function updateDeviceToken(UpdateDeviceTokenRequest $request, $id)
    {
        /** @var  DeviceToken $deviceToken */

        $deviceToken = $this->deviceTokenRepositoryInterface->find($id);
        if ($deviceToken === null) {
            return $this->returnError(500, DeviceTokenErrorCodes::DEVICE_TOKEN_DOES_NOT_EXIST);
        }

        $deviceToken->setToken($request->get('token'));

        $this->deviceTokenRepositoryInterface->update($deviceToken);

        return $this->returnSuccess([
            'deviceToken' => $deviceToken,
        ]);
    }

    public function deleteDeviceToken($id)
    {
        $deviceToken = $this->deviceTokenRepositoryInterface->find($id);

        if ($deviceToken === null) {
            return $this->returnError(500, DeviceTokenErrorCodes::DEVICE_TOKEN_DOES_NOT_EXIST);
        }
        $this->deviceTokenRepositoryInterface->destroy($deviceToken);

        return $this->returnSuccess();
    }
}