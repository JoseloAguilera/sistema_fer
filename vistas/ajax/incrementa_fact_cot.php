<?php
include 'is_logged.php'; //Archivo verifica que el usario que intenta acceder a la URL esta logueado
/* Connect To Database*/
require_once "../db.php";
require_once "../php_conexion.php";
$query_id = mysqli_query($conexion, "SELECT RIGHT(numero_factura,6) as factura FROM facturas_cot
  ORDER BY factura DESC LIMIT 1")
or die('error ' . mysqli_error($conexion));
$count = mysqli_num_rows($query_id);

if ($count != 0) {

    $data_id = mysqli_fetch_assoc($query_id);
    $factura = $data_id['factura'] + 1;
} else {
    $factura = 1;
}

$buat_id = str_pad($factura, 6, "0", STR_PAD_LEFT);
$factura = "COT-$buat_id";

echo '<input type="text" class="form-control" autocomplete="off" id="factura" value="' . $factura . '" placeholder="Factura" readonly name="factura" >';
