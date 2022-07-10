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
<page pageset='new' backtop='10mm' backbottom='10mm' backleft='20mm' backright='20mm' style="font-size: 14px; font-family: helvetica">
  <page_header>
  <table style="width: 100%; border: solid 0px black;" cellspacing=0>
    <tr>
      <td style="text-align: left;    width: 33%"></td>
      <td style="text-align: center;    width: 34%;font-size: 14px; font-weight: bold">Reporte de Abonos a Proveedores</td>
      <td style="text-align: right;    width: 33%"><?php echo date('d/m/Y'); ?></td>
    </tr>
  </table>
  </page_header>
  <?php include "encabezado_general.php";?>
  <br>
  <table style="width: 100%; border: solid 0px black;">
    <tr>
      <?php
$sql_abono = mysqli_query($conexion, "select * from creditos_abonos_prov, proveedores where creditos_abonos_prov.numero_factura='$numero_factura' and creditos_abonos_prov.id_proveedor=proveedores.id_proveedor");
$rw        = mysqli_fetch_array($sql_abono);
?>
      <td style="font-size: 18px; font-weight: bold;text-align: center;width: 100%">Proveedor: <?php echo $rw['nombre_proveedor']; ?></td>
    </tr>
  </table>
  <br>
  <br>
  <table class="table-bordered" style="width:100%;">
    <tr class="midnight-blue">
     <th style="width:20%;text-align:center">Factura</th>
     <th style="width:25%;text-align:center">Fecha</th>
     <th style="width:20%;text-align:center">Crédito</th>
     <th style="width:20%;text-align:center">Abonos</th>
     <th style="width:20%;text-align:center">Saldos</th>
   </tr>
   <?php
while ($row = mysqli_fetch_array($query)) {
    ?>
    <tr>
      <td><?php echo $row['numero_factura']; ?></td>
      <td><?php echo date("d/m/Y", strtotime($row['fecha_abono'])); ?></td>
      <td><?php echo $simbolo_moneda . '' . number_format($row['monto_abono'], 2); ?></td>
      <td><?php echo $simbolo_moneda . '' . number_format($row['abono'], 2); ?></td>
      <td><?php echo $simbolo_moneda . '' . number_format($row['saldo_abono'], 2); ?></td>
    </tr>
    <?php }?>
  </table>
  <br><br>
<br><br>
<?php
$orderSql   = "SELECT * FROM creditos_abonos_prov where numero_factura = '$numero_factura'";
$orderQuery = $conexion->query($orderSql);
$countOrder = $orderQuery->num_rows;

$total_abono = 0;
while ($orderResult = $orderQuery->fetch_assoc()) {
    $total_abono += $orderResult['abono'];
    $credito = $orderResult['monto_abono'];
    $saldo   = $orderResult['saldo_abono'];
}
?>
<table cellpadding='4' cellspacing='0' border='0'>
  <tr>
    <th style="width: 35%">Crédito</th>
    <th style="width: 35%">Total Abonado</th>
    <th style="width: 35%">Saldo</th>
  </tr>
  <tr>
    <td style="height:5%;text-align: left"><?php echo $simbolo_moneda . '' . number_format($credito, 2); ?></td>
    <td style="height:5%;text-align: left"><?php echo $simbolo_moneda . '' . number_format($total_abono, 2); ?></td>
    <td style="height:5%;text-align: left"><?php echo $simbolo_moneda . '' . number_format($saldo, 2); ?></td>
  </tr>
</table>
<br><br>
<br><br>
  <page_footer>
  <table style="width: 100%; border: solid 0px black;">
    <tr>
      <td style="text-align: left;    width: 50%"></td>
      <td style="text-align: right;    width: 50%">page [[page_cu]]/[[page_nb]]</td>
    </tr>
  </table>
  </page_footer>
</page>