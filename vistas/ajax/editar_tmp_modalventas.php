<?php

include 'is_logged.php'; //Archivo verifica que el usario que intenta acceder a la URL esta logueado
$id_factura     = $_SESSION['id_factura'];
$numero_factura = $_SESSION['numero_factura'];
if (isset($_POST['id'])) {$id = intval($_POST['id']);}
if (isset($_POST['cantidad'])) {$cantidad = intval($_POST['cantidad']);}
if (isset($_POST['precio_venta'])) {$precio_venta = floatval($_POST['precio_venta']);}

/* Connect To Database*/
require_once "../db.php"; //Contiene las variables de configuracion para conectar a la base de datos
require_once "../php_conexion.php"; //Contiene funcion que conecta a la base de datos
//Archivo de funciones PHP
include "../funciones.php";
if (!empty($id) and !empty($cantidad) and !empty($precio_venta)) {
    // consulta para comparar el stock con la cantidad resibida
    $query = mysqli_query($conexion, "select stock_producto, inv_producto from productos where id_producto = '$id'");
    $rw    = mysqli_fetch_array($query);
    $stock = $rw['stock_producto'];
    $inv   = $rw['inv_producto'];

//Cmprobamos si agregamos un producto a la tabla tmp_compra
    $comprobar = mysqli_query($conexion, "select * from detalle_fact_ventas where id_producto='" . $id . "' and id_factura='" . $id_factura . "'");
    if ($row = mysqli_fetch_array($comprobar)) {
        $cant = $row['cantidad'] + $cantidad;
        // condicion si el stock e menor que la cantidad requerida
        if ($cant > $stock and $inv == 0) {
            echo "<script>swal('LA CANTIDAD SUPERA AL STOCK!', 'INTENTAR NUEVAMENTE', 'error')</script>";
        } else {
            $sql          = "UPDATE detalle_fact_ventas SET cantidad='" . $cant . "' WHERE id_producto='" . $id . "' and id_factura='" . $id_factura . "'";
            $query_update = mysqli_query($conexion, $sql);
            $update       = eliminar_stock($id, $cantidad); // Descuenta del inventario
        }
        // fin codicion cantidad

    } else {
// condicion si el stock e menor que la cantidad requerida
        if ($cantidad > $stock and $inv == 0) {
            echo "<script>swal('LA CANTIDAD SUPERA AL STOCK!', 'INTENTAR NUEVAMENTE', 'error')</script>";
        } else {
            $insert_tmp = mysqli_query($conexion, "INSERT INTO detalle_fact_ventas (id_factura,numero_factura, id_producto,cantidad,precio_venta) VALUES ('$id_factura','$numero_factura','$id','$cantidad','$precio_venta')");
            $update     = eliminar_stock($id, $cantidad); // Descuenta del inventario
        }
        // fin codicion cantaidad
    }

}
if (isset($_GET['id'])) //codigo elimina un elemento del array
{
    $id_detalle = intval($_GET['id']);
    $id_prod    = get_row('detalle_fact_ventas', 'id_producto', 'id_detalle', $id_detalle);
    $quantity   = get_row('detalle_fact_ventas', 'cantidad', 'id_detalle', $id_detalle);
    $update     = agregar_stock($id_prod, $quantity); //Vuelve agregar al inventario
    $delete     = mysqli_query($conexion, "DELETE FROM detalle_fact_ventas WHERE id_detalle='" . $id_detalle . "'");
}
$simbolo_moneda = get_row('perfil', 'moneda', 'id_perfil', 1);
?>
<div class="table-responsive">
    <table class="table table-sm">
        <thead class="thead-default">
            <tr>
                <th class='text-center'>COD</th>
                <th class='text-center'>CANT.</th>
                <th class='text-center'>DESCRIP.</th>
                <th class='text-center'>PRECIO <?php echo $simbolo_moneda; ?></th>
                <th class='text-center'>DESC %</th>
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
$sql            = mysqli_query($conexion, "select * from productos, facturas_ventas, detalle_fact_ventas where facturas_ventas.id_factura=detalle_fact_ventas.id_factura and  facturas_ventas.id_factura='$id_factura' and productos.id_producto=detalle_fact_ventas.id_producto");
while ($row = mysqli_fetch_array($sql)) {
    $id_detalle      = $row["id_detalle"];
    $id_producto     = $row["id_producto"];
    $codigo_producto = $row['codigo_producto'];
    $cantidad        = $row['cantidad'];
    $desc_tmp        = $row['desc_venta'];
    $nombre_producto = $row['nombre_producto'];

    $precio_venta   = $row['precio_venta'];
    $precio_venta_f = number_format($precio_venta, 0, '', ''); //Formateo variables
    //$precio_venta_r = str_replace(",", "", $precio_venta_f); //Reemplazo las comas
    $precio_total   = $precio_venta * $cantidad;
    $final_items    = rebajas($precio_total, $desc_tmp); //Aplicando el descuento
    /*--------------------------------------------------------------------------------*/
    $precio_total_f = number_format($final_items, 0, '', ''); //Precio total formateado
    //$precio_total_r = str_replace(",", "", $precio_total_f); //Reemplazo las comas
    $sumador_total += $final_items; //Sumador
    $subtotal = $sumador_total;
    if ($row['iva_producto'] == 10) {
        //$total_iva = iva($precio_venta);
        $sub_10 += $precio_venta;
        $total_iva10 = $precio_venta/11;
        $total_impuesto10 += (rebajas($total_iva10, $desc_tmp) * $cantidad);
    } elseif ($row['iva_producto'] == 5) {
        $sub_5 += $precio_venta;
        $total_iva5 = $precio_venta/21;
        $total_impuesto5 += (rebajas($total_iva5, $desc_tmp) * $cantidad);
    }else {
        $sub_0 += $precio_venta;
        $total_iva0 = $precio_venta;
        $total_impuesto0 += (rebajas($total_iva0, $desc_tmp) * $cantidad);
    }
    ?>
    <tr>
        <td class='text-center'><?php echo $codigo_producto; ?></td>
        <td class='text-center'><?php echo $cantidad; ?></td>
        <td><?php echo $nombre_producto; ?></td>
        <td class='text-center'>
            <div class="input-group">
                <select id="<?php echo $id_detalle; ?>" class="form-control employee_id">
                    <?php
$sql1 = mysqli_query($conexion, "select * from productos where id_producto='" . $id_producto . "'");
    while ($rw1 = mysqli_fetch_array($sql1)) {
        ?>
                        <option selected disabled value="<?php echo $precio_venta ?>"><?php echo number_format($precio_venta, 0, '', '.'); ?></option>
                        <option value="<?php echo $rw1['valor1_producto'] ?>">PV <?php echo number_format($rw1['valor1_producto'], 0, '', '.'); ?></option>
                        <option value="<?php echo $rw1['valor2_producto'] ?>">PM <?php echo number_format($rw1['valor2_producto'], 0, '', '.'); ?></option>
                        <option value="<?php echo $rw1['valor3_producto'] ?>">PE <?php echo number_format($rw1['valor3_producto'], 0, '', '.'); ?></option>
                        <?php
}
    ?>
                </select>
            </div>
        </td>
        <td align="right" width="15%">
                <input type="text" class="form-control txt_desc" style="text-align:center" value="<?php echo $desc_tmp; ?>" id="<?php echo $id_detalle; ?>">
        </td>
        <td class='text-right'><?php echo $simbolo_moneda . ' ' . number_format($final_items, 2); ?></td>
        <td class='text-center'>
            <a href="#" class='btn btn-danger btn-sm waves-effect waves-light' onclick="eliminar('<?php echo $id_detalle ?>')"><i class="fa fa-remove"></i>
            </a>
        </td>
    </tr>
    <?php
}
$total_factura = $subtotal;
$update        = mysqli_query($conexion, "update facturas_ventas set monto_factura='$total_factura' where id_factura='$id_factura'");

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
    <td style="font-size: 14pt;" class='text-right' colspan=5><b>TOTAL <?php echo $simbolo_moneda; ?></b></td>
    <td style="font-size: 16pt;" class='text-right'><span class="label label-danger"><b><?php echo number_format($total_factura, 0, '', '.'); ?></b></span></td>
    <td></td>
