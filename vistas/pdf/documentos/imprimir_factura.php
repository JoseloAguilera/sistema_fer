<?php
include '../../ajax/is_logged.php'; //Archivo verifica que el usario que intenta acceder a la URL esta logueado
?>
<style type="text/css">
    <!--
    table { vertical-align: top; }
    tr    { vertical-align: top; }
    td    { vertical-align: top; }
    .midnight-blue{
        background:#2c3a50;
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
<?php
/* Connect To Database*/
require_once "../../db.php"; //Contiene las variables de configuracion para conectar a la base de datos
require_once "../../php_conexion.php"; //Contiene funcion que conecta a la base de datos
//Archivo de funciones PHP
include "../../funciones.php";
$id_factura     = $_POST['id_factura'];
$simbolo_moneda = get_row('perfil', 'moneda', 'id_perfil', 1);
if (isset($_POST['id_factura'])) {
    $id_factura  = intval($_POST['id_factura']);
    $campos      = "clientes.id_cliente, clientes.nombre_cliente, clientes.direccion_cliente, clientes.telefono_cliente, clientes.email_cliente, facturas.id_vendedor, facturas.fecha_factura, facturas.condiciones, facturas.estado_factura, facturas.numero_factura";
    $sql_factura = mysqli_query($conexion, "select $campos from facturas, clientes where facturas.id_cliente=clientes.id_cliente and id_factura='" . $id_factura . "'");
    $count       = mysqli_num_rows($sql_factura);
    if ($count == 1) {
        $rw_factura                 = mysqli_fetch_array($sql_factura);
        $id_cliente                 = $rw_factura['id_cliente'];
        $nombre_cliente             = $rw_factura['nombre_cliente'];
        $direccion_cliente          = $rw_factura['direccion_cliente'];
        $telefono_cliente           = $rw_factura['telefono_cliente'];
        $email_cliente              = $rw_factura['email_cliente'];
        $id_vendedor_db             = $rw_factura['id_vendedor'];
        $fecha_factura              = date("d/m/Y", strtotime($rw_factura['fecha_factura']));
        $condiciones                = $rw_factura['condiciones'];
        $estado_factura             = $rw_factura['estado_factura'];
        $numero_factura             = $rw_factura['numero_factura'];
        $_SESSION['id_factura']     = $id_factura;
        $_SESSION['numero_factura'] = $numero_factura;
    } else {
        header("location: facturas.php");
        exit;
    }
} else {
    header("location: facturas.php");
    exit;
}

?>
<page pageset='new' backtop='10mm' backbottom='10mm' backleft='20mm' backright='20mm' style="font-size: 11pt; font-family: arial" footer='page'>
<?php include "res/encabezado_factura.php";?>
    <br>
    <table cellspacing="0" style="width: 45%; text-align: left;border: 1px solid #0A122A;-moz-border-radius: 13px;-webkit-border-radius: 12px;padding: 10px;">
        <tr>
            <td style="width:50%;" class='midnight-blue'>FACTURAR A</td>
        </tr>
        <tr>
            <td style="width:50%;" >
                <?php
echo $nombre_cliente;
echo "<br>";
echo $direccion_cliente;
echo "<br> Teléfono: ";
echo $telefono_cliente;
echo "<br> Email: ";
echo $email_cliente;
?>

            </td>
        </tr>


    </table>

    <br>
    <table cellspacing="0" style="width: 100%; text-align: left;border: 1px solid #0A122A;-moz-border-radius: 13px;-webkit-border-radius: 12px;padding: 10px;">
        <tr>
            <td style="width:35%;" class='midnight-blue'>VENDEDOR</td>
            <td style="width:25%;" class='midnight-blue'>FECHA</td>
            <td style="width:40%;" class='midnight-blue'>FORMA DE PAGO</td>
        </tr>
        <tr>
            <td style="width:35%;">
                <?php
$sql_user = mysqli_query($conexion, "select * from users where id_users='$id_vendedor_db'");
$rw_user  = mysqli_fetch_array($sql_user);
echo $rw_user['nombre_users'] . " " . $rw_user['apellido_users'];
?>
            </td>
            <td style="width:25%;"><?php echo date("d/m/Y", strtotime($fecha_factura)); ?></td>
            <td style="width:40%;" >
                <?php
if ($condiciones == 1) {echo "Efectivo";} elseif ($condiciones == 2) {echo "Cheque";} elseif ($condiciones == 3) {echo "Transferencia bancaria";} elseif ($condiciones == 4) {echo "Crédito";}
?>
            </td>
        </tr>
    </table>
    <br>

    <table cellspacing="0" style="width: 100%; text-align: left;border: 1px solid #0A122A;-moz-border-radius: 13px;-webkit-border-radius: 12px;padding: 10px;">
        <tr>
            <th style="width: 10%;text-align:center" class='midnight-blue'>CANT.</th>
            <th style="width: 60%" class='midnight-blue'>DESCRIPCION</th>
            <th style="width: 15%;text-align: right" class='midnight-blue'>PRECIO UNIT.</th>
            <th style="width: 15%;text-align: right" class='midnight-blue'>PRECIO TOTAL</th>

        </tr>

        <?php
$nums          = 1;
$impuesto      = get_row('perfil', 'impuesto', 'id_perfil', 1);
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
$sql           = mysqli_query($conexion, "select * from productos, detalle_factura, facturas where productos.id_producto=detalle_factura.id_producto and detalle_factura.numero_factura=facturas.numero_factura and facturas.id_factura='" . $id_factura . "'");

while ($row = mysqli_fetch_array($sql)) {
    $id_producto     = $row["id_producto"];
    $codigo_producto = $row['codigo_producto'];
    $cantidad        = $row['cantidad'];
    $nombre_producto = $row['nombre_producto'];
// control del impuesto por productos.
    /*if ($row['iva_producto'] == 0) {
        $p_venta   = $row['precio_venta'];
        $p_venta_f = number_format($p_venta, 2); //Formateo variables
        $p_venta_r = str_replace(",", "", $p_venta_f); //Reemplazo las comas
        $p_total   = $p_venta_r * $cantidad;
        $p_total_f = number_format($p_total, 2); //Precio total formateado
        $p_total_r = str_replace(",", "", $p_total_f); //Reemplazo las comas

        $sum_total += $p_total_r; //Sumador
        $t_iva = ($sum_total * $impuesto) / 100;
        $t_iva = number_format($t_iva, 2, '.', '');
    }*/
    //end impuesto
    /*$precio_venta   = $row['precio_venta'];
    $precio_venta_f = number_format($precio_venta, 2); //Formateo variables
    $precio_venta_r = str_replace(",", "", $precio_venta_f); //Reemplazo las comas
    $precio_total   = $precio_venta_r * $cantidad;
    $precio_total_f = number_format($precio_total, 2); //Precio total formateado
    $precio_total_r = str_replace(",", "", $precio_total_f); //Reemplazo las comas
    $sumador_total += $precio_total_r; //Sumador*/
    
    $precio_venta   = $row['precio_venta'];
    $precio_venta_f = number_format($precio_venta, 0, '', ''); //Formateo variables
    //$precio_venta_r = str_replace(",", "", $precio_venta_f); //Reemplazo las comas
    $precio_total   = $precio_venta * $cantidad;
    //$final_items    = rebajas($precio_total, $desc_tmp); //Aplicando el descuento
    /*--------------------------------------------------------------------------------*/
    $precio_total_f = number_format($final_items, 0, '', ''); //Precio total formateado
    //$precio_total_r = str_replace(",", "", $precio_total_f); //Reemplazo las comas
    //$sumador_total += $final_items; //Sumador
    $sumador_total += $precio_total; //Sumador
    $subtotal = $sumador_total;
    if ($row['iva_producto'] == 10) {
        //$total_iva = iva($precio_venta);
        $sub_10 += $precio_venta;
        $total_iva10 = $precio_venta/11;
        $total_impuesto10 += ($total_iva10 * $cantidad);
    } elseif ($row['iva_producto'] == 5) {
        $sub_5 += $precio_venta;
        $total_iva5 = $precio_venta/21;
        $total_impuesto5 += ($total_iva5 * $cantidad);
    }else {
        $sub_0 += $precio_venta;
        $total_iva0 = $precio_venta;
        $total_impuesto0 += ($total_iva0 * $cantidad);
    }
    if ($nums % 2 == 0) {
        $clase = "clouds";
    } else {
        $clase = "silver";
    }
    ?>

    <tr>
        <td class='<?php echo $clase; ?>' style="width: 10%; text-align: center"><?php echo $cantidad; ?></td>
        <td class='<?php echo $clase; ?>' style="width: 60%; text-align: left"><?php echo $nombre_producto; ?></td>
        <td class='<?php echo $clase; ?>' style="width: 15%; text-align: right"><?php echo $simbolo_moneda . ' ' . $precio_venta_f; ?></td>
        <td class='<?php echo $clase; ?>' style="width: 15%; text-align: right"><?php echo $simbolo_moneda . ' ' . $precio_total_f; ?></td>

    </tr>

    <?php

    $nums++;
}

$total_factura = $subtotal;
?>

<tr>
    <td colspan="3" style="widtd: 85%; text-align: right;">SUBTOTAL EXENTAS <?php echo $simbolo_moneda; ?> </td>
    <td style="widtd: 15%; text-align: right;"> <?php echo number_format($sub_0, 0, '.', ''); ?></td>
</tr>
<tr>
    <td colspan="3" style="widtd: 85%; text-align: right;">SUBTOTAL 5% <?php echo $simbolo_moneda; ?> </td>
    <td style="widtd: 15%; text-align: right;"> <?php echo number_format($sub_5, 0, '.', ''); ?></td>
</tr>
<tr>
    <td colspan="3" style="widtd: 85%; text-align: right;">SUBTOTAL 10% <?php echo $simbolo_moneda; ?> </td>
    <td style="widtd: 15%; text-align: right;"> <?php echo number_format($sub_10, 0, '.', ''); ?></td>
</tr>
<tr>
    <td colspan="3" style="widtd: 85%; text-align: right;">IVA 5% (<?php echo $impuesto; ?>)% <?php echo $simbolo_moneda; ?> </td>
    <td style="widtd: 15%; text-align: right;"> <?php echo number_format($total_impuesto5, 0, '.', ''); ?></td>
</tr>
<tr>
    <td colspan="3" style="widtd: 85%; text-align: right;">IVA 10% (<?php echo $impuesto; ?>)% <?php echo $simbolo_moneda; ?> </td>
    <td style="widtd: 15%; text-align: right;"> <?php echo number_format($total_impuesto10, 0, '.', ''); ?></td>
</tr>
<tr>
<td colspan="3" style="widtd: 85%; text-align: right;">TOTAL <?php echo $simbolo_moneda; ?> </td>
<td style="widtd: 15%; text-align: right;"> <?php echo number_format($total_factura, 0, '.', ''); ?></td>
</tr>
</table>



<br>
<div style="font-size:11pt;text-align:center;font-weight:bold">Gracias por su compra!</div>




</page>
