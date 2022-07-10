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
      <td style="text-align: center;    width: 34%;font-size: 14px; font-weight: bold">Reporte de Movimientos de Caja Chica</td>
      <td style="text-align: right;    width: 33%"><?php echo date('d/m/Y'); ?></td>
    </tr>
  </table>
  </page_header>
  <?php include "encabezado_general.php";?>
    <br>
  <div>
    Tipo de Operación:
    <?php
$sql1      = mysqli_query($conexion, "select tipo_caja from caja_chica where tipo_caja='" . $tipo_caja . "'");
$rw1       = mysqli_fetch_array($sql1);
$tipo_caja = $rw1['tipo_caja'];
if (empty($fullname)) {
    echo "Todos";
} else {
    echo $fullname;
}
?>
  </div>

  <table class="table-bordered" style="width:100%;">
    <tr class="midnight-blue">
      <th style="width:12%;">Referencia</th>
      <th style="width:40%;">Descripción</th>
      <th style="width:12%;">Fecha</th>
      <th style="width:15%;">Operación</th>
      <th style="width:10%;">Usuario</th>
      <th style="width:12%;">Monto</th>
    </tr>
    <?php
$sumador_total  = 0;
$simbolo_moneda = get_row('perfil', 'moneda', 'id_perfil', 1);
while ($row = mysqli_fetch_array($query)) {
    $referencia_caja  = $row['referencia_caja'];
    $descripcion_caja = $row['descripcion_caja'];
    $date_added       = $row['date_added_caja'];
    $user_fullname    = $row['nombre_users'];
    $subtotal         = $row['monto_caja'];
    $total            = $row['monto_caja'];
    $tipo_caja        = $row['tipo_caja'];
    $sumador_total += $total;

    list($date, $hora) = explode(" ", $date_added);
    list($Y, $m, $d)   = explode("-", $date);
    $fecha             = $d . "-" . $m . "-" . $Y;
    if ($tipo_caja != 2) {
        $tipo = 'Ingreso';
    } else { $tipo = 'Egreso';}
    ?>
      <tr>
        <td><?php echo $referencia_caja; ?></td>
        <td><?php echo $descripcion_caja; ?></td>
        <td><?php echo $fecha; ?></td>
        <td><?php echo $tipo; ?></td>
        <td><?php echo $user_fullname; ?></td>
        <td><?php echo $simbolo_moneda . '' . number_format($total, 2) ?></td>
      </tr>
      <?php
}

?>
    <tr>
      <td style='text-align:right;border-top:3px solid #2c3e50;padding:4px;padding-top:4px;font-size:14px' colspan="6"><?php echo $simbolo_moneda . '' . number_format($sumador_total, 2) ?></td>
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