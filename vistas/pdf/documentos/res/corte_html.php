<style type="text/css">
    <!--
    table { vertical-align: top; }
    tr    { vertical-align: top; }
    td    { vertical-align: top; }
    .midnight-blue{
        background:#2c3e50;
        padding: 4px 4px 4px;
        color:white;
        font-weight:bold;
        font-size:14px;
    }
    .silver{
        background:white;
        padding: 3px 4px 3px;
    }
    .clouds{
        background:#ecf0f1;
        padding: 3px 4px 3px;
    }
    .border-top{
        border-top: solid 1px #bdc3c7;

    }
    .border-left{
        border-left: solid 1px #bdc3c7;
    }
    .border-right{
        border-right: solid 1px #bdc3c7;
    }
    .border-bottom{
        border-bottom: solid 1px #bdc3c7;
    }
    table.page_footer {width: 100%; border: none; background-color: white; padding: 2mm;border-collapse:collapse; border: none;}
}
-->
</style>
<page pageset='new' backtop='10mm' backbottom='10mm' backleft='20mm' backright='20mm' style="font-size: 13px; font-family: helvetica">
<page_header>
  <table style="width: 100%; border: solid 0px black;" cellspacing=0>
    <tr>
      <td style="text-align: left;    width: 33%"></td>
      <td style="text-align: center;    width: 34%;font-size: 16px; font-weight: bold">Corte de Caja</td>
      <td style="text-align: right;    width: 33%"><?php echo date('d/m/Y'); ?></td>
    </tr>
  </table>
  </page_header>
    <?php include "encabezado_general.php";?>
    <br>
    <br>
    <table cellspacing="0" style="width: 50%; text-align: left; font-size: 13pt;">
        <tr>
         <td style="width:75%;" class='midnight-blue'>Cajero:</td>
     </tr>
     <tr>
         <td style="width:50%;" >
            <?php
$sql_cliente = mysqli_query($conexion, "select * from users where id_users='$user_id'");
$rw_user     = mysqli_fetch_array($sql_cliente);
echo $rw_user['nombre_users'] . " " . $rw_user['apellido_users'];
echo "<br> Usuario: ";
echo $rw_user['usuario_users'];
echo "<br> Email: ";
echo $rw_user['email_users'];
echo "<br> Fecha: ";
echo $fecha_actual;
?>
        </td>
    </tr>
</table><br>
<?php
//---------------------------------------------------------------------------------------
$abonoSql    = "SELECT * FROM creditos_abonos where date(fecha_abono) = '$fecha_actual'";
$abonoQuery  = $conexion->query($abonoSql);
$total_abono = 0;
while ($abonoResult = $abonoQuery->fetch_assoc()) {
    $total_abono += $abonoResult['abono'];
}
//---------------------------------------------------------------------------------------
$orderSql   = "SELECT * FROM facturas_ventas WHERE DATE(fecha_factura)='$fecha_actual' and id_users_factura='$user_id'";
$orderQuery = $conexion->query($orderSql);

$totalVentas   = 0;
$totalEfectivo = 0;
$totalCheque   = 0;
$totalBanco    = 0;
$totalCredito  = 0;
while ($orderResult = $orderQuery->fetch_assoc()) {
    if ($orderResult['condiciones'] == 1) {
        $totalEfectivo += $orderResult['monto_factura'];
    } elseif ($orderResult['condiciones'] == 2) {
        $totalCheque += $orderResult['monto_factura'];
    } elseif ($orderResult['condiciones'] == 3) {
        $totalBanco += $orderResult['monto_factura'];
    } elseif ($orderResult['condiciones'] == 4 and $orderResult['estado_factura'] == 2) {
        $totalCredito += $orderResult['monto_factura'];
    }
    $totalVentas += $orderResult['monto_factura'];
}
?>
<table cellspacing="0" style="width: 90%;font-size: 14pt;">
        <tr>
         <td style="width:100%; text-align: center;">Ventas</td>
     </tr>
     <tr>
         <td style="width:50%;text-align: left;">Efectivo Ventas:</td>
         <td style="width:50%; text-align: left;"><?php echo $simbolo_moneda . '' . number_format($totalEfectivo, 2); ?></td>
     </tr>
     <tr>
         <td style="width:50%;text-align: left;">Cheque:</td>
         <td style="width:50%; text-align: left;"><?php echo $simbolo_moneda . '' . number_format($totalCheque, 2); ?></td>
     </tr>
      <tr>
         <td style="width:50%;text-align: left;">Tranferencia Bancaria:</td>
         <td style="width:50%; text-align: left;"><?php echo $simbolo_moneda . '' . number_format($totalBanco, 2); ?></td>
     </tr>
      <tr>
         <td style="width:50%;text-align: left;">Crédito:</td>
         <td style="width:50%; text-align: left;"><?php echo $simbolo_moneda . '' . number_format($totalCredito, 2); ?></td>
     </tr>
     <tr>
         <td style="width:100%;text-align: center;">--------------------------------------------------------------------------------------------------------
         </td>
     </tr>
     <tr>
         <td style="width:50%;text-align: left;font-weight:bold;">Total Ventas:</td>
         <td style="width:50%; text-align: left;"><?php echo $simbolo_moneda . '' . number_format($totalVentas, 2); ?></td>
     </tr>
</table>
<br>
<table cellspacing="0" style="width: 90%;font-size: 14pt;">
        <tr>
         <td style="width:100%; text-align: center;">Control de Efectivo</td>
     </tr>
     <tr>
         <td style="width:50%;text-align: left;">Entradas de Dinero:</td>
         <td style="width:50%; text-align: left;">0.00</td>
     </tr>
     <tr>
         <td style="width:50%;text-align: left;">Salidas de Caja:</td>
         <td style="width:50%; text-align: left;">0.00</td>
     </tr>
     <tr>
         <td style="width:50%;text-align: left;">Cuentas por Cobrar:</td>
         <td style="width:50%; text-align: left;"><?php echo $simbolo_moneda . '' . number_format($total_abono, 2); ?></td>
     </tr>
     <tr>
         <td style="width:100%;text-align: center;">--------------------------------------------------------------------------------------------------------
         </td>
     </tr>
      <tr>
         <td style="width:50%;text-align: left;font-weight:bold;">Total Efectivo:</td>
         <td style="width:50%; text-align: left;"><?php echo $simbolo_moneda . '' . number_format($totalEfectivo + $total_abono, 2); ?></td>
     </tr>
</table>
<br>
<table cellspacing="0" style="width: 90%;font-size: 14pt;">
     <tr>
         <td style="width:100%;text-align: center;">--------------------------------------------------------------------------------------------------------
         </td>
     </tr>
      <tr>
         <td style="width:50%;text-align: left;font-weight:bold;">Total Caja:</td>
         <td style="width:50%; text-align: left;"><?php echo $simbolo_moneda . '' . number_format($totalEfectivo + $total_abono, 2); ?></td>
     </tr>
</table>
</page>

