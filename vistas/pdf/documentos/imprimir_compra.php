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
    $id_factura = intval($_POST['id_factura']);
    $campos     = "proveedores.id_proveedor, proveedores.nombre_proveedor, proveedores.direccion_proveedor, proveedores.telefono_proveedor, proveedores.email_proveedor, facturas_compras.id_vendedor, facturas_compras.fecha_factura, facturas_compras.condiciones, facturas_compras.estado_factura, facturas_compras.numero_factura";

    $sql_factura = mysqli_query($conexion, "select $campos from facturas_compras, proveedores where facturas_compras.id_proveedor=proveedores.id_proveedor and facturas_compras.id_factura='" . $id_factura . "'");
    $count       = mysqli_num_rows($sql_factura);
    if ($count == 1) {
        $rw_factura                 = mysqli_fetch_array($sql_factura);
        $id_proveedor               = $rw_factura['id_proveedor'];
        $nombre_proveedor           = $rw_factura['nombre_proveedor'];
        $direccion_proveedor        = $rw_factura['direccion_proveedor'];
        $telefono_proveedor         = $rw_factura['telefono_proveedor'];
        $email_proveedor            = $rw_factura['email_proveedor'];
        $id_vendedor_db             = $rw_factura['id_vendedor'];
        $fecha_factura              = date("d/m/Y", strtotime($rw_factura['fecha_factura']));
        $condiciones                = $rw_factura['condiciones'];
        $estado_factura             = $rw_factura['estado_factura'];
        $numero_factura             = $rw_factura['numero_factura'];
        $_SESSION['id_factura']     = $id_factura;
        $_SESSION['numero_factura'] = $numero_factura;
    } else {
        header("location: compra.php");
        exit;
    }
} else {
    header("location: compra.php");
    exit;
}

?>

<page pageset='new' backtop='10mm' backbottom='10mm' backleft='20mm' backright='20mm' style="font-size: 11pt; font-family: arial" footer='page'>
<?php include "encabezado_factura.php";?>
    <br>
    <table cellspacing="0" style="width: 45%; text-align: left;border: 1px solid #0A122A;-moz-border-radius: 13px;-webkit-border-radius: 12px;padding: 10px;">
        <tr>
            <td style="width:50%;" class='midnight-blue'>PROVEEDOR</td>
        </tr>
        <tr>
            <td style="width:50%;" >
                <?php
echo $nombre_proveedor;
echo "<br>";
echo $direccion_proveedor;
echo "<br> Teléfono: ";
echo $telefono_proveedor;
echo "<br> Email: ";
echo $email_proveedor;
?>

            </td>
        </tr>


    </table>

    <br>
    <table cellspacing="0" style="width: 100%; text-align: left;border: 1px solid #0A122A;-moz-border-radius: 13px;-webkit-border-radius: 12px;padding: 10px;">
        <tr>
            <td style="width:35%;" class='midnight-blue'>USUARIO</td>
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
            <th style="width: 15%;text-align: right" class='midnight-blue'>COSTO UNIT.</th>
            <th style="width: 15%;text-align: right" class='midnight-blue'>PRECIO TOTAL</th>

        </tr>

        <?php
$nums          = 1;
$sumador_total = 0;
$sql           = mysqli_query($conexion, "select * from productos, detalle_fact_compra, facturas_compras where productos.id_producto=detalle_fact_compra.id_producto and detalle_fact_compra.numero_factura=facturas_compras.numero_factura and facturas_compras.id_factura='" . $id_factura . "'");

while ($row = mysqli_fetch_array($sql)) {
    $id_producto     = $row["id_producto"];
    $codigo_producto = $row['codigo_producto'];
    $cantidad        = $row['cantidad'];
    $nombre_producto = $row['nombre_producto'];

    $precio_costo   = $row['precio_costo'];
    $precio_costo_f = number_format($precio_costo, 2); //Formateo variables
    $precio_costo_r = str_replace(",", "", $precio_costo_f); //Reemplazo las comas
    $precio_total   = $precio_costo_r * $cantidad;
    $precio_total_f = number_format($precio_total, 2); //Precio total formateado
    $precio_total_r = str_replace(",", "", $precio_total_f); //Reemplazo las comas
    $sumador_total += $precio_total_r; //Sumador
    if ($nums % 2 == 0) {
        $clase = "clouds";
    } else {
        $clase = "silver";
    }
    ?>

        <tr>
            <td class='<?php echo $clase; ?>' style="width: 10%; text-align: center"><?php echo $cantidad; ?></td>
            <td class='<?php echo $clase; ?>' style="width: 60%; text-align: left"><?php echo $nombre_producto; ?></td>
            <td class='<?php echo $clase; ?>' style="width: 15%; text-align: right"><?php echo $simbolo_moneda . '' . $precio_costo_f; ?></td>
            <td class='<?php echo $clase; ?>' style="width: 15%; text-align: right"><?php echo $simbolo_moneda . '' . $precio_total_f; ?></td>

        </tr>

    <?php

    $nums++;
}
$impuesto      = get_row('perfil', 'impuesto', 'id_perfil', 1);
$subtotal      = number_format($sumador_total, 2, '.', '');
$total_iva     = ($subtotal * $impuesto) / 100;
$total_iva     = number_format($total_iva, 2, '.', '');
$total_factura = $subtotal;
?>

        <tr>
            <td colspan="3" style="widtd: 85%; text-align: right;">SUBTOTAL <?php echo $simbolo_moneda; ?> </td>
            <td style="widtd: 15%; text-align: right;"> <?php echo number_format($subtotal, 2); ?></td>
        </tr>
        <tr>
            <td colspan="3" style="widtd: 85%; text-align: right;">IVA (<?php echo $impuesto; ?>)% <?php echo $simbolo_moneda; ?> </td>
            <td style="widtd: 15%; text-align: right;"> <?php echo number_format(0, 2); ?></td>
        </tr><tr>
            <td colspan="3" style="widtd: 85%; text-align: right;">TOTAL <?php echo $simbolo_moneda; ?> </td>
            <td style="widtd: 15%; text-align: right;"> <?php echo number_format($total_factura, 2); ?></td>
        </tr>
    </table>



<br>
<div style="text-align:center;font-weight:bold">Gracias por su compra!</div>




</page>
