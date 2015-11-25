<?php

namespace StudentInfo\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller as BaseController;
use JMS\Serializer\SerializerBuilder;

class ApiController extends BaseController
{
    use DispatchesJobs;

    public function returnSuccess(array $data = [])
    {
        $serializer = SerializerBuilder::create()
            ->addMetadataDir(base_path() . '/serializations/')
            ->build();
        $jsonData   = $serializer->serialize($data, 'json');
        return new Response([
            'success' => [
                'data' => $jsonData,
            ],
        ], 200);
    }

    public function returnForbidden($errorCode)
    {
        return $this->returnError(403, $errorCode);
    }

    public function returnError($statusCode, $errorCode)
    {
        return new Response([
            'error' => [
                'errorCode' => $errorCode,
                'message'   => config("errorMessages.{$errorCode}"),
            ],
        ], $statusCode);
    }


}