</tr>
</tbody>
</table>
</div>
<?php 
//Inicia Control de Permisos
include "../permisos.php";
$user_id = $_SESSION['id_users'];
get_cadena($user_id);
$modulo = "Ventas";
permisos($modulo, $cadena_permisos);
//Finaliza Control de Permisos
//var_dump($permisos_eliminar);
?>
<input type="hidden" id="permiso" value="<?php echo $permisos_eliminar; ?>">
<script>
    $(document).ready(function () {
        permiso = document.getElementById('permiso').value;
        $('.txt_desc').off('blur');
        $('.txt_desc').on('blur',function(event){
            var keycode = (event.keyCode ? event.keyCode : event.which);
        // if(keycode == '13'){
            id_tmp = $(this).attr("id");
            desc = $(this).val();
             //Inicia validacion
             
             ///console.log(permiso);
             if(permiso == "1"){
                if (isNaN(desc)) {
                    $.Notification.notify('error','bottom center','ERROR', 'DIGITAR UN DESCUENTO VALIDO')
                    $(this).focus();
                    return false;
                }
             }else{
                if (isNaN(desc) || desc > 20) {
                    $.Notification.notify('error','bottom center','ERROR', 'DIGITAR UN DESCUENTO VALIDO')
                    $(this).focus();
                    return false;
                }
             }
             
    //Fin validacion
    $.ajax({
        type: "POST",
        url: "../ajax/editar_desc_venta.php",
        data: "id_tmp=" + id_tmp + "&desc=" + desc,
        success: function(datos) {
           $("#resultados").load("../ajax/agregar_tmp.php");
           $.Notification.notify('success','bottom center','EXITO!', 'DESCUENTO ACTUALIZADO CORRECTAMENTE')
       }
   });
        // }
    });
     $(".employee_id").on("change", function(event) {
         id_tmp = $(this).attr("id");
        precio = $(this).val();
        $.ajax({
            type: "POST",
            url: "../ajax/editar_precio_venta.php",
            data: "id_tmp=" + id_tmp + "&precio=" + precio,
            success: function(datos) {
               $("#resultados").load("../ajax/agregar_tmp.php");
               $.Notification.notify('success','bottom center','EXITO!', 'PRECIO ACTUALIZADO CORRECTAMENTE')
           }
       });
    });

    });
</script>