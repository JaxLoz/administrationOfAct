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
                "status_code" => 404,
                "data" => "No $tableName $action"
            ];
        }else{
            $response = [
                "status_code" => 200,
                "message" => "$tableName $action",
                "data" => $data
            ];
        }

        $this->httpResponse->responseHttp($response['status_code'], "Content-Type: application/json", $response);
    }

    public function showAlerts(string $message, int $code)
    {
        $response = [
            "status_code" => $code,
            "data" => $message
        ];

        $this->httpResponse->responseHttp($response['status_code'], "Content-Type: application/json", $response);
    }

}