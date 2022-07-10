<?php
include 'is_logged.php'; //Archivo verifica que el usario que intenta acceder a la URL esta logueado
/* Connect To Database*/
require_once "../db.php";
require_once "../php_conexion.php";
$user_id = $_SESSION['id_users'];
//Archivo de funciones PHP
require_once "../funciones.php";
$id_moneda    = get_row('perfil', 'moneda', 'id_perfil', 1);
$fecha_actual = date('Y-m-d');
//---------------------------------------------------------------------------------------
$abonoSql    = "SELECT * FROM creditos_abonos where date(fecha_abono) = '$fecha_actual'";
$abonoQuery  = $conexion->query($abonoSql);
$total_abono = 0;
while ($abonoResult = $abonoQuery->fetch_assoc()) {
    $total_abono += $abonoResult['abono'];
}
//---------------------------------------------------------------------------------------
$orderSql     = "SELECT * FROM facturas_ventas WHERE DATE(fecha_factura)='$fecha_actual' and id_users_factura='$user_id' and condiciones=1";
$orderQuery   = $conexion->query($orderSql);
$totalRevenue = 0;
while ($orderResult = $orderQuery->fetch_assoc()) {
    $totalRevenue += $orderResult['monto_factura'];
}
echo '' . $id_moneda . ' ' . number_format($totalRevenue + $total_abono, 2) . '';
