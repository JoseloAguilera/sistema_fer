<?php

/* Connect To Database*/
require_once "../db.php"; //Contiene las variables de configuracion para conectar a la base de datos
require_once "../php_conexion.php"; //Contiene funcion que conecta a la base de datos

$sql    = "SELECT id_medicamento, nombre_medicamento FROM medicamentos WHERE estado_medicamento = 1 order by nombre_medicamento";
$result = $conexion->query($sql);

$data = $result->fetch_all();

$conexion->close();

echo json_encode($data);
