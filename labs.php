<?php
$array = [
    "salon" => "uno",
    "sala" => "dos",
    "colegio" => "tres",
    "nombre" => "cuatro"
];

$i = 1;

$keys = array_keys($array);

$cad = "";

foreach ($keys as $key) {
    $cad .= $key . " = ?,";
}

echo substr($cad, 0, -1);

//echo implode(" = ?, ", $keys);
