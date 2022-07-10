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
    Categoria:
    <?php
$sql1             = mysqli_query($conexion, "select * from lineas where id_linea='" . $categoria . "'");
$rw1              = mysqli_fetch_array($sql1);
$nombre_categoria = $rw1['nombre_linea'];
if (empty($nombre_categoria)) {
    echo "Todos";
} else {
    echo $nombre_categoria;
}
?>
  </div>

  <table class="table-bordered" style="width:100%;">
    <tr class="midnight-blue">
      <th style="width:10%;">Codigo</th>
      <th style="width:30%;">Producto</th>
      <th style="width:5%;">Cant.</th>
      <th style="width:10%;">Costo</th>
      <th style="width:10%;">T. Costo</th>
      <th style="width:10%;">P. Vendido</th>
      <th style="width:10%;">Desc.</th>
      <th style="width:10%;">T. Vendido</th>
      <th style="width:10%;">Utilidad</th>
    </tr>
    <?php
$sumador_total  = 0;
$simbolo_moneda = get_row('perfil', 'moneda', 'id_perfil', 1);
while ($row = mysqli_fetch_array($query)) {
    $id_producto     = $row['id_producto'];
    $codigo_producto = $row['codigo_producto'];
    $nombre_producto = $row['nombre_producto'];
    $costo_producto  = $row['costo_producto'];
    $precio_vendido  = $row['precio_venta'];
    //calculos de totales
    $sql         = mysqli_query($conexion, "select sum(cantidad) as cant, sum(desc_venta) as d, sum(importe_venta) as pv from detalle_fact_ventas, facturas_ventas where facturas_ventas.id_factura=detalle_fact_ventas.id_factura and facturas_ventas.fecha_factura between '$fecha_inicial' and '$fecha_final' and  detalle_fact_ventas.id_producto='" . $id_producto . "'");
    $rw          = mysqli_fetch_array($sql);
    $cantidad    = $rw['cant'];
    $desc_venta  = $rw['d'];
    $total_costo = $cantidad * $costo_producto;
    $total_pv    = $rw['pv'];

    $final_items   = rebajas($total_pv, $desc_venta); //Aplicando el descuento
    $descuento     = $total_pv - $final_items;
    $utilidad      = $final_items - $total_costo;
    $sumador_total = $sumador_total + $utilidad;

    ?>
      <tr>
       <td><?php echo $codigo_producto; ?></td>
       <td><?php echo $nombre_producto; ?></td>
       <td><?php echo $cantidad; ?></td>
       <td><?php echo $simbolo_moneda . '' . number_format($costo_producto, 2); ?></td>
       <td><?php echo $simbolo_moneda . '' . number_format($total_costo, 2); ?></td>
       <td><?php echo $simbolo_moneda . '' . number_format($precio_vendido, 2); ?></td>
       <td><?php echo $simbolo_moneda . '' . number_format($descuento, 2); ?></td>
       <td><?php echo $simbolo_moneda . '' . number_format($final_items, 2); ?></td>
       <td><?php echo $simbolo_moneda . '' . number_format($utilidad, 2); ?></td>
     </tr>
     <?php
}

?>
   <tr>
    <td style='text-align:right;border-top:3px solid #2c3e50;padding:4px;padding-top:4px;font-size:14px' colspan="9"><?php echo $simbolo_moneda . '' . number_format($sumador_total, 2) ?></td>
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