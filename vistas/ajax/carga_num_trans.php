<?php
include 'is_logged.php'; //Archivo verifica que el usario que intenta acceder a la URL esta logueado
/* Connect To Database*/
require_once "../db.php";
require_once "../php_conexion.php";
$query_id = mysqli_query($conexion, "SELECT RIGHT(num_trans_factura,6) as trans FROM facturas_ventas
  ORDER BY trans DESC LIMIT 1")
or die('error ' . mysqli_error($conexion));
$count = mysqli_num_rows($query_id);

if ($count != 0) {

    $rw    = mysqli_fetch_assoc($query_id);
    $trans = $rw['trans'] + 1;
} else {
    $trans = 1;
}

$buat_id = str_pad($trans, 6, "0", STR_PAD_LEFT);
$trans   = "T$buat_id";

echo '<input type="hidden" class="form-control input-sm" autocomplete="off" id="trans" value="' . $trans . '" placeholder="trans" readonly name="trans" >';
