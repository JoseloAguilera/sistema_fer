<?php
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
//Finaliza Control de Permisos
if (isset($_REQUEST["id"])) {
//codigo para eliminar
    $id            = $_REQUEST["id"];
    $user_group_id = intval($id);
    if ($user_group_id != 1) {
        if ($permisos_eliminar == 1) {
//Si cuenta por los permisos bien
            $sql_user = mysqli_query($conexion, "select * from users where user_group_id='$user_group_id'");
            $num_user = mysqli_num_rows($sql_user);
            if ($num_user > 0) {
                $aviso  = "Aviso!";
                $msj    = "No se puede borrar este grupo de usuarios. Existen usuarios vinculados a este grupo.";
                $classM = "alert alert-danger";
                $times  = "&times;";
            } else if ($num_user == 0) {
                if ($delete = mysqli_query($conexion, "DELETE FROM user_group WHERE user_group_id='$user_group_id'")) {
                    $aviso  = "Bien hecho!";
                    $msj    = "Datos eliminados satisfactoriamente.";
                    $classM = "alert alert-success";
                    $times  = "&times;";
                } else {
                    $aviso  = "Aviso!";
                    $msj    = "Error al eliminar los datos " . mysqli_error($conexion);
                    $classM = "alert alert-danger";
                    $times  = "&times;";
                }

            }
        } else {
//No cuenta con los permisos
            $aviso  = "Acceso denegado!";
            $msj    = "No cuentas con los permisos necesario para acceder a este módulo.";
            $classM = "alert alert-danger";
            $times  = "&times;";
        }
    } else {
        $aviso  = "Aviso!";
        $msj    = "No se puede eliminar el el grupo de usuario super administrador.";
        $classM = "alert alert-danger";
        $times  = "&times;";
    }
}
$action = (isset($_REQUEST['action']) && $_REQUEST['action'] != null) ? $_REQUEST['action'] : '';
if ($action == 'ajax') {
    $query  = mysqli_real_escape_string($conexion, (strip_tags($_REQUEST['query'], ENT_QUOTES)));
    $tables = "user_group";
    $campos = "user_group.user_group_id, user_group.name, user_group.date_added";
    $sWhere = " user_group.name LIKE '%" . $query . "%'";

    include 'pagination.php'; //include pagination file
    //pagination variables
    $page      = (isset($_REQUEST['page']) && !empty($_REQUEST['page'])) ? $_REQUEST['page'] : 1;
    $per_page  = 10; //how much records you want to show
    $adjacents = 4; //gap between pages after number of adjacents
    $offset    = ($page - 1) * $per_page;
    //Count the total number of row in your table*/
    $count_query = mysqli_query($conexion, "SELECT count(*) AS numrows FROM $tables where $sWhere ");
    if ($row = mysqli_fetch_array($count_query)) {$numrows = $row['numrows'];} else {echo mysqli_error($conexion);}
    $total_pages = ceil($numrows / $per_page);
    $reload      = './permisos.php';
    //main query to fetch the data
    $query = mysqli_query($conexion, "SELECT $campos FROM  $tables where $sWhere LIMIT $offset,$per_page");
    //loop through fetched data

    if (isset($_REQUEST["id"])) {
        ?>
        <div class="<?php echo $classM; ?>">
            <button type="button" class="close" data-dismiss="alert"><?php echo $times; ?></button>
            <strong><?php echo $aviso ?> </strong>
            <?php echo $msj; ?>
        </div>
        <?php
}

    if ($numrows > 0) {

        ?>

        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-body">
                        <div class="table-responsive">
                            <table class="table table-sm table-striped">
                                <tr class="success">
                                    <th>ID</th>
                                    <th>Nivel Administrador </th>
                                    <th>Agregado</th>
                                    <th>Usuarios</th>
                                    <th>Acciones</th>
                                </tr>
                                <?php
$finales = 0;
        while ($row = mysqli_fetch_array($query)) {
            $user_group_id     = $row['user_group_id'];
            $name              = $row['name'];
            $user              = mysqli_query($conexion, "select * from users where cargo_users='$user_group_id'");
            $num               = mysqli_num_rows($user);
            $date_added        = $row['date_added'];
            list($date, $hora) = explode(" ", $date_added);
            list($Y, $m, $d)   = explode("-", $date);
            $fecha             = $d . "-" . $m . "-" . $Y;
            $finales++;
            ?>
                                    <tr>
                                        <td><span class="badge badge-pill badge-purple"><?php echo $user_group_id; ?></span></td>
                                        <td><?php echo $name; ?></td>
                                        <td><?php echo $fecha; ?></td>
                                        <td><span class="badge badge-pill badge-info"><?php echo $num; ?></span></td>
                                        <td>

                                            <div class="btn-group dropdown">
                                                <button type="button" class="btn btn-warning btn-sm dropdown-toggle waves-effect waves-light" data-toggle="dropdown" aria-expanded="false"> <i class='fa fa-cog'></i> <i class="caret"></i> </button>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                 <?php if ($permisos_editar == 1) {?>
                                                 <a class="dropdown-item" href="#" data-toggle="modal" data-target="#editarGrupo" onclick="editar('<?php echo $user_group_id; ?>');"><i class='fa fa-edit'></i> Editar</a>
                                                 <?php }
            if ($permisos_eliminar == 1) {?>
                                                 <a class="dropdown-item" href="#" data-toggle="modal" data-target="#dataDelete" data-id="<?php echo $user_group_id; ?>"><i class='fa fa-trash'></i> Borrar</a>
                                                 <?php }
            ?>


                                             </div>
                                         </div>
                                     </td>
                                 </tr>
                                 <?php }?>
                                 <tr>
                                    <td colspan='5'><span class="pull-right">
                                        <?php
$inicios = $offset + 1;
        $finales += $inicios - 1;
        echo "Mostrando $inicios al $finales de $numrows registros";
        echo paginate($reload, $page, $total_pages, $adjacents);
        ?></span>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div><!-- /.box-body -->

                </div><!-- /.box -->
            </div><!-- /.col -->
        </div><!-- /.row -->
        <?php
}
}
?>

