<?php
/*-----------------------
Autor: Delmar Lopez
http://www.softwys.com
Fecha: 03-01-2018
Version de PHP: 7.0.0
----------------------------*/
include 'is_logged.php'; //Archivo verifica que el usario que intenta acceder a la URL esta logueado
/* Connect To Database*/
require_once "../db.php";
require_once "../php_conexion.php";
/*Inicia validacion del lado del servidor*/
if (empty($_POST['id_credito'])) {
    $errors[] = "ID vacío";
} else if (
    !empty($_POST['id_credito'])

) {
    if (isset($_POST['id_credito'])) {
        $id_credito = intval($_POST['id_credito']);
        $del1       = "delete from creditos where id_credito ='" . $id_credito . "'";
        //$del2       = "delete from detalle_fact_ventas where id_factura='" . $id_factura . "'";
        if ($delete1 = mysqli_query($conexion, $del1) and $delete2 = mysqli_query($conexion, $del2)) {
            ?>
      <div class="alert alert-success alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <strong>Aviso!</strong> Datos eliminados exitosamente
      </div>
      <?php
} else {
            ?>
      <div class="alert alert-danger alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <strong>Error!</strong> No se puedo eliminar los datos
      </div>
      <?php

        }
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

?>