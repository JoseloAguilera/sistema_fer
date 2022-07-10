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
    font-size:12px;
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
<page pageset='new' backtop='10mm' backbottom='10mm' backleft='20mm' backright='20mm' style="font-size: 13pt; font-family: helvetica">
  <page_header>
  <table style="width: 100%; border: solid 0px black;" cellspacing=0>
    <tr>
      <td style="text-align: left;    width: 33%"></td>
      <td style="text-align: center;    width: 34%;font-size: 14px; font-weight: bold">Corte de Caja Genral</td>
      <td style="text-align: right;    width: 33%"><?php echo date('d/m/Y'); ?></td>
    </tr>
  </table>
  </page_header>
  <?php include "encabezado_general.php";?>
    <br>
  <div>
    Cajero:
    <?php
$sql1     = mysqli_query($conexion, "select nombre_users, apellido_users from users where id_users='" . $employee_id . "'");
$rw1      = mysqli_fetch_array($sql1);
$fullname = $rw1['nombre_users'] . ' ' . $rw1['apellido_users'];
if ($employee_id == null) {
    echo "Todos";
} else {
    echo $fullname;
}
?>
  </div><br>

             <?php
$finales        = 0;
$totalVentas    = 0;
$totalEfectivo  = 0;
$totalCheque    = 0;
$totalBanco     = 0;
$totalCredito   = 0;
$simbolo_moneda = get_row('perfil', 'moneda', 'id_perfil', 1);
while ($row = mysqli_fetch_array($query)) {
    if ($row['condiciones'] == 1) {
        $totalEfectivo += $row['monto_factura'];
    } elseif ($row['condiciones'] == 2) {
        $totalCheque += $row['monto_factura'];
    } elseif ($row['condiciones'] == 3) {
        $totalBanco += $row['monto_factura'];
    } elseif ($row['condiciones'] == 4 and $row['estado_factura'] == 2) {
        $totalCredito += $row['monto_factura'];
    }
    $totalVentas += $row['monto_factura'];
}
//---------------------------------------------------------------------------------------
$abonoSql    = "SELECT * FROM creditos_abonos where fecha_abono between '$fecha_inicial' and '$fecha_final'";
$abonoQuery  = $conexion->query($abonoSql);
$total_abono = 0;
while ($abonoResult = $abonoQuery->fetch_assoc()) {
    $total_abono += $abonoResult['abono'];
}
//---------------------------------------------------------------------------------------
?>
            <table cellspacing="0" style="width: 85%;">
        <tr>
         <td style="width:100%; text-align: center;">Ventas</td>
     </tr>
     <tr>
         <td style="width:50%;text-align: left;">Efectivo:</td>
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
<?php
$totalEntrada   = 0;
$totalSalida    = 0;
$total_efectivo = 0;
if ($employee_id > 0) {
    $caja = mysqli_query($conexion, "select * from caja_chica where users_caja='" . $employee_id . "' and date_added_caja between '$fecha_inicial' and '$fecha_final'");
} else {
    $caja = mysqli_query($conexion, "select * from caja_chica where date_added_caja between '$fecha_inicial' and '$fecha_final'");
}
while ($rw = mysqli_fetch_array($caja)) {
    if ($rw['tipo_caja'] == 1) {
        $totalEntrada += $rw['monto_caja'];
    } elseif ($rw['tipo_caja'] == 2) {
        $totalSalida += $rw['monto_caja'];
    }
    $total_efectivo = $totalSalida - $totalEntrada;
}
?>
<table cellspacing="0" style="width: 85%;">
        <tr>
         <td style="width:100%; text-align: center;">Control de Efectivo</td>
     </tr>
     <tr>
         <td style="width:50%;text-align: left;">Entradas de Dinero:</td>
         <td style="width:50%; text-align: left;"><?php echo $simbolo_moneda . '' . number_format($totalEntrada, 2); ?></td>
     </tr>
     <tr>
         <td style="width:50%;text-align: left;">Salidas de Caja:</td>
         <td style="width:50%; text-align: left;"><?php echo $simbolo_moneda . '' . number_format($totalSalida, 2); ?></td>
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
         <td style="width:50%; text-align: left;"><?php echo $simbolo_moneda . '' . number_format($total_efectivo, 2); ?></td>
     </tr>
</table>
<br>
<table cellspacing="0" style="width: 85%;">
     <tr>
         <td style="width:100%;text-align: center;">--------------------------------------------------------------------------------------------------------
         </td>
     </tr>
      <tr>
         <td style="width:50%;text-align: left;font-weight:bold;">Total Caja:</td>
         <td style="width:50%; text-align: left;"><?php echo $simbolo_moneda . '' . number_format($totalEfectivo + $total_abono, 2); ?></td>
     </tr>
</table>
  <page_footer>
  <table style="width: 100%; border: solid 0px black;">
    <tr>
      <td style="text-align: left;    width: 50%"></td>
      <td style="text-align: right;    width: 50%">page [[page_cu]]/[[page_nb]]</td>
    </tr>
  </table>
  </page_footer>
</page>