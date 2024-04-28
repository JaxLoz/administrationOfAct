<?php

namespace view;

use util\HttpResponse;
require_once "util/HttpResponse.php";

class View
{

    private HttpResponse $httpResponse;

    public function __construct(){
        $this->httpResponse = new HttpResponse();
    }

    public function showResponse($data, $tableName, $action)
    {
        if($data == null || $data == 0){
            $response = [
                "status code" => 404,
                "message" => "No $tableName $action"
            ];
        }else{
            $response = [
                "status code" => 200,
                "message" => "$tableName $action",
                "data" => $data
            ];
        }

        $this->httpResponse->responseHttp($response['status code'], "Content-Type: application/json", $response);
    }

    public function showAlerts(string $message, int $code)
    {
        $response = [
            "status code" => $code,
            "message" => $message
        ];

        $this->httpResponse->responseHttp($response['status code'], "Content-Type: application/json", $response);
    }

}