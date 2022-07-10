<?php
include 'is_logged.php'; //Archivo verifica que el usario que intenta acceder a la URL esta logueado
/*Inicia validacion del lado del servidor*/
if (empty($_POST['mod_id'])) {
    $errors[] = "ID vacío";
} else if (
    !empty($_POST['mod_id'])
) {
    /* Connect To Database*/
    require_once "../db.php";
    require_once "../php_conexion.php";
    // escaping, additionally removing everything that could be (html/javascript-) code
    $nombre     = mysqli_real_escape_string($conexion, (strip_tags($_POST["nombre2"], ENT_QUOTES)));
    $serie      = mysqli_real_escape_string($conexion, (strip_tags($_POST["serie2"], ENT_QUOTES)));
    $desde      = intval($_POST['desde2']);
    $hasta      = intval($_POST['hasta2']);
    $long       = intval($_POST['long2']);
    $numero_act = intval($_POST['num_actual2']);
    $fecha_venc = mysqli_real_escape_string($conexion, (strip_tags($_POST["fecha_venc2"], ENT_QUOTES)));
    $estado     = intval($_POST['estado2']);
    $id_comp    = intval($_POST['mod_id']);
    $sql        = "UPDATE comprobantes SET  nombre_comp='" . $nombre . "',
                                serie_comp='" . $serie . "',
                                desde_comp='" . $desde . "',
                                hasta_comp='" . $hasta . "',
                                long_comp='" . $long . "',
                                actual_comp='" . $numero_act . "',
                                vencimiento_comp='" . $fecha_venc . "',
                                estado_comp='" . $estado . "'
                                WHERE id_comp='" . $id_comp . "'";
    $query_update = mysqli_query($conexion, $sql);
    if ($query_update) {
        $messages[] = "Comprobante ha sido actualizada con Exito.";
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