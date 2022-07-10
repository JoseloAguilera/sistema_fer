<?php
include 'is_logged.php'; //Archivo verifica que el usario que intenta acceder a la URL esta logueado
/*Inicia validacion del lado del servidor*/
if (empty($_POST['id_consulta'])) {
    $errors[] = "ID vacío";
} else if (!empty($_POST['id_consulta'])) {
    /* Connect To Database*/
    require_once "../db.php";
    require_once "../php_conexion.php";
    // escaping, additionally removing everything that could be (html/javascript-) code
    $id_consulta = intval($_POST['id_consulta']);
    $monto       = floatval($_POST['monto']);
    $date_added  = date("Y-m-d H:i:s");
    $users       = intval($_SESSION['id_users']);

    $tySql       = "SELECT consultas.id_paciente FROM consultas WHERE consultas.id_consulta = " . $id_consulta . "";
    $tyData      = $conexion->query($tySql);
    $data        = $tyData->fetch_array();
    $id_paciente = $data['id_paciente'];

    $sql = "INSERT INTO ingresos (id_consulta, id_paciente, monto, fecha_added, users)
                             VALUES ('$id_consulta','$id_paciente','$monto','$date_added','$users')";
    #$query_new_insert = mysqli_query($conexion, $sql);
    $paciente_id = '';
    if ($conexion->query($sql) === true) {
        $paciente_id          = $conexion->insert_id;
        $valid['id_consulta'] = $paciente_id;
    }

    // actualizamos el estado de la consulta
    $updateProductTable = "UPDATE consultas SET estado_consulta = '1' WHERE id_consulta = " . $id_consulta . "";
    $conexion->query($updateProductTable);

    if ($paciente_id) {
        $messages[] = "Pago ha sido ingresado con Exito.";
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