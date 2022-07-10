<?php

function get_cadena($user_id_iws)
{

    global $conexion, $cadena_permisos;

    $sql = "select * from  user_group,users where user_group.user_group_id=users.cargo_users and users.id_users='" . $user_id_iws . "' ";

    $query_user = mysqli_query($conexion, $sql);

    $row = mysqli_fetch_array($query_user);

    $cadena_permisos = $row['permission'];

    return $cadena_permisos;

}

function permisos($modulo, $cadena)
{

    global $modulo_permisos, $permisos_ver, $permisos_editar, $permisos_eliminar;

    $count_search = strlen($modulo) + 6;

    $inicio = stripos($cadena, $modulo);

    if (is_numeric($inicio)) {

        $cadena = substr($cadena, $inicio, $count_search);

        list($modulo_permisos, $permisos_ver, $permisos_editar, $permisos_eliminar) = explode(",", $cadena);

    }

}

function permisos_menu($modulo, $cadena)
{

    global $modulo_permisos_menu, $permisos_ver_menu, $permisos_editar_menu, $permisos_eliminar_menu;

    $count_search = strlen($modulo) + 6;

    $inicio = stripos($cadena, $modulo);

    if (is_numeric($inicio)) {

        $cadena = substr($cadena, $inicio, $count_search);

        list($modulo_permisos_menu, $permisos_ver_menu, $permisos_editar_menu, $permisos_eliminar_menu) = explode(",", $cadena);

    }

}
