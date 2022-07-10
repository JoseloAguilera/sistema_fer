<?php
/*-----------------------
Autor: Delmar Lopez
http://www.softwys.com
Fecha: 27-02-2016
Version de PHP: 5.6.3
----------------------------*/
include 'is_logged.php'; //Archivo verifica que el usario que intenta acceder a la URL esta logueado
/* Connect To Database*/
require_once "../db.php";
require_once "../php_conexion.php";
//Inicia Control de Permisos
include "../permisos.php";
$user_id = $_SESSION['id_users'];
get_cadena($user_id);
$modulo = "Permisos";
permisos($modulo, $cadena_permisos);
/*Inicia validacion del lado del servidor*/
$id      = $_REQUEST["id_usuario"];
$user_id = intval($id);
if ($user_id != 1) {
    if (empty($_POST['id_usuario'])) {
        $errors[] = "ID vacío";
    } else if (
        !empty($_POST['id_usuario'])

    ) {
        // escaping, additionally removing everything that could be (html/javascript-) code
        $id_usuario = intval($_POST['id_usuario']);
        $query      = mysqli_query($conexion, "select * from facturas_ventas where id_users_factura='" . $id_usuario . "'");
        $count      = mysqli_num_rows($query);
        if ($count == 0) {
            if ($delete1 = mysqli_query($conexion, "DELETE FROM users WHERE id_users='" . $id_usuario . "'")) {
                ?>
      <div class="alert alert-success alert-dismissible" role="alert">
        <strong>Aviso!</strong> Datos eliminados exitosamente.
      </div>
      <?php
} else {
                ?>
      <div class="alert alert-danger alert-dismissible" role="alert">
        <strong>Error!</strong> Lo siento algo ha salido mal intenta nuevamente.
      </div>
      <?php

            }

        } else {
            ?>
    <div class="alert alert-danger alert-dismissible" role="alert">
      <strong>Error!</strong> No se pudo eliminar éste Usuario. Existe Información vinculadas a éste Usuario.
    </div>
    <?php
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
}} else {

    ?>
<div class="alert alert-danger alert-dismissible" role="alert">
      <strong>Error!</strong> No se puede eliminar el Usuario por default..
    </div>
  <?php
}

?>