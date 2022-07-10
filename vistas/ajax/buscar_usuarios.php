<?php

/*-------------------------
Autor: Delmar Lopez
Web: Softwys.com
Mail: softwysop@gmail.com
---------------------------*/
include 'is_logged.php'; //Archivo verifica que el usario que intenta acceder a la URL esta logueado
/* Connect To Database*/
require_once "../db.php";
require_once "../php_conexion.php";
//Inicia Control de Permisos
include "../permisos.php";
$user_id = $_SESSION['id_users'];
get_cadena($user_id);
$modulo = "Usuarios";
permisos($modulo, $cadena_permisos);
//Finaliza Control de Permisos

$action = (isset($_REQUEST['action']) && $_REQUEST['action'] != null) ? $_REQUEST['action'] : '';
if ($action == 'ajax') {
    // escaping, additionally removing everything that could be (html/javascript-) code
    $q        = mysqli_real_escape_string($conexion, (strip_tags($_REQUEST['q'], ENT_QUOTES)));
    $aColumns = array('nombre_users', 'apellido_users'); //Columnas de busqueda
    $sTable   = "users";
    $sWhere   = "";
    if ($_GET['q'] != "") {
        $sWhere = "WHERE (";
        for ($i = 0; $i < count($aColumns); $i++) {
            $sWhere .= $aColumns[$i] . " LIKE '%" . $q . "%' OR ";
        }
        $sWhere = substr_replace($sWhere, "", -3);
        $sWhere .= ')';
    }
    $sWhere .= " order by id_users desc";
    include 'pagination.php'; //include pagination file
    //pagination variables
    $page      = (isset($_REQUEST['page']) && !empty($_REQUEST['page'])) ? $_REQUEST['page'] : 1;
    $per_page  = 10; //how much records you want to show
    $adjacents = 4; //gap between pages after number of adjacents
    $offset    = ($page - 1) * $per_page;
    //Count the total number of row in your table*/
    $count_query = mysqli_query($conexion, "SELECT count(*) AS numrows FROM $sTable  $sWhere");
    $row         = mysqli_fetch_array($count_query);
    $numrows     = $row['numrows'];
    $total_pages = ceil($numrows / $per_page);
    $reload      = '../html/usuarios.php';
    //main query to fetch the data
    $sql   = "SELECT * FROM  $sTable $sWhere LIMIT $offset,$per_page";
    $query = mysqli_query($conexion, $sql);
    //loop through fetched data
    if ($numrows > 0) {

        ?>
        <div class="table-responsive">
            <table class="table table-sm table-striped">
                <tr  class="info">
                    <th>ID</th>
                    <th>Nombres</th>
                    <th>Usuario</th>
                    <th>Email</th>
                    <th>Agregado</th>
                    <th><span class="pull-right">Acciones</span></th>

                </tr>
                <?php
while ($row = mysqli_fetch_array($query)) {
            $user_id     = $row['id_users'];
            $fullname    = $row['nombre_users'] . " " . $row["apellido_users"];
            $user_name   = $row['usuario_users'];
            $user_email  = $row['email_users'];
            $id_cargo    = $row['cargo_users'];
            $id_sucursal = $row['sucursal_users'];
            $date_added  = date('d/m/Y', strtotime($row['date_added']));

            ?>

                    <input type="hidden" value="<?php echo $row['nombre_users']; ?>" id="nombres<?php echo $user_id; ?>">
                    <input type="hidden" value="<?php echo $row['apellido_users']; ?>" id="apellidos<?php echo $user_id; ?>">
                    <input type="hidden" value="<?php echo $user_name ?>" id="usuario<?php echo $user_id; ?>">
                    <input type="hidden" value="<?php echo $user_email; ?>" id="email<?php echo $user_id; ?>">
                    <input type="hidden" value="<?php echo $id_cargo; ?>" id="cargo<?php echo $user_id; ?>">
                    <input type="hidden" value="<?php echo $id_cargo; ?>" id="cargo<?php echo $user_id; ?>">
                    <input type="hidden" value="<?php echo $id_sucursal; ?>" id="sucursal<?php echo $user_id; ?>">

                    <tr>
                        <td><span class="badge badge-pill badge-purple"><?php echo $user_id; ?></span></td>
                        <td><?php echo $fullname; ?></td>
                        <td ><?php echo $user_name; ?></td>
                        <td ><?php echo $user_email; ?></td>
                        <td><?php echo $date_added; ?></td>

                        <td >
                            <div class="btn-group dropdown">
                                                <button type="button" class="btn btn-warning btn-sm dropdown-toggle waves-effect waves-light" data-toggle="dropdown" aria-expanded="false"> <i class='fa fa-cog'></i> <i class="caret"></i> </button>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                 <?php if ($permisos_editar == 1) {?>
                                                 <a class="dropdown-item" href="#" data-toggle="modal" data-target="#editarUsers" onclick="obtener_datos('<?php echo $user_id; ?>');"><i class='fa fa-edit'></i> Editar</a>
                                                 <a class="dropdown-item" href="#" data-toggle="modal" data-target="#password_edit" onclick="editar_pw('<?php echo $user_id; ?>');"><i class='fa fa-unlock'></i> Cambiar Contraseña</a>
                                                 <?php }
            if ($permisos_eliminar == 1) {?>
                                                 <a class="dropdown-item" href="#" data-toggle="modal" data-target="#dataDelete" data-id="<?php echo $user_id; ?>"><i class='fa fa-trash'></i> Borrar</a>
                                                 <?php }
            ?>


                                             </div>
                                         </div>
                        </td>

                    </tr>
                    <?php
}
        ?>
                <tr>
                    <td colspan=9><span class="pull-right">
                        <?php
echo paginate($reload, $page, $total_pages, $adjacents);
        ?></span></td>
                    </tr>
                </table>
            </div>
            <?php
}
//Este else Fue agregado de Prueba de prodria Quitar
    else {
        ?>
            <div class="alert alert-warning alert-dismissible" role="alert" align="center">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <strong>Aviso!</strong> No hay Registro de Usuarios
          </div>
          <?php
}
// fin else
}
?>