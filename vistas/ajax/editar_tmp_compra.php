<?php
/*-------------------------
Autor: Delmar Lopez
Web: softwys.com
Mail: softwysop@gmail.com
---------------------------*/
include 'is_logged.php'; //Archivo verifica que el usario que intenta acceder a la URL esta logueado
$id_factura     = $_SESSION['id_factura'];
$numero_factura = $_SESSION['numero_factura'];
$session_id     = session_id();
if (isset($_POST['id'])) {$id = $_POST['id'];}
if (isset($_POST['cantidad'])) {$cantidad = $_POST['cantidad'];}
/* Connect To Database*/
require_once "../db.php"; //Contiene las variables de configuracion para conectar a la base de datos
require_once "../php_conexion.php"; //Contiene funcion que conecta a la base de datos
//Archivo de funciones PHP
include "../funciones.php";
if (!empty($id) and !empty($cantidad)) {
    $id_producto    = get_row('productos', 'id_producto', 'codigo_producto', $id);
    $costo_producto = get_row('productos', 'costo_producto', 'id_producto', $id_producto);
    //Cmprobamos si agregamos un producto a la tabla tmp_compra
    $comprobar = mysqli_query($conexion, "select * from detalle_fact_compra where id_producto='" . $id_producto . "'");
    if ($row = mysqli_fetch_array($comprobar)) {
        $cant         = $row['cantidad'] + $cantidad;
        $update       = agregar_stock($id_producto, $cantidad); //Agrega al  inventario
        $sql          = "UPDATE detalle_fact_compra SET cantidad='" . $cant . "' WHERE id_producto='" . $id_producto . "'";
        $query_update = mysqli_query($conexion, $sql);

    } else {
        $insert_tmp = mysqli_query($conexion, "INSERT INTO detalle_fact_compra (id_factura,numero_factura, id_producto,cantidad,precio_costo) VALUES ('$id_factura','$numero_factura','$id_producto','$cantidad','$costo_producto')");
        $update     = agregar_stock($id_producto, $cantidad); // Descuenta del inventario
    }

}
if (isset($_GET['id'])) //codigo elimina un elemento del array
{
    $id_detalle = intval($_GET['id']);
    $id_detalle = intval($_GET['id']);
    $id_prod    = get_row('detalle_fact_compra', 'id_producto', 'id_detalle', $id_detalle);
    $quantity   = get_row('detalle_fact_compra', 'cantidad', 'id_detalle', $id_detalle);
    $update     = eliminar_stock($id_prod, $quantity); //Vuelve agregar al inventario
    $delete     = mysqli_query($conexion, "DELETE FROM detalle_fact_compra WHERE id_detalle='" . $id_detalle . "'");
}
$simbolo_moneda = get_row('perfil', 'moneda', 'id_perfil', 1);
?>
<div class="table-responsive">
    <table class="table table-sm">
        <thead class="thead-default">
            <tr>
                <th class='text-center'>COD.</th>
                <th class='text-center'>CANT.</th>
                <th>DESCRIP.</th>
                <th class='text-center'>COSTO</th>
                <th class='text-right'>TOTAL</th>
                <th></th>
            </tr>
        </thead>
        <tbody>

            <?php
