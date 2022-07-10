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
<page pageset='new' backtop='10mm' backbottom='10mm' backleft='20mm' backright='20mm' style="font-size: 13px; font-family: helvetica">
  <page_header>
  <table style="width: 100%; border: solid 0px black;" cellspacing=0>
    <tr>
      <td style="text-align: left;    width: 33%"></td>
      <td style="text-align: center;    width: 34%;font-size: 14px; font-weight: bold">Reporte de Ventas</td>
      <td style="text-align: right;    width: 33%"><?php echo date('d/m/Y'); ?></td>
    </tr>
  </table>
  </page_header>
  <?php include "encabezado_general.php";?>
    <br>
  <div>
    Estado de la Factura:
    <?php
$sql1           = mysqli_query($conexion, "select estado_factura from facturas_ventas where estado_factura='" . $estado_factura . "'");
$rw1            = mysqli_fetch_array($sql1);
$estado_factura = $rw1['estado_factura'];
if ($estado_factura != 2) {
    $estado = 'Pagado';
} else { $estado = 'pendiente';}
if (empty($estado)) {
    echo "Todos";
} else {
    echo $estado;
}
?>
  </div>

  <table class="table-bordered" style="width:100%;">
    <tr class="midnight-blue">
      <th style="width:15%;">Factura Nº</th>
      <th style="width:40%;">Cliente</th>
      <th style="width:15%;">Fecha</th>
      <th style="width:15%;">Estado</th>
      <th style="width:15%;">Total</th>
    </tr>
    <?php
$sumador_total  = 0;
$simbolo_moneda = get_row('perfil', 'moneda', 'id_perfil', 1);
while ($row = mysqli_fetch_array($query)) {
    $numero_factura = $row['numero_factura'];
    $nombre_users   = $row['nombre_users'] . ' ' . $row['apellido_users'];
    $id_cliente     = $row['id_cliente'];
    $estado_factura = $row['estado_factura'];
    $sql            = mysqli_query($conexion, "select nombre_cliente from clientes where id_cliente='" . $id_cliente . "'");
    $rw             = mysqli_fetch_array($sql);
    $nombre_cliente = $rw['nombre_cliente'];
    $date_added     = $row['fecha_factura'];
    $total          = $row['monto_factura'];
    $sumador_total += $total;

    list($date, $hora) = explode(" ", $date_added);
    list($Y, $m, $d)   = explode("-", $date);
    $fecha             = $d . "-" . $m . "-" . $Y;
    if ($estado_factura != 2) {
        $estado = 'Pagado';
    } else { $estado = 'pendiente';}
    ?>
      <tr>
        <td><?php echo $numero_factura; ?></td>
        <td><?php echo $nombre_cliente; ?></td>
        <td><?php echo $fecha; ?></td>
        <td><?php echo $estado; ?></td>
        <td><?php echo $simbolo_moneda . '' . number_format($total, 2) ?></td>
      </tr>
      <?php
}

?>
    <tr>
      <td style='text-align:right;border-top:3px solid #2c3e50;padding:4px;padding-top:4px;font-size:14px' colspan="5"><?php echo $simbolo_moneda . '' . number_format($sumador_total, 2) ?></td>
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