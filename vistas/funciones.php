<?php
function get_row($table, $row, $id, $equal)
{
    global $conexion;
    $query = mysqli_query($conexion, "select $row from $table where $id='$equal'");
    $rw    = mysqli_fetch_array($query);
    $value = $rw[$row];
    return $value;
}

function condicion($tipo)
{
    if ($tipo == 1) {
        return 'Efectivo';
    } elseif ($tipo == 2) {
        return 'Cheque';
    } elseif ($tipo == 3) {
        return 'Transferencia bancaria';
    } elseif ($tipo == 4) {
        return 'Crédito';
    }
}
/*--------------------------------------------------------------*/
/* MODIFICAR LOS DATOS DEL GRAFICO
/*--------------------------------------------------------------*/
function monto($table, $mes, $periodo)
{
    global $conexion;
    $fecha_inicial = "$periodo-$mes-1";
    if ($mes == 1 or $mes == 3 or $mes == 5 or $mes == 7 or $mes == 8 or $mes == 10 or $mes == 12) {
        $dia_fin = 31;
    } else if ($mes == 2) {
        if ($periodo % 4 == 0) {
            $dia_fin = 29;
        } else {
            $dia_fin = 28;
        }
    } else {
        $dia_fin = 30;
    }
    $fecha_final = "$periodo-$mes-$dia_fin";

    $query = mysqli_query($conexion, "select sum(monto_factura) as monto from $table where fecha_factura between '$fecha_inicial' and '$fecha_final'");
    $row   = mysqli_fetch_array($query);
    $monto = floatval($row['monto']);
    return $monto;
}
function stock($stock)
{
    if ($stock == 0) {
        return '<span class="badge badge-danger">' . $stock . '</span>';
    } else if ($stock <= 3) {
        return '<span class="badge badge-warning">' . $stock . '</span>';
    } else {
        return '<span class="badge badge-primary">' . $stock . '</span>';
    }
}
/*--------------------------------------------------------------*/
/* Funcion para obtener el total de Pacientes
/*--------------------------------------------------------------*/
function total_clientes()
{
    global $conexion;
    $orderSql       = "SELECT * FROM clientes";
    $orderQuery     = $conexion->query($orderSql);
    $countPacientes = $orderQuery->num_rows;

    echo '' . $countPacientes . '';
}
/*--------------------------------------------------------------*/
/* Funcion para obtener el total de Creditos
/*--------------------------------------------------------------*/
function total_creditos()
{
    $id_moneda    = get_row('perfil', 'moneda', 'id_perfil', 1);
    $fecha_actual = date('Y-m-d');
    global $conexion;
    $orderSql     = "SELECT * FROM facturas_ventas where date(fecha_factura) = '$fecha_actual' and estado_factura=2";
    $orderQuery   = $conexion->query($orderSql);
    $totalRevenue = 0;
    while ($orderResult = $orderQuery->fetch_assoc()) {
        $totalRevenue += $orderResult['monto_factura'];
    }

    echo '' . $id_moneda . ' ' . number_format($totalRevenue, 0,"",".") . '';
}
/*--------------------------------------------------------------*/
/* Funcion para obtener el total de Abonos a proveedores
/*--------------------------------------------------------------*/
function total_cxp()
{
    $id_moneda    = get_row('perfil', 'moneda', 'id_perfil', 1);
    $fecha_actual = date('Y-m-d');
    global $conexion;
    //---------------------------------------------------------------------------------------
    $abonoSql    = "SELECT * FROM creditos_abonos_prov where date(fecha_abono) = '$fecha_actual'";
    $abonoQuery  = $conexion->query($abonoSql);
    $total_abono = 0;
    while ($abonoResult = $abonoQuery->fetch_assoc()) {
        $total_abono += $abonoResult['abono'];
    }

    echo '' . $id_moneda . ' ' . number_format($total_abono, 0,"",".") . '';
}
/*--------------------------------------------------------------*/
/* Funcion para obtener el total de Abonos a proveedores
/*--------------------------------------------------------------*/
function total_cxc()
{
    $id_moneda    = get_row('perfil', 'moneda', 'id_perfil', 1);
    $fecha_actual = date('Y-m-d');
    global $conexion;
    //---------------------------------------------------------------------------------------
    $abonoSql    = "SELECT * FROM creditos_abonos where date(fecha_abono) = '$fecha_actual'";
    $abonoQuery  = $conexion->query($abonoSql);
    $total_abono = 0;
    while ($abonoResult = $abonoQuery->fetch_assoc()) {
        $total_abono += $abonoResult['abono'];
    }

    echo '' . $id_moneda . ' ' . number_format($total_abono, 0,"",".") . '';
}
/*--------------------------------------------------------------*/
/* Funcion para obtener el total de Ingresos
/*--------------------------------------------------------------*/
function total_ingresos()
{
    $id_moneda    = get_row('perfil', 'moneda', 'id_perfil', 1);
    $fecha_actual = date('Y-m-d');
    global $conexion;
    $orderSql     = "SELECT * FROM facturas_ventas where date(fecha_factura) = '$fecha_actual'";
    $orderQuery   = $conexion->query($orderSql);
    $totalRevenue = 0;
    while ($orderResult = $orderQuery->fetch_assoc()) {
        $totalRevenue += $orderResult['monto_factura'];
    }

    echo '' . $id_moneda . ' ' . number_format($totalRevenue, 0,"",".") . '';
}
/*--------------------------------------------------------------*/
/* Funcion para obtener el total de Egresos
/*--------------------------------------------------------------*/
function total_egresos()
{
    $id_moneda    = get_row('perfil', 'moneda', 'id_perfil', 1);
    $fecha_actual = date('Y-m-d');
    global $conexion;
    $orderSql    = "SELECT * FROM facturas_compras where date(fecha_factura) = '$fecha_actual'";
    $orderQuery  = $conexion->query($orderSql);
    $totalEgreso = 0;
    while ($orderResult = $orderQuery->fetch_assoc()) {
        $totalEgreso += $orderResult['monto_factura'];
    }

    echo '' . $id_moneda . ' ' . number_format($totalEgreso, 0,"",".") . '';
}
/*--------------------------------------------------------------*/
/* Funcion para obtener el total de Inventario Bajo
/*--------------------------------------------------------------*/
function poner_inventario()
{
    global $conexion;
    $lowStockSql   = "SELECT * FROM productos WHERE stock_producto <= 3 AND estado_producto = 1";
    $lowStockQuery = $conexion->query($lowStockSql);

    echo '' . $countLowStock . '';
}
/*--------------------------------------------------------------*/
/* Funcion para obtener las Ultimas Ventas
/*--------------------------------------------------------------*/
function latest_order()
{
    global $conexion;
    $id_moneda = get_row('perfil', 'moneda', 'id_perfil', 1);

    $sql = mysqli_query($conexion, "select * from facturas_ventas where id_cliente >0 order by  id_factura desc limit 0,5");
    while ($rw = mysqli_fetch_array($sql)) {
        $id_factura     = $rw['id_factura'];
        $numero_factura = $rw['numero_factura'];

        $supplier_id       = $rw['id_cliente'];
        $sql_s             = mysqli_query($conexion, "select nombre_cliente from clientes where id_cliente='" . $supplier_id . "'");
        $rw_s              = mysqli_fetch_array($sql_s);
        $supplier_name     = $rw_s['nombre_cliente'];
        $date_added        = $rw['fecha_factura'];
        list($date, $hora) = explode(" ", $date_added);
        list($Y, $m, $d)   = explode("-", $date);
        $fecha             = $d . "-" . $m . "-" . $Y;
        $total             = number_format($rw['monto_factura'], 0,"",".");
        ?>
        <tr>
            <td><a href="editar_venta.php?id_factura=<?php echo $id_factura; ?>" data-toggle="tooltip" title="Ver Factura"><label class='badge badge-primary'><?php echo $numero_factura; ?></label></a></td>
            <td><?php echo $fecha; ?></td>
            <td class='text-left'><b><?php echo $id_moneda . ' ' . $total; ?></b></td>
        </tr>
        <?php

    }
}
/*--------------------------------------------------------------*/
/* Funcion para obtener el total de Ventas del Vendedor
/*--------------------------------------------------------------*/
function venta_users()
{
    $id_moneda    = get_row('perfil', 'moneda', 'id_perfil', 1);
    $fecha_actual = date('Y-m-d');
    $users        = intval($_SESSION['id_users']);
    global $conexion;
    $orderSql   = "SELECT * FROM facturas_ventas where id_users_factura = '$users' and date(fecha_factura) = '$fecha_actual'";
    $orderQuery = $conexion->query($orderSql);
    $countOrder = $orderQuery->num_rows;

    $totalRevenue = 0;
    while ($orderResult = $orderQuery->fetch_assoc()) {
        $totalRevenue += $orderResult['monto_factura'];
    }

    echo '' . $id_moneda . ' ' . number_format($totalRevenue, 0,"",".") . '';
}
/*--------------------------------------------------------------*/
/* Calculo del Descuento
/*--------------------------------------------------------------*/
function rebajas($base, $dto = 0)
{
    $ahorro = ($base * $dto) / 100;
    $final  = $base - $ahorro;
    return $final;
}
/*--------------------------------------------------------------*/
/* Control de Stock
/*--------------------------------------------------------------*/
function guardar_historial($id_producto, $user_id, $fecha, $nota, $reference, $quantity, $tipo)
{
    global $conexion;
    $sql = "INSERT INTO historial_productos (id_historial, id_producto, id_users, fecha_historial, nota_historial, referencia_historial, cantidad_historial, tipo_historial)
  VALUES (NULL, '$id_producto', '$user_id', '$fecha', '$nota', '$reference', '$quantity','$tipo');";
    $query = mysqli_query($conexion, $sql);

}
/*--------------------------------------------------------------*/
/* Consulta si producto maneja stock
/*--------------------------------------------------------------*/
function consulta_inv_stock($id_producto)
{
    global $conexion;
    $consulta2 = mysqli_query($conexion, "select inv_producto from productos where id_producto='$id_producto'");
    $consulta2 =  mysqli_fetch_row($consulta2);
    //var_dump($consulta2[0]);
    return($consulta2[0]);
    

}
/*--------------------------------------------------------------*/
/* Ajuste de stock AGREGAR
/*--------------------------------------------------------------*/
function agregar_stock($id_producto, $quantity)
{
    global $conexion;
    $update = mysqli_query($conexion, "update productos set stock_producto=stock_producto+'$quantity' where id_producto='$id_producto' and inv_producto=0");
    if ($update) {
        return 1;
    } else {
        return 0;
    }

}

