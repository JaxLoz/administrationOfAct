<?php

namespace jwt;

class Jwt
{
    private string $key;
    public function __construct(string $key)
    {
        $this->key = $key;
    }

    private function base64UrlEncode(string $data): string
    {
        return str_replace(["+", "/", "="], ["-", "_", "", ""], base64_encode($data));
    }

    private function base64UrlDecode(string $data): string
    {
        return base64_decode(str_replace(["-", "_"], ["+", "/"], $data));
    }

    public function jwtEncode(array $payload): string
    {

        $header = json_encode([
            "alg" => "HS256",
            "type" => "JWT"
        ]);

        $header = $this->base64UrlEncode($header);
        $payload = $this->base64UrlEncode(json_encode($payload));

        $signature = hash_hmac("sha256", $header. "." .$payload, $this->key, true);
        $signature = $this->base64UrlEncode($signature);

        return $header.".".$payload.".".$signature;
    }

    public function jwtDecode(string $token): string
    {

        if( preg_match("/^(?<header>.+)\.(?<payload>.+)\.(?<signature>.+)$/", $token, $matches) !== 1){
            echo "Formato del token incorrecto";
        }

        // armamos el signature con los header y payload del token

        $signature = hash_hmac("sha256", $matches["header"]. "." . $matches["payload"], $this->key, true);

        // almacenamos el signature que vino con el token resivido (decodificamos)
        $signatureOfToken = $this->base64UrlDecode($matches["signature"]);

        // comparamos los dos signatures
        if(!hash_equals($signatureOfToken, $signature)){
            echo "Token incorrecto";
        }

        return json_decode($this->base64UrlDecode($matches["payload"]),true);
    }
}