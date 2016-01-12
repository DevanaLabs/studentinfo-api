<?php

namespace StudentInfo\Http\Controllers;


error_reporting(E_ALL);
ini_set('display_errors', 1);


use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller as BaseController;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\SerializerBuilder;

class ApiController extends BaseController
{
    use DispatchesJobs;

    public function returnSuccess(array $data = [], array $options = [])
    {
        $serializer = SerializerBuilder::create()
            ->addMetadataDir(base_path() . '/serializations/')
            ->build();
        $responseData = [
            'success' => [
                'data' => $data,
            ],
        ];
        $jsonData = null;
        if ((count($options) > 0) and ($options['display'] === 'limited')) {
            $jsonData = $serializer->serialize($responseData, 'json', SerializationContext::create()->enableMaxDepthChecks()->setGroups(array('limited')));
        } else {
            $jsonData = $serializer->serialize($responseData, 'json', SerializationContext::create()->enableMaxDepthChecks()->setGroups(array('all')));
        }
        $response = new Response($jsonData, 200);

        $response->header('Content-Type', 'application/json');

        return $response;
    }

    public function returnForbidden($errorCode)
    {
        return $this->returnError(403, $errorCode);
    }

    public function returnError($statusCode, $errorCode)
    {
        $response = new Response([
            'error' => [
                'errorCode' => $errorCode,
                'message'   => config("errorMessages.{$errorCode}"),
            ],
        ], $statusCode);

        $response->header('Content-Type', 'application/json');

        return $response;
    }


}
