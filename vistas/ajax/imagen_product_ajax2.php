
    <?php
include "is_logged.php"; //Archivo comprueba si el usuario esta logueado
/* Connect To Database*/
require_once "../db.php";
require_once "../php_conexion.php";

$product_id    = intval($_REQUEST['id_producto']);
$target_dir    = "../../img/productos/";
$image_name    = time() . "_" . basename($_FILES["imagefile_mod"]["name"]);
$target_file   = $target_dir . $image_name;
$imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
$imageFileZise = $_FILES["imagefile_mod"]["size"];

/* Inicio Validacion*/
// Allow certain file formats
if (($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") and $imageFileZise > 0) {
    $errors[] = "<p>Lo sentimos, sólo se permiten archivos JPG , JPEG, PNG y GIF.</p>";
} else if ($imageFileZise > 1048576) {
//1048576 byte=1MB
    $errors[] = "<p>Lo sentimos, pero el archivo es demasiado grande. Selecciona logo de menos de 1MB</p>";
} else if (empty($product_id)) {
    $errors[] = "<p>ID del producto está vacío.</p>";
} else {

    /* Fin Validacion*/
    if ($imageFileZise > 0) {
        move_uploaded_file($_FILES["imagefile_mod"]["tmp_name"], $target_file);
        $imagen     = basename($_FILES["imagefile_mod"]["name"]);
        $img_update = "image_path = '../../img/productos/$image_name' ";

    } else { $img_update = "";}

    $sql              = "UPDATE productos SET $img_update WHERE id_producto = $product_id;";
    $query_new_insert = mysqli_query($conexion, $sql);

    if ($query_new_insert) {
        ?>
                        <img class="thumb-img" src="../../img/productos/<?php echo $image_name; ?>">
                        <?php
} else {
        $errors[] = "Lo sentimos, actualización falló. Intente nuevamente. " . mysqli_error($conexion);
    }

}

?>

    <?php
if (isset($errors)) {
    ?>
                                        <div class="alert alert-danger">
                                            <strong>Error! </strong>
                                            <?php
foreach ($errors as $error) {
        echo $error;
    }
    ?>
                                        </div>
                                            <?php
}
?>
                                    <?php
if (isset($messages)) {
    ?>
                                        <div class="alert alert-success">
                                            <strong>Aviso! </strong>
                                            <?php
foreach ($messages as $message) {
        echo $message;
    }
    ?>
                                        </div>
                                            <?php
}
?>