function consulta_stock($id_producto){
    
    global $conexion;
    $qty = mysqli_query($conexion, "select stock_producto from productos where id_producto='$id_producto'");
    $qty = mysqli_fetch_row($qty);
    $return = $qty[0];
    //var_dump($return);
    return  $return;
}

/*--------------------------------------------------------------*/
/* Ajuste de stock DISMINUIR
/*--------------------------------------------------------------*/
function eliminar_stock($id_producto, $quantity)
{
    global $conexion;
    $update = mysqli_query($conexion, "update productos set stock_producto=stock_producto-'$quantity' where id_producto='$id_producto' and inv_producto=0");
    if ($update) {
        return 1;
    } else {
        return 0;
    }

}
/*--------------------------------------------------------------*/
/* Control de KARDEX
/*--------------------------------------------------------------*/
function guardar_salidas($fecha, $id_producto, $cant_salida, $costo_salida, $total_salida, $cant_saldo, $costo_saldo, $total_saldo, $fecha_added, $users, $tipo)
{
    global $conexion;
    $sql = "INSERT INTO kardex (fecha_kardex, producto_kardex, cant_salida, costo_salida, total_salida, cant_saldo, costo_saldo, total_saldo, added_kardex, users_kardex, tipo_movimiento)
  VALUES ('$fecha','$id_producto','$cant_salida','$costo_salida','$total_salida', '$cant_saldo','$costo_saldo','$total_saldo','$fecha_added','$users','$tipo');";
    $query = mysqli_query($conexion, $sql);

}
function guardar_entradas($fecha, $id_producto, $cant_entrada, $costo_entrada, $total_entrada, $cant_saldo, $costo_promedio, $total_saldo, $fecha_added, $users, $tipo)
{
    global $conexion;
    $sql = "INSERT INTO kardex (fecha_kardex, producto_kardex, cant_entrada, costo_entrada, total_entrada, cant_saldo, costo_saldo, total_saldo, added_kardex, users_kardex, tipo_movimiento)
  VALUES ('$fecha','$id_producto','$cant_entrada','$costo_entrada','$total_entrada', '$cant_saldo','$costo_promedio','$total_saldo','$fecha_added','$users','$tipo');";
    $query = mysqli_query($conexion, $sql);

}
function formato($valor)
{
    return number_format($valor, 2);
    //return number_format($valor, 2, '.', '.');
}
function iva($sin_iva)
{
    $iva     = get_row('perfil', 'impuesto', 'id_perfil', 1);
    $con_iva = $sin_iva + ($iva * ($sin_iva / 100));
    $con_iva = round($con_iva, 2) - $sin_iva;
    return $con_iva;
}
