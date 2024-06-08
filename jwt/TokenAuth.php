<?php

namespace jwt;

use Exception;
use InvalidArgumentException;

require_once "exceptions/InvalidSignatureException.php";
class TokenAuth
{

    private Jwt $jwt;

    public function __construct()
    {
        $this->jwt = new Jwt("oOZbafIovK6dbgmwllUO63j27fyercc/sTYEjD6eakGEdh+Fvj8g3LIsLQ/WyxTDboct+V8j67MPglpq7UfoSA==");
    }

    public function authenticationJWTToken($headerAuthorization): bool
    {
        if (!preg_match("/Bearer\s(\S+)/", $headerAuthorization, $matches)) {
            http_response_code(400);
            echo json_encode(["message" => "incomplete authorization header : $headerAuthorization"]);
            return false;
        }

        try {
            $data = $this->jwt->jwtDecode($matches[1]);
        } catch (InvalidArgumentException $e) {
            http_response_code(401);
            echo json_encode(["message" => "Invalid signature"]);
            return false;
        } catch (Exception $e){
            http_response_code(400);
            echo json_encode(["message" => $e->getMessage()]);
            return false;
        }
        return true;
    }
}