<?php
include 'is_logged.php'; //Archivo verifica que el usario que intenta acceder a la URL esta logueado
$id_producto = $_SESSION['id'];
/*Inicia validacion del lado del servidor*/
if (empty($_POST['quantity'])) {
    $errors[] = "Cantidad vacía";
} else if (!empty($_POST['quantity'])) {
    /* Connect To Database*/
    require_once "../db.php";
    require_once "../php_conexion.php";
    require_once "../funciones.php";
    // escaping, additionally removing everything that could be (html/javascript-) code
    $quantity  = intval($_POST['quantity']);
    $reference = mysqli_real_escape_string($conexion, (strip_tags($_POST["reference"], ENT_QUOTES)));
    $motivo    = mysqli_real_escape_string($conexion, (strip_tags($_POST["motivo"], ENT_QUOTES)));
    $user_id   = $_SESSION['id_users'];
    $nota      = "agregó $quantity producto(s) al inventario";
    $fecha     = date("Y-m-d H:i:s");
    $tipo      = 1;
    guardar_historial($id_producto, $user_id, $fecha, $nota, $reference, $quantity, $tipo, $motivo);
    $update = agregar_stock($id_producto, $quantity);

    //GURDAMOS LAS ENTRADAS EN EL KARDEX
    //$costo_producto = get_row('productos', 'moneda', 'id_perfil', 1);
    $sql_kardex  = mysqli_query($conexion, "select * from kardex where producto_kardex='" . $id_producto . "' order by id_kardex DESC LIMIT 1");
    $rww         = mysqli_fetch_array($sql_kardex);
    $costo       = $rww['costo_saldo'];
    $saldo_total = $quantity * $costo;
    $cant_saldo  = $rww['cant_saldo'] + $quantity;
    //$nueva_cantidad = $cant_saldo - $cantidad;
    //$nuevo_saldo    = $cant_saldo * $precio_venta;
    $saldo_full     = ($rww['total_saldo'] + $saldo_total);
    $costo_promedio = ($rww['total_saldo'] + $saldo_total) / $cant_saldo;
    $tip            = 3;
    guardar_entradas($fecha, $id_producto, $quantity, $costo, $saldo_total, $cant_saldo, $costo_promedio, $saldo_full, $fecha, $user_id, $tip);
    if ($update) {
        $messages[] = "El Stock  ha sido ingresado satisfactoriamente.";
    } else {
        $errors[] = "Lo siento algo ha salido mal intenta nuevamente." . mysqli_error($conexion);
    }
} else {
    $errors[] = "Error desconocido.";
}

if (isset($errors)) {

    ?>
    <div class="alert alert-danger" role="alert">
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