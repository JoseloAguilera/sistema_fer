<?php
include 'is_logged.php'; //Archivo verifica que el usario que intenta acceder a la URL esta logueado
/*Inicia validacion del lado del servidor*/
if (empty($_POST['id_proveedor'])) {
    $errors[] = "ID VACIO";
} else if (!empty($_POST['id_proveedor'])) {
    /* Connect To Database*/
    require_once "../db.php";
    require_once "../php_conexion.php";
    //Archivo de funciones PHP
    require_once "../funciones.php";
    $session_id = session_id();
    //Comprobamos si hay archivos en la tabla temporal
    $sql_count = mysqli_query($conexion, "select * from tmp_compra where session_id='" . $session_id . "'");
    $count     = mysqli_num_rows($sql_count);
    if ($count == 0) {
        echo "<script>
  swal('NO HAY PRODUCTOS AGREGADOS EN LA FACTURA', 'INTENTAR DE NUEVO', 'error')
  </script>";
        exit;
    }
    // escaping, additionally removing everything that could be (html/javascript-) code
    $id_proveedor = intval($_POST['id_proveedor']);
    $id_vendedor  = intval($_SESSION['id_users']);
    $users        = intval($_SESSION['id_users']);
    $condiciones  = intval($_POST['condiciones']);
    $factura      = mysqli_real_escape_string($conexion, (strip_tags($_REQUEST["factura"], ENT_QUOTES)));
    $referencia   = mysqli_real_escape_string($conexion, (strip_tags($_REQUEST["ref"], ENT_QUOTES)));
    $resibido     = floatval($_POST['resibido']);
    $fecha        = $_POST["fecha"];
    //Operacion de Creditos
    if ($condiciones == 4) {
        $estado = 2;
    } else {
        $estado = 1;
    }
    // check if numero_factura already exists
    $sql                   = "SELECT * FROM facturas_compras WHERE numero_factura ='" . $factura . "';";
    $query_check_user_name = mysqli_query($conexion, $sql);
    $query_check_factura   = mysqli_num_rows($query_check_user_name);
    if ($query_check_factura == true) {
        echo "<script>
      swal('NUMERO DE FACTURA YA ESTA REGISTRADO', 'Inténtalo de nuevo!', 'error')
  </script>";
        exit;
    }
//Seleccionamos el ultimo compo numero_fatura y aumentamos una
    $sql            = mysqli_query($conexion, "select LAST_INSERT_ID(id_factura) as last from facturas_compras order by id_factura desc limit 0,1 ");
    $rw             = mysqli_fetch_array($sql);
    $numero_factura = $rw['last'] + 1;

    $simbolo_moneda = get_row('perfil', 'moneda', 'id_perfil', 1);

    // consulta principal
    $nums          = 1;
    $impuesto      = get_row('perfil', 'impuesto', 'id_perfil', 1);
    $sumador_total = 0;
    $sum_total     = 0;
    $total_iva0      = 0;
    $total_iva5      = 0;
    $total_iva10      = 0;
    $total_impuesto0 = 0;
    $total_impuesto5 = 0;
    $total_impuesto10 = 0;
    $sub_0=0;
    $sub_5=0;
    $sub_10=0;
    $sql           = mysqli_query($conexion, "select * from productos, tmp_compra where productos.id_producto=tmp_compra.id_producto and tmp_compra.session_id='" . $session_id . "'");
    while ($row = mysqli_fetch_array($sql)) {
        $id_tmp          = $row["id_tmp"];
        $id_producto     = $row["id_producto"];
        $codigo_producto = $row['codigo_producto'];
        $cantidad        = $row['cantidad_tmp'];
        $nombre_producto = $row['nombre_producto'];

        $precio_venta   = $row['costo_tmp'];
        $precio_venta_f = number_format($precio_venta, 0, '', ''); //Formateo variables
        //$precio_venta_r = str_replace(",", "", $precio_venta_f); //Reemplazo las comas
        $precio_total   = $precio_venta * $cantidad;
        $precio_total_f = number_format($precio_total, 0, '', ''); //Precio total formateado
        //$precio_total_r = str_replace(",", "", $precio_total_f); //Reemplazo las comas
        $sumador_total += $precio_total; //Sumador
        if ($row['iva_producto'] == 10) {
            //$total_iva = iva($precio_venta);
            $sub_10 += $precio_venta;
            $total_iva10 = $precio_venta/11;
            $total_impuesto10 += $total_iva10*$cantidad;
        } elseif ($row['iva_producto'] == 5) {
            $sub_5 += $precio_venta;
            $total_iva5 = $precio_venta/21;
            $total_impuesto5 += $total_iva5*$cantidad;
        }else {
            $sub_0 += $precio_venta;
            $total_iva0 = $precio_venta;
            $total_impuesto0 += $total_iva0*$cantidad;
        }

        //Insert en la tabla detalle_factura
        $insert_detail = mysqli_query($conexion, "INSERT INTO detalle_fact_compra VALUES (NULL,'$numero_factura','$factura','$id_producto','$cantidad','$precio_venta')");
        //GURDAMOS LAS ENTRADAS EN EL KARDEX
        $saldo_total = $cantidad * $precio_venta;
        $sql_kardex  = mysqli_query($conexion, "select * from kardex where producto_kardex='" . $id_producto . "' order by id_kardex DESC LIMIT 1");
        $rww         = mysqli_fetch_array($sql_kardex);
        //$id_producto = $rww['id_producto'];
        $cant_saldo = $rww['cant_saldo'] + $cantidad;
        //$nueva_cantidad = $cant_saldo - $cantidad;
        //$nuevo_saldo    = $cant_saldo * $precio_venta;
        $saldo_full     = ($rww['total_saldo'] + $saldo_total);
        $costo_promedio = ($rww['total_saldo'] + $saldo_total) / $cant_saldo;
        $tipo           = 1;

        guardar_entradas($fecha, $id_producto, $cantidad, $precio_venta, $saldo_total, $cant_saldo, $costo_promedio, $saldo_full, $fecha, $users, $tipo);
        //ACTUALIZA EN EL STOCK
        $sql2    = mysqli_query($conexion, "select * from productos where id_producto='" . $id_producto . "'");
        $rw      = mysqli_fetch_array($sql2);
        $old_qty = $rw['stock_producto']; //Cantidad encontrada en el inventario
        $new_qty = $old_qty + $cantidad; //Nueva cantidad en el inventario
        $update  = mysqli_query($conexion, "UPDATE productos SET stock_producto='" . $new_qty . "' WHERE id_producto='" . $id_producto . "'"); //Actualizo la nueva cantidad en el inventario
        $update  = mysqli_query($conexion, "UPDATE productos SET costo_producto='" . $precio_venta . "' WHERE id_producto='" . $id_producto . "'"); //Actualizo el nuevo costo de producto

        $nums++;
    }

    $subtotal         = number_format($sumador_total, 0, '', '');
   // $total_iva        = ($subtotal * $impuesto) / 100;
   // $total_iva        = number_format($total_iva, 2, '.', '');
    $total_factura    = $sumador_total; //+ $total_iva
    $saldo_credito    = $total_factura - $resibido;
    $resibido_formato = number_format($resibido, 0, '', '.');
    $date             = date("Y-m-d H:i:s");

    if ($condiciones == 4) {
        $insert_prima = mysqli_query($conexion, "INSERT INTO credito_proveedor VALUES (NULL,'$factura','$date','$id_proveedor','$total_factura','$saldo_credito','1','$users','1')");
        $insert_abono = mysqli_query($conexion, "INSERT INTO creditos_abonos_prov VALUES (NULL,'$factura','$date','$id_proveedor','$total_factura','$resibido','$saldo_credito','$users','1','CREDITO INICAL')");
    }

    $insert = mysqli_query($conexion, "INSERT INTO facturas_compras VALUES (NULL,'$factura','$fecha','$id_proveedor','$id_vendedor','$condiciones','$total_factura','$estado','$users','1','$referencia')");
    $delete = mysqli_query($conexion, "DELETE FROM tmp_compra WHERE session_id='" . $session_id . "'");
    // SI TODO ESTA CORRECTO
    if ($condiciones == 4) {
        echo "<script>
       swal('COMPRA GUARDADA AL CREDITO CON ATICIPO DE: $simbolo_moneda $resibido_formato', 'Factura: $factura', 'success')
  </script>";
        exit;
    }
    if ($insert_detail) {
        $messages[] = "Compra  ha sido Guardada satisfactoriamente.";
    } else {
        $errors[] = "Lo siento algo ha salido mal intenta nuevamente." . mysqli_error($conexion);
    }
} else {
    $errors[] = "Error desconocido.";
}

if (isset($errors)) {

    ?>
    <div class="alert alert-danger" role="alert">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong>Error!</strong>
        <?php
foreach ($errors as $error) {
        echo $error;
    }
    ?>
    </div>
    <?php
}
if (isset($messages)) {

    ?>
    <div class="alert alert-success" role="alert">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong>¡Bien hecho!</strong>
        <?php
foreach ($messages as $message) {
        echo $message;
    }
    ?>
    </div>
    <?php
}

?>