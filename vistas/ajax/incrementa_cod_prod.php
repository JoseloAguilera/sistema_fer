<?php
include 'is_logged.php'; //Archivo verifica que el usario que intenta acceder a la URL esta logueado
/* Connect To Database*/
require_once "../db.php";
require_once "../php_conexion.php";
$query_id = mysqli_query($conexion, "SELECT RIGHT(codigo_producto,6) as codigo FROM productos
  ORDER BY codigo_producto DESC LIMIT 1")
or die('error ' . mysqli_error($conexion));
$count = mysqli_num_rows($query_id);

if ($count != 0) {

    $data_id = mysqli_fetch_assoc($query_id);
    //$codigo  = $data_id['codigo'] + 1;
    $codigo = 000;
} else {
    $codigo = 1;
}

$buat_id = str_pad($codigo, 5, STR_PAD_LEFT);
$codigo  = "$buat_id";

echo '<input type="text" class="form-control" autocomplete="off" id="codigo" value="' . $codigo . '" name="codigo" >';
?>