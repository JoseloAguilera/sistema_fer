<?php
include 'is_logged.php'; //Archivo verifica que el usario que intenta acceder a la URL esta logueado
/*Inicia validacion del lado del servidor*/
if (empty($_POST['nombre'])) {
    $errors[] = "referencia vacío";
} else if (!empty($_POST['nombre'])) {
    /* Connect To Database*/
    require_once "../db.php";
    require_once "../php_conexion.php";
    // escaping, additionally removing everything that could be (html/javascript-) code
    $nombre     = mysqli_real_escape_string($conexion, (strip_tags($_POST["nombre"], ENT_QUOTES)));
    $serie      = mysqli_real_escape_string($conexion, (strip_tags($_POST["serie"], ENT_QUOTES)));
    $desde      = intval($_POST['desde']);
    $hasta      = intval($_POST['hasta']);
    $long       = intval($_POST['long']);
    $numero_act = intval($_POST['numero_act']);
    $fecha_venc = mysqli_real_escape_string($conexion, (strip_tags($_POST["fecha_venc"], ENT_QUOTES)));
    $estado     = intval($_POST['estado']);
    $date_added = date("Y-m-d H:i:s");
    $users      = intval($_SESSION['id_users']);
    // check if user or email address already exists
    $sql                   = "SELECT * FROM comprobantes WHERE nombre_comp ='" . $nombre . "';";
    $query_check_user_name = mysqli_query($conexion, $sql);
    $query_check_user      = mysqli_num_rows($query_check_user_name);
    if ($query_check_user == true) {
        $errors[] = "Nombre de Comprobante ya está en uso.";
    } else {
        // write new user's data into database
        $insert = mysqli_query($conexion, "INSERT INTO comprobantes VALUES (NULL, '$nombre','$serie','$desde','$hasta','$long','$numero_act','$fecha_venc','$estado')");

        if ($insert) {
            $messages[] = "Comprobante ha sido ingresada con Exito.";
        } else {
            $errors[] = "Lo siento algo ha salido mal intenta nuevamente." . mysqli_error($conexion);
        }
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