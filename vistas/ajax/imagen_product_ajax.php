
    <?php
include "is_logged.php"; //Archivo comprueba si el usuario esta logueado
/* Connect To Database*/
require_once "../db.php";
require_once "../php_conexion.php";
require_once "../funciones.php";
$query_id = mysqli_query($conexion, "SELECT RIGHT(codigo_producto,6) as product_id FROM productos
  ORDER BY codigo_producto DESC LIMIT 1")
or die('error ' . mysqli_error($conexion));
$count = mysqli_num_rows($query_id);
if ($count != 0) {
    $data_id    = mysqli_fetch_assoc($query_id);
    $product_id = $data_id['product_id'] + 1;
} else {
    $product_id = 1;
}

$buat_id    = str_pad($product_id, 5, STR_PAD_LEFT);
$product_id = "$buat_id";
//$product_id    = intval($_REQUEST['product_id']);
//$product_id    = mysqli_real_escape_string($conexion, (strip_tags($_REQUEST["product_id"], ENT_QUOTES)));
$target_dir    = "../../img/productos/";
$image_name    = time() . "_" . basename($_FILES["imagefile"]["name"]);
$target_file   = $target_dir . $image_name;
$imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
$imageFileZise = $_FILES["imagefile"]["size"];

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
        move_uploaded_file($_FILES["imagefile"]["tmp_name"], $target_file);
        $imagen     = basename($_FILES["imagefile"]["name"]);
        $img_update = "image_path='../../img/productos/$image_name' ";

    } else { $img_update = "";}

    // check if user or email address already exists
    $sql                   = "SELECT * FROM productos WHERE codigo_producto ='" . $product_id . "';";
    $query_check_user_name = mysqli_query($conexion, $sql);
    $query_check_user      = mysqli_num_rows($query_check_user_name);
    $date_added            = date("Y-m-d H:i:s");
    if ($query_check_user == true) {
        $sql              = "UPDATE productos SET $img_update WHERE codigo_producto='$product_id';";
        $query_new_insert = mysqli_query($conexion, $sql);
    } else {
        $sql_pro              = "INSERT INTO productos (codigo_producto, date_added) VALUES ('$product_id','$date_added')";
        $query_new_insert_pro = mysqli_query($conexion, $sql_pro);

        $sql              = "UPDATE productos SET $img_update WHERE codigo_producto='$product_id';";
        $query_new_insert = mysqli_query($conexion, $sql);
    }
    if ($query_new_insert) {
        ?>
                        <img class="thumb-img" width="200" src="../../img/productos/<?php echo $image_name; ?>">
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