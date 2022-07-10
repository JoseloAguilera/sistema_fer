<?php
include 'is_logged.php'; //Archivo verifica que el usario que intenta acceder a la URL esta logueado
// checking for minimum PHP version
if (version_compare(PHP_VERSION, '5.3.7', '<')) {
    exit("Sorry, Simple PHP Login does not run on a PHP version smaller than 5.3.7 !");
} else if (version_compare(PHP_VERSION, '5.5.0', '<')) {
    // if you are using PHP 5.3 or PHP 5.4 you have to include the password_api_compatibility_library.php
    // (this library adds the PHP 5.5 password hashing functions to older versions of PHP)
    require_once "../libraries/password_compatibility_library.php";
}
if (empty($_POST['firstname2'])) {
    $errors[] = "Nombres vacíos";
} elseif (empty($_POST['lastname2'])) {
    $errors[] = "Apellidos vacíos";
} elseif (empty($_POST['user_name2'])) {
    $errors[] = "Nombre de usuario vacío";
} else if ($_POST['sucursal2'] == "") {
    $errors[] = "Selecciona una Sucursal";
} elseif (strlen($_POST['user_name2']) > 64 || strlen($_POST['user_name2']) < 2) {
    $errors[] = "Nombre de usuario no puede ser inferior a 2 o más de 64 caracteres";
} elseif (!preg_match('/^[a-z\d]{2,64}$/i', $_POST['user_name2'])) {
    $errors[] = "Nombre de usuario no encaja en el esquema de nombre: Sólo aZ y los números están permitidos , de 2 a 64 caracteres";
} elseif (empty($_POST['user_email2'])) {
    $errors[] = "El correo electrónico no puede estar vacío";
} elseif (strlen($_POST['user_email2']) > 64) {
    $errors[] = "El correo electrónico no puede ser superior a 64 caracteres";
} elseif (!filter_var($_POST['user_email2'], FILTER_VALIDATE_EMAIL)) {
    $errors[] = "Su dirección de correo electrónico no está en un formato de correo electrónico válida";
} elseif (
    !empty($_POST['user_name2'])
    && !empty($_POST['firstname2'])
    && !empty($_POST['lastname2'])
    && strlen($_POST['user_name2']) <= 64
    && strlen($_POST['user_name2']) >= 2
    && preg_match('/^[a-z\d]{2,64}$/i', $_POST['user_name2'])
    && !empty($_POST['user_email2'])
    && strlen($_POST['user_email2']) <= 64
    && filter_var($_POST['user_email2'], FILTER_VALIDATE_EMAIL)
) {
    require_once "../db.php";
    require_once "../php_conexion.php";
    // escaping, additionally removing everything that could be (html/javascript-) code
    $firstname  = mysqli_real_escape_string($conexion, (strip_tags($_POST["firstname2"], ENT_QUOTES)));
    $lastname   = mysqli_real_escape_string($conexion, (strip_tags($_POST["lastname2"], ENT_QUOTES)));
    $user_name  = mysqli_real_escape_string($conexion, (strip_tags($_POST["user_name2"], ENT_QUOTES)));
    $user_email = mysqli_real_escape_string($conexion, (strip_tags($_POST["user_email2"], ENT_QUOTES)));
    $sucursal   = intval($_POST['sucursal2']);
    $grupo      = intval($_POST['user_group_id2']);
    $user_id    = intval($_POST['mod_id']);

    // write new user's data into database
    $sql = "UPDATE users SET nombre_users='" . $firstname . "',
                            apellido_users='" . $lastname . "',
                            usuario_users='" . $user_name . "',
                            email_users='" . $user_email . "',
                            cargo_users='" . $grupo . "',
                            sucursal_users='" . $sucursal . "'
                            WHERE id_users='" . $user_id . "';";
    $query_update = mysqli_query($conexion, $sql);

    // if user has been added successfully
    if ($query_update) {
        $messages[] = "La cuenta ha sido modificada con éxito.";
    } else {
        $errors[] = "Lo sentimos , el registro falló. Por favor, regrese y vuelva a intentarlo.";
    }

} else {
    $errors[] = "Un error desconocido ocurrió.";
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