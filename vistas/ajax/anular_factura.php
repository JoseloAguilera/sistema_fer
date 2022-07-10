<?php
/*-----------------------
Autor: Delmar Lopez
http://www.softwys.com
----------------------------*/
include 'is_logged.php'; //Archivo verifica que el usario que intenta acceder a la URL esta logueado
/* Connect To Database*/
require_once "../db.php";
require_once "../php_conexion.php";
//Inicia Control de Permisos
include "../permisos.php";
$user_id = $_SESSION['id_users'];
get_cadena($user_id);
$modulo = "Ventas";
permisos($modulo, $cadena_permisos);
/*Inicia validacion del lado del servidor*/
if (empty($_POST['id_factura'])) {
    $errors[] = "ID vacío";
} else if (
    !empty($_POST['id_factura'])

) {
    $id_factura = intval($_POST['id_factura']);
    if ($anular = mysqli_query($conexion, "UPDATE facturas_ventas SET estado_factura=0, monto_factura=0 WHERE id_factura='$id_factura'")) {

        //ELIMINA DE LA TABLA DETALLE(FACTURA)
        //$delete = mysqli_query($conexion, "DELETE FROM facturas WHERE numero_factura='" . $numero_factura . "'");
        $anul = mysqli_query($conexion, "UPDATE detalle_fact_ventas SET importe_venta=0 WHERE id_factura='$id_factura'")
        //FIN
        ?>

       <div class="alert alert-success alert-dismissible" role="alert">
          <strong>Aviso!</strong> Factura Anulada exitosamente.
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

?>