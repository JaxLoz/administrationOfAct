<?php

namespace util;

class HttpResponse
{

    public function responseHttp(int $Statuscode, string $header, $data)
    {
        http_response_code($Statuscode);
        header($header);
        echo json_encode($data);
    }

}