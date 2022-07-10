<?php
# conectare la base de datos
$conexion = @mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if (!$conexion) {
    die("imposible conectarse: " . mysqli_error($conexion));
}
if (@mysqli_connect_errno()) {
    die("Conexión falló: " . mysqli_connect_errno() . " : " . mysqli_connect_error());
}
date_default_timezone_set("America/El_Salvador");
mysqli_query($conexion, "SET NAMES utf8");
mysqli_query($conexion, "SET CHARACTER_SET utf");

function limpiar($tags)
{
    $tags = strip_tags($tags);
    return $tags;
}