<?php
$array = [
    "salon" => "uno",
    "sala" => "dos",
    "colegio" => "tres",
    "nombre" => "cuatro",
    "auth" => [
        "ruta1" => "hola buenos dias",
        "ruta2" => "hasta luego"
    ],

    "WithOutAuth" => [
        "ruta3" => "hola buenos dias",
        "ruta4" => "hasta luego"
    ]

];
if(isset($array["WithOutAuth"]["ruta3"])){

}else{

 echo "No autenticarse";
}
$fecha = new DateTime('now', new DateTimeZone('America/Bogota'));
$array["fechaActual"] = $fecha->format("y-m-d H:i:s");

$fecha->add(new DateInterval('PT15M'));
$array["fechaExpiracion"] = $fecha->format("y-m-d H:i:s");

echo $array["fechaActual"]."\n";
echo $array["fechaExpiracion"]."\n";

if (strtotime($array["fechaExpiracion"]) > strtotime($array["fechaActual"])){
    echo "Aun no a expirado";
}else{
    echo "ya expiro";
}

echo file_get_contents("EmailConfig/HtmlTemplates/formatVerificationCode.html");

