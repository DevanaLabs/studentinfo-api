<?php

namespace StudentInfo\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller as BaseController;

class ApiController extends BaseController
{
    use DispatchesJobs;

    public function sendError($statusCode, $errorCode)
    {
        return new Response([
            'error' => [
                'errorCode' => $errorCode,
                'message'   => config("errorMessages.{$errorCode}"),
            ],
        ], $statusCode);
    }

    public function sendSuccess($data)
    {
        return new Response([
            'success' => [
                'data'    => $data,
                'message' => config("successMessages.{$data}"),
            ],
        ], 200);
    }

    public function sendForbidden($errorCode)
    {
        return $this->sendError(403, $errorCode);
    }


}
