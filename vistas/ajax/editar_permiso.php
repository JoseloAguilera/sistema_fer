<?php
include 'is_logged.php'; //Archivo verifica que el usario que intenta acceder a la URL esta logueado
/* Connect To Database*/
require_once "../db.php"; //Contiene las variables de configuracion para conectar a la base de datos
require_once "../php_conexion.php"; //Contiene funcion que conecta a la base de datos
$id = base64_decode($_POST["user_group_id"]);
if (empty($_POST["nombres"])) {
    $errors[] = "Nombres vacío";
} else if ($id == 1) {
    $errors[] = "No se pueden editar los permisos del grupo de usuario super administrador.";
} elseif (!empty($_POST['nombres'])) {

    $user_group_id = intval($id);
    $num           = 1;
    $sql           = "select * from modulos";
    $q             = mysqli_query($conexion, $sql);
    $num_md        = mysqli_num_rows($q);
    $num           = 0;
    $permisos_url  = "";
    while ($num < $num_md) {
        $perm          = "permisos_" . $num;
        $view          = "view_" . $num;
        $edit          = "edit_" . $num;
        $del           = "del_" . $num;
        $permisosfiles = @$_POST[$perm];
        $permisosview  = @$_POST[$view];
        $permisosedit  = @$_POST[$edit];
        $permisosdel   = @$_POST[$del];
        if (empty($permisosview)) {$permisosview = 0;}
        if (empty($permisosedit)) {$permisosedit = 0;}
        if (empty($permisosdel)) {$permisosdel = 0;}
        $permisos_url .= $permisosfiles . "," . $permisosview . "," . $permisosedit . "," . $permisosdel . ";";
        $num++;
    }
    $permisos_url;
    // escaping, additionally removing everything that could be (html/javascript-) code
    $nombres    = mysqli_real_escape_string($conexion, (strip_tags($_POST['nombres'], ENT_QUOTES)));
    $date_added = date("Y-m-d H:i:s");
    // update data into database
    $sql = "UPDATE user_group SET name='" . $nombres . "', permission='" . $permisos_url . "'
        WHERE user_group_id='" . $user_group_id . "';";
    $query_update = mysqli_query($conexion, $sql);
    // if user has been added successfully
    if ($query_update) {
        $messages[] = "Cargo ha sido actualizado satisfactoriamente.";
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