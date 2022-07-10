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
      <td style="text-align: center;    width: 34%;font-size: 14px; font-weight: bold">Reporte de Movimiento de Producto</td>
      <td style="text-align: right;    width: 33%"><?php echo date('d/m/Y'); ?></td>
    </tr>
  </table>
  </page_header>
  <?php include "encabezado_general.php";?>
  <br>
  <table style="width: 100%; border: solid 0px black;">
    <tr>
      <td style="font-size: 18px; font-weight: bold;text-align: center;width: 100%">Producto: <?php echo $nombre_producto; ?></td>
    </tr>
  </table>
  <br>
  <br>
  <div>
    Tipo de Movimiento:
    <?php
$sql1 = mysqli_query($conexion, "select tipo_historial from historial_productos where tipo_historial='" . $tipo . "'");
$rw1  = mysqli_fetch_array($sql1);
$tipo = $rw1['tipo_historial'];
if ($tipo == 1) {
    $vista = 'Entradas';
} else {
    $vista = 'Salidas';
}
if (empty($tipo)) {
    echo "Todos";
} else {
    echo $vista;
}
?>
  </div>

  <table class="table-bordered" style="width:100%;">
    <tr class="midnight-blue">
     <th style="width:10%;text-align:center">Fecha</th>
     <th style="width:10%;text-align:center">Hora</th>
     <th style="width:40%;text-align:center">Descripción</th>
     <th style="width:15%;text-align:center">Referencia</th>
     <th style="width:10%;text-align:center">Tipo</th>
     <th style="width:10%;text-align:center">Total</th>
   </tr>
   <?php
while ($row = mysqli_fetch_array($query)) {
    if ($row['tipo_historial'] == 1) {
        $tipo = "Entrada";
    } else {
        $tipo = "Salida";
    }
    $id_users = $row['id_users'];
    $sql      = mysqli_query($conexion, "select usuario_users from users where id_users='" . $id_users . "'");
    $rw       = mysqli_fetch_array($sql);
    $usuario  = $rw['usuario_users'];
    ?>
    <tr>
     <td><?php echo date('d/m/Y', strtotime($row['fecha_historial'])); ?></td>
     <td><?php echo date('H:i:s', strtotime($row['fecha_historial'])); ?></td>
     <td><?php echo $usuario . ' ' . $row['nota_historial']; ?></td>
     <td><?php echo $row['referencia_historial']; ?></td>
     <td><?php echo $tipo; ?></td>
     <td style="text-align:center"><?php echo $row['cantidad_historial']; ?></td>
   </tr>
   <?php
}

?>
 <tr>
  <td style='text-align:right;border-top:3px solid #2c3e50;padding:4px;padding-top:4px;font-size:14px' colspan="6"></td>
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