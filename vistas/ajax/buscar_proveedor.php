<?php

/*-------------------------
Autor: Delmar Lopez
Web: softwys.com
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
$modulo = "Proveedores";
permisos($modulo, $cadena_permisos);
//Finaliza Control de Permisos

$action = (isset($_REQUEST['action']) && $_REQUEST['action'] != null) ? $_REQUEST['action'] : '';
if ($action == 'ajax') {
    // escaping, additionally removing everything that could be (html/javascript-) code
    $q        = mysqli_real_escape_string($conexion, (strip_tags($_REQUEST['q'], ENT_QUOTES)));
    $aColumns = array('nombre_proveedor', 'fiscal_proveedor'); //Columnas de busqueda
    $sTable   = "proveedores";
    $sWhere   = "";
    if ($_GET['q'] != "") {
        $sWhere = "WHERE (";
        for ($i = 0; $i < count($aColumns); $i++) {
            $sWhere .= $aColumns[$i] . " LIKE '%" . $q . "%' OR ";
        }
        $sWhere = substr_replace($sWhere, "", -3);
        $sWhere .= ')';
    }
    $sWhere .= " order by nombre_proveedor";
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
    $reload      = '../html/proveedores.php';
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
                    <th>Razón Social</th>
                    <th>RUC</th>
                    <th>Dirección</th>
                    <th>Teléfono</th>
                    <th>Estado</th>
                    <th class='text-right'>Acciones</th>

                </tr>
                <?php
while ($row = mysqli_fetch_array($query)) {
            $id_proveedor        = $row['id_proveedor'];
            $nombre_proveedor    = $row['nombre_proveedor'];
            $fiscal_proveedor    = $row['fiscal_proveedor'];
            $web_proveedor       = $row['web_proveedor'];
            $direccion_proveedor = $row['direccion_proveedor'];
            $contacto_proveedor  = $row['contacto_proveedor'];
            $email_proveedor     = $row['email_proveedor'];
            $telefono_proveedor  = $row['telefono_proveedor'];
            $estado_proveedor    = $row['estado_proveedor'];
            $date_added          = date('d/m/Y', strtotime($row['date_added']));
            if ($estado_proveedor == 1) {
                $estado = "<span class='badge badge-success'>Activo</span>";
            } else {
                $estado = "<span class='badge badge-danger'>Inactivo</span>";
            }

            ?>
                    <input type="hidden" value="<?php echo $nombre_proveedor; ?>" id="nombre_proveedor<?php echo $id_proveedor; ?>">
                    <input type="hidden" value="<?php echo $fiscal_proveedor; ?>" id="fiscal_proveedor<?php echo $id_proveedor; ?>">
                    <input type="hidden" value="<?php echo $web_proveedor; ?>" id="web_proveedor<?php echo $id_proveedor; ?>">
                    <input type="hidden" value="<?php echo $direccion_proveedor; ?>" id="direccion_proveedor<?php echo $id_proveedor; ?>">
                    <input type="hidden" value="<?php echo $contacto_proveedor; ?>" id="contacto_proveedor<?php echo $id_proveedor; ?>">
                    <input type="hidden" value="<?php echo $email_proveedor; ?>" id="email_proveedor<?php echo $id_proveedor; ?>">
                    <input type="hidden" value="<?php echo $telefono_proveedor; ?>" id="telefono_proveedor<?php echo $id_proveedor; ?>">
                    <input type="hidden" value="<?php echo $estado_proveedor; ?>" id="estado_proveedor<?php echo $id_proveedor; ?>">

                    <tr>
                    <td><span class="badge badge-purple"><?php echo $id_proveedor; ?></span></td>
                        <td>
                            <a href="#" data-toggle="tooltip" data-placement="top" title="
                            Información de  Contacto<br>
                            <i class='glyphicon glyphicon-user'></i> <?php echo $contacto_proveedor; ?><br>
                            <i class='glyphicon glyphicon-phone'></i> <?php echo $telefono_proveedor; ?><br>
                            <i class='glyphicon glyphicon-envelope'></i> <?php echo $email_proveedor; ?>">
                            <?php echo $nombre_proveedor; ?>
                        </a>
                    </td>
                    <td><?php echo $fiscal_proveedor; ?></td>
                    <td><?php echo $direccion_proveedor; ?></td>
                    <td><?php echo $telefono_proveedor; ?></td>
                    <td><?php echo $estado; ?></td>

                    <td >
                        <div class="btn-group dropdown pull-right">
                            <button type="button" class="btn btn-warning btn-rounded btn-sm waves-effect waves-light" data-toggle="dropdown" aria-expanded="false"> <i class='fa fa-cog'></i> <i class="caret"></i> </button>
                            <div class="dropdown-menu dropdown-menu-right">
                             <?php if ($permisos_editar == 1) {?>
                             <a class="dropdown-item" href="#" data-toggle="modal" data-target="#editarProveedor" onclick="obtener_datos('<?php echo $id_proveedor; ?>');"><i class='fa fa-edit'></i> Editar</a>
                             <?php }
            if ($permisos_eliminar == 1) {?>
                             <a class="dropdown-item" href="#" data-toggle="modal" data-target="#dataDelete" data-id="<?php echo $id_proveedor; ?>"><i class='fa fa-trash'></i> Borrar</a>
                             <?php }?>


                         </div>
                     </div>

                 </td>

             </tr>
             <?php
}
        ?>
         <tr>
            <td colspan="7">
                <span class="pull-right">
                    <?php
echo paginate($reload, $page, $total_pages, $adjacents);
        ?></span>
                </td>
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
      <strong>Aviso!</strong> No hay Registro de Clientes
  </div>
  <?php
}
// fin else
}
?>