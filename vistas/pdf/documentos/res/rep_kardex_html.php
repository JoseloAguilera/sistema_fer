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
      <td style="text-align: center;    width: 34%;font-size: 14px; font-weight: bold">Kardex de Producto</td>
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
<div>Fecha: <?php echo $daterange; ?></div>
 <table style="width:100%;border: solid 1px black;" border="1">
            <tr class="midnight-blue">
            <th colspan="2" style="width:25%;text-align:center">Fecha</th>
            <th colspan="3" style="width:25%;text-align:center">Entradas</th>
            <th colspan="3" style="width:25%;text-align:center">Salidas</th>
            <th colspan="3" style="width:25%;text-align:center">Saldo</th>
            </tr>
            <tr class="midnight-blue">
            <th style="text-align:center"></th>
            <th style="text-align:center">Detalle</th>
            <th style="text-align:center">Cant.</th>
            <th style="text-align:center">Costo</th>
            <th style="text-align:center">Total</th>
            <th style="text-align:center">Cant.</th>
            <th style="text-align:center">Costo</th>
            <th style="text-align:center">Total</th>
            <th style="text-align:center">Cant.</th>
            <th style="text-align:center">Costo</th>
            <th style="text-align:center">Total</th>

            </tr>
             <?php
$finales        = 0;
$cant_totale    = 0;
$costo_totale   = 0;
$totale         = 0;
$cant_totals    = 0;
$costo_totals   = 0;
$totals         = 0;
$simbolo_moneda = get_row('perfil', 'moneda', 'id_perfil', 1);
while ($row = mysqli_fetch_array($query)) {
    $id_kardex       = $row['id_kardex'];
    $fecha_kardex    = date("d/m/Y", strtotime($row['fecha_kardex']));
    $producto_kardex = $row['producto_kardex'];
    $cant_entrada    = $row['cant_entrada'];
    $costo_entrada   = $row['costo_entrada'];
    $total_entrada   = $row['total_entrada'];
    $cant_salida     = $row['cant_salida'];
    $costo_salida    = $row['costo_salida'];
    $total_salida    = $row['total_salida'];
    $cant_saldo      = $row['cant_saldo'];
    $costo_saldo     = $row['costo_saldo'];
    $total_saldo     = $row['total_saldo'];
    $tipo            = $row['tipo_movimiento'];
    if ($tipo == 1) {
        $movto = 'COMPRA';
    } else if ($tipo == 3 or $tipo == 4) {
        $movto = 'AJUSTE';
    } else {
        $movto = 'VENTA';
    }
    //TOTALES
    $cant_totale += $cant_entrada;
    $costo_totale += $costo_entrada;
    $totale += $total_entrada;

    $cant_totals += $cant_salida;
    $costo_totals += $costo_salida;
    $totals += $total_salida;

    $finales++;
    ?>
            <tr>
            <td style="text-align:center"><?php echo $fecha_kardex; ?></td>
            <td style="text-align:center"><?php echo $movto; ?></td>
            <td style="text-align:center"><?php echo $cant_entrada; ?></td>
            <td style="text-align:center"><?php echo formato($costo_entrada); ?></td>
            <td style="text-align:center"><?php echo formato($total_entrada); ?></td>
            <td style="text-align:center"><?php echo $cant_salida; ?></td>
            <td style="text-align:center"><?php echo formato($costo_salida); ?></td>
            <td style="text-align:center"><?php echo formato($total_salida); ?></td>
            <td style="text-align:center"><?php echo $cant_saldo; ?></td>
            <td style="text-align:center"><?php echo formato($costo_saldo); ?></td>
            <td style="text-align:center"><?php echo formato($total_saldo); ?></td>
            </tr>
            <?php }?>
            <tr>
            <th colspan="2" style="text-align:right;">Total:</th>
            <th style="text-align:center"><?php echo $cant_totale; ?></th>
            <th style="text-align:center"><?php echo formato($costo_totale); ?></th>
            <th style="text-align:center"><?php echo formato($totale); ?></th>
            <th style="text-align:center"><?php echo $cant_totals; ?></th>
            <th style="text-align:center"><?php echo formato($costo_totals); ?></th>
            <th style="text-align:center"><?php echo formato($totals); ?></th>
            <th colspan="3" style="text-align:center"></th>



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