$impuesto       = get_row('perfil', 'impuesto', 'id_perfil', 1);
$nom_impuesto   = get_row('perfil', 'nom_impuesto', 'id_perfil', 1);
$sumador_total  = 0;
$total_iva0      = 0;
$total_iva5      = 0;
$total_iva10      = 0;
$total_impuesto0 = 0;
$total_impuesto5 = 0;
$total_impuesto10 = 0;
$sub_0=0;
$sub_5=0;
$sub_10=0;
$subtotal       = 0;
$sql           = mysqli_query($conexion, "select * from productos, facturas_compras, detalle_fact_compra where facturas_compras.id_factura=detalle_fact_compra.id_factura and  facturas_compras.id_factura='$id_factura' and productos.id_producto=detalle_fact_compra.id_producto");
while ($row = mysqli_fetch_array($sql)) {
    $id_detalle      = $row["id_detalle"];
    $codigo_producto = $row['codigo_producto'];
    $cantidad        = $row['cantidad'];
    $nombre_producto = $row['nombre_producto'];

    $precio_costo   = $row['precio_costo'];
    $precio_costo_f = number_format($precio_costo, 0, '', ''); //Formateo variables
    //$precio_costo_r = str_replace(",", "", $precio_costo_f); //Reemplazo las comas
    $precio_total   = $precio_costo * $cantidad;
    $precio_total_f = number_format($precio_total, 0, '', '.'); //Precio total formateado
    //$precio_total_r = str_replace(",", "", $precio_total_f); //Reemplazo las comas
    $sumador_total += $precio_total; //Sumador
    $subtotal = $sumador_total;
    if ($row['iva_producto'] == 10) {
        //$total_iva = iva($precio_venta);
        $sub_10 += $precio_costo;
        $total_iva10 = $precio_costo/11;
        $total_impuesto10 += $total_iva10*$cantidad;
    } elseif ($row['iva_producto'] == 5) {
        $sub_5 += $precio_costo;
        $total_iva5 = $precio_costo/21;
        $total_impuesto5 += $total_iva5*$cantidad;
    }else {
        $sub_0 += $precio_costo;
        $total_iva0 = $precio_costo;
        $total_impuesto0 += $total_iva0*$cantidad;
    }
    ?>
    <tr>
        <td class='text-center'><?php echo $codigo_producto; ?></td>
        <td class='text-center'><?php echo $cantidad; ?></td>
        <td><?php echo $nombre_producto; ?></td>
        <td align="right" width="15%">
            <input type="text" class="form-control txt_costo" value="<?php echo $precio_costo_f; ?>" id="<?php echo $id_detalle; ?>">
        </td>
        <td class='text-right'><?php echo $simbolo_moneda . ' ' . $precio_total_f; ?></td>
        <td class='text-center'>
            <a href="#" class='btn btn-danger btn-sm waves-effect waves-light' onclick="eliminar('<?php echo $id_detalle ?>')"><i class="fa fa-remove"></i>
            </a>
        </td>
    </tr>
    <?php
}

$total_factura = $subtotal;
$update        = mysqli_query($conexion, "update facturas_compras set monto_factura='$total_factura' where id_factura='$id_factura'");

?>
<tr>
    <td class='text-right' colspan=5>SUBTOTAL EXENTAS</td>
    <td class='text-right'><b><?php echo $simbolo_moneda . ' ' . number_format($sub_0, 0, '', '.'); ?></b></td>
    <td></td>
</tr>
<tr>
    <td class='text-right' colspan=5>SUBTOTAL 5%</td>
    <td class='text-right'><b><?php echo $simbolo_moneda . ' ' . number_format($sub_5, 0, '', '.'); ?></b></td>
    <td></td>
</tr>
<tr>
    <td class='text-right' colspan=5>SUBTOTAL 10%</td>
    <td class='text-right'><b><?php echo $simbolo_moneda . ' ' . number_format($sub_10, 0, '', '.'); ?></b></td>
    <td></td>
</tr>
<tr>
    <td class='text-right' colspan=5><?php echo "Exentas"; ?> </td>
    <td class='text-right'><?php echo $simbolo_moneda . ' ' . number_format($total_impuesto0, 0, '', '.'); ?>
    </td>
    <td></td>
</tr>
<tr>
    <td class='text-right' colspan=5><?php echo "IVA 5 %"; ?> </td>
    <td class='text-right'><?php echo $simbolo_moneda . ' ' . number_format($total_impuesto5, 0, '', '.'); ?>
    </td>
    <td></td>
</tr>
<tr>
    <td class='text-right' colspan=5><?php echo "IVA 10 %"; ?> </td>
    <td class='text-right'><?php echo $simbolo_moneda . ' ' . number_format($total_impuesto10, 0, '', '.'); ?>
    </td>
    <td></td>
</tr>
<tr>
    <td style="font-size: 14pt;" class='text-right' colspan=4><b>TOTAL <?php echo $simbolo_moneda; ?> </b></td>
    <td style="font-size: 14pt;" class='text-right'><b><?php echo number_format($total_factura, 0, '', '.'); ?></b></td>
    <td></td>
</tr>
</tbody>
</table>
</div>
<script>
    $(document).ready(function () {
        $('.txt_costo').off('blur');
        $('.txt_costo').on('blur',function(event){
            var keycode = (event.keyCode ? event.keyCode : event.which);
        // if(keycode == '13'){
            id_tmp = $(this).attr("id");
            costo = $(this).val();
             //Inicia validacion
             if (isNaN(costo)) {
                $.Notification.notify('error','bottom center','ERROR!', 'EL COSTO DIGITADO NO ES UN FORMATO VALIDO')
                $(this).focus();
                return false;
            }
    //Fin validacion
    $.ajax({
        type: "POST",
        url: "../ajax/editar_costo.php",
        data: "id_tmp=" + id_tmp + "&costo=" + costo,
        success: function(datos) {
         $("#resultados").load("../ajax/editar_tmp_compra.php");
         $.Notification.notify('success','bottom center','EXITO!', 'COSTO ACTUALIZADO CORRECTAMENTE')
     }
 });
        // }
    });
    });
</script>

