<?php

namespace StudentInfo\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller as BaseController;

class ApiController extends BaseController
{
    use DispatchesJobs;

    public function returnError($statusCode, $errorCode)
    {
        return new Response([
            'error' => [
                'errorCode' => $errorCode,
                'message'   => config("errorMessages.{$errorCode}"),
            ],
        ], $statusCode);
    }

    public function returnSuccess(array $data = [])
    {
        return new Response([
            'success' => [
                'data' => $data
            ],
        ], 200);
    }

    public function returnForbidden($errorCode)
    {
        return $this->returnError(403, $errorCode);
    }


}
