<?php

if($_SERVER["REQUEST_METHOD"] === "POST"){

    $contenido = file_get_contents("php://input");

    $datos = json_decode($contenido, true);

    if(isset($datos)){
        $respuesta = array(
            "success" => true,
            "message" => "Los datos se han recibido correctamente.",
            "datos" => array(
                "nombre" => $datos["nombre"],
                "email" => $datos["email"]
            )
        );

        header("Content-Type: application/json");
        echo json_encode($respuesta);
    }

}