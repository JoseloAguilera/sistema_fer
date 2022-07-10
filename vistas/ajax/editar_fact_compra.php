<?php
include 'is_logged.php'; //Archivo verifica que el usario que intenta acceder a la URL esta logueado
$id_factura = $_SESSION['id_factura'];
/*Inicia validacion del lado del servidor*/
if (empty($_POST['id_proveedor'])) {
    $errors[] = "ID vacío";
} else if (empty($_POST['condiciones'])) {
    $errors[] = "Selecciona forma de pago";
} else if ($_POST['estado_factura'] == "") {
    $errors[] = "Selecciona el estado de la factura";
} else if (
    !empty($_POST['id_proveedor']) &&
    !empty($_POST['condiciones']) &&
    $_POST['estado_factura'] != ""
) {
    /* Connect To Database*/
    require_once "../db.php"; //Contiene las variables de configuracion para conectar a la base de datos
    require_once "../php_conexion.php"; //Contiene funcion que conecta a la base de datos
    // escaping, additionally removing everything that could be (html/javascript-) code
    $id_proveedor = intval($_POST['id_proveedor']);
    $condiciones  = intval($_POST['condiciones']);

    $estado_factura = intval($_POST['estado_factura']);

    $sql          = "UPDATE facturas_compras SET id_proveedor='" . $id_proveedor . "', condiciones='" . $condiciones . "', estado_factura='" . $estado_factura . "' WHERE id_factura='" . $id_factura . "'";
    $query_update = mysqli_query($conexion, $sql);
    if ($query_update) {
        $messages[] = "Datos del Proveedor actualizado con exito!.";
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